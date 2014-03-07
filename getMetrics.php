<?php include('header.php'); ?>
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<style>
/*
#listContainer {
	text-align: left;
	margin-left: 50px;
}
*/

</style>



<!--
<select id="select"></select>
<svg id="svg"></svg>
<div id="listContainer">
	<h id="listHeading" style="margin: 100px"></h>
	<ul id="list"></ul>
</div>
-->



<script>

	var allData = <?php include('get_metrics.php'); ?>;
	var dataTypes = {"candidate" : {
			editPage: "/editCandidate.php",
			selectOptions: {"school": "School", "grad_date": "Grad Date", "major" : "Major", "gpa" : "GPA", "offer_status" : "Offer Status", "attended_count" : "# Events Attended"},
			optionTypes: {"school" : "category", "grad_date": "date", "major" : "category", "gpa" : "number", "offer_status" : "category", "attended_count" : "number"},
			name: "candidateData"
		}
	};
	for(var i = 0; i < allData.eventAttendanceData.length; ++i) {

	}

	var months = {"Jan" : 1, "Feb" : 2, "Mar" : 3, "Apr" : 4, "May" : 5, "Jun" : 6, "Jul" : 7, "Aug" : 8, "Sep" : 9, "Oct" : 10, "Nov" : 11, "Dec" : 12};

	function dateToValid(str) {
		var split = str.split(" ");
		return split[0] + " 1, " + split[1];
	}

	var graphList = [];

	function cmpName(a, b) {
		if(a.name < b.name) {
			return -1;
		}
		else if(a.name > b.name) {
			return 1;
		}
		else {
			return 0;
		}
	}

	function populateList(graph, option, label, data) {
		if(graph.curLabel != label) {
			graph.curLabel = label;
			graph.list.selectAll("li").remove();
			data = data.sort(cmpName);
			graph.listHeading.text(graph.dataType.selectOptions[option] + " - " + label);
			for(var i = 0; i < data.length; ++i) {
				graph.list.append("li").append("a").attr("href",graph.dataType.editPage + "#" + data[i].id).text(data[i].name);
			}
		}
	}

	function countData(id, data) {
		var countedData = {};
		for(var i = 0; i < data.length; ++i) {
			var curId = data[i][id];
			if(!countedData[curId]) {
				countedData[curId] = {count: 1, data: [data[i]]};
			}
			else {
				countedData[curId].count++;
				countedData[curId].data.push(data[i]);
			}
		}
		return countedData;
	}

	function addNextGraph(graph, option, data) {
		var newData = {};
		for(var k in graph.data) {
			newData[k] = graph.data[k];
		}
		newData[graph.dataType.name] = data;
		var newDataType = {};
		for(var k in graph.dataType) {
			newDataType[k] = graph.dataType[k];
		}
		newDataType.selectOptions = {};
		for(var k in graph.dataType.selectOptions) {
			if(k != option) {
				newDataType.selectOptions[k] = graph.dataType.selectOptions[k];
			}
		}
		if(Object.keys(newDataType.selectOptions).length > 0) {
			addGraph(graph.i + 1, newData, graph.chartType, newDataType);
		}
	}

	var handlers = {"click": function(graph, option, label, data) {
		if(graph.dataType.optionTypes[option] != "category") {
			return;
		}
		populateList(graph, option, label, data);
		addNextGraph(graph, option, data);
	}};

	function getSelector(graph) {
		return function(data) {
			data = data[graph.dataType.name];
			var select = graph.select.on("change", function() {
				if(graph.selectContainer) {
					graph.selectContainer.remove();
					delete graph.selectContainer;
				}
				var option = this.value;
				if(graph.dataType.optionTypes[option] == "number") {
					var selectContainer = graph.container.insert("div", "svg");
					var lessValue = selectContainer.append("input").attr("placeholder", "Least Value").attr("type", "number");
					var greatValue = selectContainer.append("input").attr("placeholder", "Greatest Value").attr("type", "number");
					var filterButton = selectContainer.append("button").text("Filter");
					filterButton.on("click", function() {
						var less = parseInt(lessValue[0][0].value), great = parseInt(greatValue[0][0].value);
						if(isNaN(less) || less < 0 || great <= 0 || isNaN(great) || great < less) {
							return;
						}
						var newData = [];
						for(var i = 0; i < data.length; ++i) {
							if(data[i][option] >= less && data[i][option] <= great) {
								newData.push(data[i]);
							}
						}
						if(newData.length > 0) {
							populateList(graph, option, less + " to " + great, newData);
							addNextGraph(graph, option, newData);
						}
					});
					graph.selectContainer = selectContainer;
				}
				else if(graph.dataType.optionTypes[option] == "date") {
					var selectContainer = graph.container.insert("div", "svg");
					var lessValue = selectContainer.append("input").attr("placeholder", "Earliest Date").attr("type", "date");
					var greatValue = selectContainer.append("input").attr("placeholder", "Latest Date").attr("type", "date");
					var filterButton = selectContainer.append("button").text("Filter");
					filterButton.on("click", function() {
						var less = Date.parse(lessValue[0][0].value), great = Date.parse(greatValue[0][0].value);
						console.log(less, great);
						if(isNaN(less) || isNaN(great) || great < less) {
							return;
						}
						var newData = [];
						for(var i = 0; i < data.length; ++i) {
							if(Date.parse(dateToValid(data[i][option])) >= less && Date.parse(dateToValid(data[i][option])) <= great) {
								newData.push(data[i]);
							}
						}
						if(newData.length > 0) {
							populateList(graph, option, lessValue[0][0].value + " to " + greatValue[0][0].value, newData);
							addNextGraph(graph, option, newData);
						}
					});
					graph.selectContainer = selectContainer;
				}
				graph.dispatch.optionchange(option, data);
			});

			select.selectAll("option")
				.data(Object.keys(graph.dataType.selectOptions))
				.enter().append("option")
				.attr("value", function(d) { return d; })
				.text(function(d) { return graph.dataType.selectOptions[d]; });
		}
	}

	var chartTypes = {"pie" : function(graph) {
		return function(id, data) {
			var countedData = countData(id, data);
			var width = 500;
			var height = 500;
			var radius = 250;
			
			var color = d3.scale.category10()
				.domain(Object.keys(countedData));

			var pie  = d3.layout.pie()
				.sort(null)
				.value(function(id) { return countedData[id].count});

			var arc = d3.svg.arc()
		    .outerRadius(radius - 10)
		    .innerRadius(0);

			var svg = graph.svg
		    .attr("width", width)
		    .attr("height", height)
		  	.append("g")
		    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

		    var g = svg.selectAll(".arc")
		    .data(pie(Object.keys(countedData)))
		    .enter()
		    .append("g").attr("class", "arc");


		    var path = g.append("path")
		      .attr("d", arc)
		      .style("fill", function(d) { return color(d.data); });
		    for(var e in handlers) {
		    	path.on(e, function(d) {
		    		handlers[e](graph, id, d.data, countedData[d.data].data);
		    	});
		    }

		  	g.append("text")
		      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
		      .attr("dy", ".35em")
		      .style("text-anchor", "middle")
		      .text(function(d) { return d.data; });
	  	}
	}};

	function removeGraph(graph) {
		graph.container.remove();
	}

	function addGraph(i, data, chartType, dataType) {
		console.log(i, data, chartType, dataType);
		if(i < graphList.length) {
			while(graphList.length != i) {
				removeGraph(graphList[graphList.length - 1]);
				graphList.pop();
			}
		}
		var graphContainer = d3.select("main").append("div");
		graphContainer.style("width", "1000px");
		var select = graphContainer.append("select");
		var svg = graphContainer.append("svg");
		var listContainer = graphContainer.append("div");
		listContainer.style("float", "right");
		var listHeading = listContainer.append("h");
		listHeading.style("text-align", "left");
		var list = listContainer.append("ul");
		list.style("max-height", "300px");
		list.style("width", "200px");
		list.style("overflow", "auto");
		var graph = {"i" : i, "container": graphContainer, "data" : data, "chartType" : chartType, "dataType" : dataType, "select" : select, "svg" : svg, "listContainer" : listContainer, "listHeading" : listHeading, "list" : list};
		graphList[i] = graph;
		graph.dispatch = d3.dispatch("load", "optionchange");
		graph.dispatch.on("optionchange", chartTypes[graph.chartType](graph));
		graph.dispatch.on("load.menu", getSelector(graph));
		graph.dispatch.load(data);
		graph.dispatch.optionchange(Object.keys(graph.dataType.selectOptions)[0], data[graph.dataType.name]);
	}

	addGraph(0, allData, "pie", dataTypes.candidate);

</script>
<?php include('footer.php'); ?>