/**============================
* 3-Axis JavaScript Graphs
* @author Paul Loh
* @author Jordan Hatcher
============================**/

// Data Range for Graphs
var n = 200,
random = d3.random.normal(0, 0),
data = d3.range(n).map(random),
data2 = d3.range(n).map(random),
data3 = d3.range(n).map(random);

// Dimensions of Graph
var margin = {top: 20, right: 20, bottom: 20, left: 40},
width = 300 - margin.left - margin.right,
height = 300 - margin.top - margin.bottom;

// X-Axis (Domain) Values
var x = d3.scale.linear()
.domain([0, n - 1])
.range([0, width]);

// Y-Axis (Range) Values
var y = d3.scale.linear()
.domain([-300, 300]) 
.range([height, 0]);

// Plotting of line component
var line = d3.svg.line()
.x(function(d, i) { return x(i); })
.y(function(d, i) { return y(d); });

// X graph D3 Components
var svg = d3.select("#X-Coordinate").append("svg")
.attr("width", width + margin.left + margin.right)
.attr("height", height + margin.top + margin.bottom)
.append("g")
.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

svg.append("defs").append("clipPath")
.attr("id", "clip")
.append("rect")
.attr("width", width)
.attr("height", height);

svg.append("g")
.attr("class", "x axis")
.attr("transform", "translate(0," + y(0) + ")")
.call(d3.svg.axis().scale(x).orient("bottom"));

svg.append("g")
.attr("class", "y axis")
.call(d3.svg.axis().scale(y).orient("left"));

var path = svg.append("g")
.attr("clip-path", "url(#clip)")
.append("path")
.datum(data)
.attr("class", "line")
.attr("d", line);

// Y graph D3 Components
var svg2 =d3.select("#Y-Coordinate").append("svg")
.attr("width", width + margin.left + margin.right)
.attr("height", height + margin.top + margin.bottom)
.append("g")
.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

svg2.append("defs").append("clipPath")
.attr("id", "clip2")
.append("rect")
.attr("width", width)
.attr("height", height);

svg2.append("g")
.attr("class", "x axis")
.attr("transform", "translate(0," + y(0) + ")")
.call(d3.svg.axis().scale(x).orient("bottom"));

svg2.append("g")
.attr("class", "y axis")
.call(d3.svg.axis().scale(y).orient("left"));

var path2 = svg2.append("g")
.attr("clip-path", "url(#clip3)")
.append("path")
.datum(data2)
.attr("class", "line")
.attr("d", line);

// Z graph D3 Components
var svg3 =d3.select("#Z-Coordinate").append("svg")
.attr("width", width + margin.left + margin.right)
.attr("height", height + margin.top + margin.bottom)
.append("g")
.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

svg3.append("defs").append("clipPath")
.attr("id", "clip3")
.append("rect")
.attr("width", width)
.attr("height", height);

svg3.append("g")
.attr("class", "x axis")
.attr("transform", "translate(0," + y(0) + ")")
.call(d3.svg.axis().scale(x).orient("bottom"));

svg3.append("g")
.attr("class", "y axis")
.call(d3.svg.axis().scale(y).orient("left"));

var path3 = svg3.append("g")
.attr("clip-path", "url(#clip3)")
.append("path")
.datum(data3)
.attr("class", "line")
.attr("d", line);