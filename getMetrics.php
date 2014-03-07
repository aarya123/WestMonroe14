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

	var data = <?php include('get_metrics.php'); ?>;

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

	function filterData(id, data) {
		var filteredData = {};
		for(var i = 0; i < data.length; ++i) {
			var curId = data[i][id];
			if(!filteredData[curId]) {
				filteredData[curId] = {count: 1, data: [data[i]]};
			}
			else {
				filteredData[curId].count++;
				filteredData[curId].data.push(data[i]);
			}
		}
		return filteredData;
	}

	var handlers = {"click": function(graph, option, label, data) {
		populateList(graph, option, label, data);
	}};

	function getSelector(graph) {
		return function(data) {
			var select = graph.select.on("change", function() { graph.dispatch.optionchange(this.value, data[graph.dataType.dataType]) });

			select.selectAll("option")
				.data(Object.keys(graph.dataType.selectOptions))
				.enter().append("option")
				.attr("value", function(d) { return d; })
				.text(function(d) { return graph.dataType.selectOptions[d]; });
		}
	}

	var dataTypes = {"candidate" : {
		editPage: "/editCandidate.php",
		selectOptions: {"school": "School", "grad_date": "Grad Date", "major" : "Major", "gpa" : "GPA", "offer_status" : "Offer Status"},
		dataType: "candidateData"
		}
	};

	var chartTypes = {"pie" : function(graph) {
		return function(id, data) {
			var filteredData = filterData(id, data);
			var width = 500;
			var height = 500;
			var radius = 250;
			
			var color = d3.scale.category10()
				.domain(Object.keys(filteredData));

			var pie  = d3.layout.pie()
				.sort(null)
				.value(function(id) { return filteredData[id].count});

			var arc = d3.svg.arc()
		    .outerRadius(radius - 10)
		    .innerRadius(0);

			var svg = graph.svg
		    .attr("width", width)
		    .attr("height", height)
		  	.append("g")
		    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

		    var g = svg.selectAll(".arc")
		    .data(pie(Object.keys(filteredData)))
		    .enter()
		    .append("g").attr("class", "arc");


		    var path = g.append("path")
		      .attr("d", arc)
		      .style("fill", function(d) { return color(d.data); });
		    for(var e in handlers) {
		    	path.on(e, function(d) {
		    		handlers[e](graph, id, d.data, filteredData[d.data].data);
		    	});
		    }

		  	g.append("text")
		      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
		      .attr("dy", ".35em")
		      .style("text-anchor", "middle")
		      .text(function(d) { return d.data; });
	  	}
	}};


	function createGraph(chartType, dataType) {
		var graphContainer = d3.select("main").append("div");
		graphContainer.style("width", "700px");
		var select = graphContainer.append("select");
		var svg = graphContainer.append("svg");
		var listContainer = graphContainer.append("div");
		listContainer.style("float", "right");
		var listHeading = listContainer.append("h");
		listHeading.style("text-align", "left");
		var list = listContainer.append("ul");
		list.style("max-height", "300px");
		list.style("width", "150px");
		list.style("overflow", "auto");
		var graph = {"chartType" : chartType, "dataType" : dataType, "select" : select, "svg" : svg, "listContainer" : listContainer, "listHeading" : listHeading, "list" : list};
		graph.dispatch = d3.dispatch("load", "optionchange");
		graph.dispatch.on("optionchange", chartTypes[graph.chartType](graph));
		graph.dispatch.on("load.menu", getSelector(graph));
		graph.dispatch.load(data);
		graph.dispatch.optionchange(Object.keys(graph.dataType.selectOptions)[0], data[graph.dataType.dataType]);
	}

	createGraph("pie", dataTypes.candidate);

</script>
<?php include('footer.php'); ?>