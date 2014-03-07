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
	var infos = {"candidate" : {
		editPage: "/editCandidate.php",
		selectOptions: {"school": "School", "grad_date": "Grad Date", "major" : "Major", "gpa" : "GPA", "offer_status" : "Offer Status"},
		dataType: "candidateData"
		}
	};
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
			graph.listHeading.text(graph.info.selectOptions[option] + " - " + label);
			for(var i = 0; i < data.length; ++i) {
				graph.list.append("li").append("a").attr("href",graph.info.editPage + "#" + data[i].id).text(data[i].name);
			}
		}
	}

	function countData(id, data) {
		var dataCount = {};
		for(var i = 0; i < data.length; ++i) {
			var curId = data[i][id];
			if(!dataCount[curId]) {
				dataCount[curId] = {count: 1, data: [data[i]]};
			}
			else {
				dataCount[curId].count++;
				dataCount[curId].data.push(data[i]);
			}
		}
		return dataCount;
	}

	function getPieGraphMaker(graph) {
		return function(id, data) {
			graph.curLabel = null;
			var handlers = {"click": function(option, label, data) {
				populateList(graph, option, label, data);
			}};
			var dataCount = countData(id, data);
			var width = 500;
			var height = 500;
			var radius = 250;
			
			var color = d3.scale.category10()
				.domain(Object.keys(dataCount));

			var pie  = d3.layout.pie()
				.sort(null)
				.value(function(id) { return dataCount[id].count});

			var arc = d3.svg.arc()
		    .outerRadius(radius - 10)
		    .innerRadius(0);

			var svg = graph.svg
		    .attr("width", width)
		    .attr("height", height)
		  	.append("g")
		    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

		    var g = svg.selectAll(".arc")
		    .data(pie(Object.keys(dataCount)))
		    .enter()
		    .append("g").attr("class", "arc");


		    var path = g.append("path")
		      .attr("d", arc)
		      .style("fill", function(d) { return color(d.data); });
		    for(var e in handlers) {
		    	path.on(e, function(d) {
		    		handlers[e](id, d.data, dataCount[d.data].data);
		    	});
		    }

		  	g.append("text")
		      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
		      .attr("dy", ".35em")
		      .style("text-anchor", "middle")
		      .text(function(d) { return d.data; });
	  	}
	}

	function getSelector(graph) {
		return function(data) {
			var select = graph.select.on("change", function() { graph.dispatch.optionchange(this.value, data[graph.info.dataType]) });

			select.selectAll("option")
				.data(Object.keys(graph.info.selectOptions))
				.enter().append("option")
				.attr("value", function(d) { return d; })
				.text(function(d) { return graph.info.selectOptions[d]; });
		}
	}


	function initPieGraph(graph) {
		graph.dispatch = d3.dispatch("load", "optionchange");
		graph.dispatch.on("optionchange.pie", getPieGraphMaker(graph));
		graph.dispatch.on("load.menu", getSelector(graph));
		graph.dispatch.load(data);
		graph.dispatch.optionchange(Object.keys(graph.info.selectOptions)[0], data[graph.info.dataType]);
	}

	function createGraph(info) {
		var graph = d3.select("main").append("div");
		var select = graph.append("select");
		var svg = graph.append("svg");
		var listContainer = graph.append("div");
		var listHeading = graph.append("h");
		var list = graph.append("ul");
		return {"info" : info, "select" : select, "svg" : svg, "listContainer" : listContainer, "listHeading" : listHeading, "list" : list};
	}

	initPieGraph(createGraph(infos.candidate));

</script>
<?php include('footer.php'); ?>