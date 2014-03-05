<?php include('header.php'); ?>
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<style>

</style>
<select id="select" onchange="onSelectOption(this.value)"></select>
<svg id="svg"></svg>
<h id="listHeading"></h>
<ul id="list"></ul>

<script>
	function showPieChart(data, id, handlers) {
		var dataCount = {};
		var width = 500;
		var height = 500;
		var radius = 250;
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
		
		var color = d3.scale.category10()
			.domain(Object.keys(dataCount));

		var pie  = d3.layout.pie()
			.sort(null)
			.value(function(id) { return dataCount[id].count});

		var arc = d3.svg.arc()
	    .outerRadius(radius - 10)
	    .innerRadius(0);

		var svg = d3.select("#svg")
	    .attr("width", width)
	    .attr("height", height)
	  	.append("g")
	    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

	    var g = svg.selectAll(".arc")
	    .data(pie(Object.keys(dataCount)))
	    .enter().append("g").attr("class", "arc");

	    var path = g.append("path")
	      .attr("d", arc)
	      .style("fill", function(d) { return color(d.data); });
	    for(var e in handlers) {
	    	path.on(e, function(d) {
	    		handlers[e](d.data, dataCount[d.data].data);
	    	});
	    }

	  	g.append("text")
	      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
	      .attr("dy", ".35em")
	      .style("text-anchor", "middle")
	      .text(function(d) { return d.data; });
	}
	var data = <?php include('get_metrics.php'); ?>;
	var select = document.querySelector('#select');
	for(var i = 0; i < data.select.length; ++i) {
		var option = document.createElement('option');
		option.innerHTML = data.select[i];
		select.appendChild(option);
	}

	function onSelectOption(option) {
		document.querySelector("#svg").style.display = "block";
		var curLabel = null;
		var listHeading = document.querySelector("#listHeading");
		var list = document.querySelector("#list");
		listHeading.innerHTML = "";
		while(list.firstChild) {
			list.removeChild(list.firstChild);
		}
		function mouseover(label, data) {
			if(curLabel != label) {
				curLabel = label;
				while(list.firstChild) {
					list.removeChild(list.firstChild);
				}
				listHeading.innerHTML = label;
				for(var i = 0; i < data.length; ++i) {
					var li = document.createElement('li');
					var a = document.createElement('a');
					a.setAttribute('href', '/editCandidate.php#' + data[i].name);
					a.innerHTML = data[i].name;
					li.appendChild(a);
					list.appendChild(li);
				}
			}
		}
		showPieChart(data.data, option, {"mouseover": mouseover});
	}
	select.selectedIndex = 0;
	onSelectOption(select.options[0].value);

</script>
<?php include('footer.php'); ?>