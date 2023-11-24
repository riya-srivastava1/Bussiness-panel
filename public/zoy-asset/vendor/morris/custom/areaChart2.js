// Morris Area Chart

Morris.Area({
	element: 'areaChart2',
	data: [
		{ y: '2014', a: 0,  b: 1},
		{ y: '2015', a: 20,  b: 30},
		{ y: '2016', a: 25,  b: 10},
		{ y: '2017', a: 5, b: 2 }
	],
	xkey: 'y',
	ykeys: ['a', 'b'],
	behaveLikeLine: !0,
	pointSize: 0,
	labels: ['Sales', 'Expenses'],
	pointStrokeColors: ['#0063bf', '#007ff5'],
	gridLineColor: "#e4e6f2",
	lineColors: ['#0063bf', '#007ff5'],
	gridtextSize: 10,
	fillOpacity: 0.9,
	lineWidth: 0,
	hideHover: "auto",
	resize: true,
	redraw: true,
});

