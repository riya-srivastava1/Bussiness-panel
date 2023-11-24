// Morris Area Chart

Morris.Area({
	element: 'areaChart',
	data: [
		{ y: '2011', a: 5, b: 0, c: 0 },
		{ y: '2012', a: 40,  b: 15, c: 5 },
		{ y: '2013', a: 15,  b: 50, c: 25 },
		{ y: '2014', a: 40,  b: 15, c: 7 },
		{ y: '2015', a: 20,  b: 30, c: 35 },
		{ y: '2016', a: 35,  b: 55, c: 20 },
		{ y: '2017', a: 5, b: 10, c: 5 }
	],
	xkey: 'y',
	ykeys: ['a', 'b', 'c'],
	behaveLikeLine: !0,
	pointSize: 0,
	labels: ['Sales', 'Expenses', 'Projects'],
	pointStrokeColors: ['#0063bf', '#007ff5', '#62b4ff'],
	gridLineColor: "#e4e6f2",
	lineColors: ['#0063bf', '#007ff5', '#62b4ff'],
	gridtextSize: 10,
	fillOpacity: 0.9,
	lineWidth: 0,
	hideHover: "auto",
	resize: true,
	redraw: true,
});

