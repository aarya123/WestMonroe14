<?php include('header.php'); ?>
<script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<svg id="svg"></svg>
<script>
	var offerData = <?php include('get_metrics.php'); ?>;
	var offerDataCount = {};
	var width = 500;
	var height = 500;
	var radius = 250;
	for(var i = 0; i < offerData.length; ++i) {
		var status = offerData[i].offer_status;
		if(!offerDataCount[status]) {
			offerDataCount[status] = 1;
		}
		else {
			offerDataCount[status]++;
		}
	}
	var colors = {"Pending": "red", "No Offer": "green"};

	var pie  = d3.layout.pie()
		.sort(null)
		.value(function(status) { return offerDataCount[status]});

	var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

	var svg = d3.select("#svg")
    .attr("width", width)
    .attr("height", height)
  	.append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

    var g = svg.selectAll(".arc")
    .data(pie(Object.keys(offerDataCount)))
    .enter().append("g").attr("class", "arc");

     g.append("path")
      .attr("d", arc)
      .style("fill", function(d) { return colors[d.data]; });

  	g.append("text")
      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
      .attr("dy", ".35em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.data; });



</script>
<?php include('footer.php'); ?>