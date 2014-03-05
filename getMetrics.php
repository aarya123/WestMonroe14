<?php include('header.php'); ?>
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<svg id="svg"></svg>
<h id="offerListHeading"></h>
<ul id="offerList"></ul>
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
	var offerData = <?php include('get_metrics.php'); ?>;
	var curOfferStatus = null;
	showPieChart(offerData, "offer_status", {"mouseover": function(label, data) {
		var offerList = document.getElementById("offerList");
		if(curOfferStatus != label) {
			curOfferStatus = label;
			while(offerList.firstChild) {
				offerList.removeChild(offerList.firstChild);
			}
			document.querySelector("#offerListHeading").innerHTML = label;
			for(var i = 0; i < data.length; ++i) {
				var li = document.createElement('li');
				var a = document.createElement('a');
				a.setAttribute('href', '/editCandidate.php#' + data[i].name);
				a.innerHTML = data[i].name;
				li.appendChild(a);
				offerList.appendChild(li);
			}
		}
		console.log(label, data);
	}});
	

</script>
<?php include('footer.php'); ?>