// Displaying X Labels Diagonally (Bar Chart)
var day_data = [
	{"period": "2016-10-01", "licensed": 4, "Bluemoon": 2},
	{"period": "2016-09-30", "licensed": 5, "Bluemoon": 1},
	{"period": "2016-09-29", "licensed": 8, "Bluemoon": 4},
	{"period": "2016-09-20", "licensed": 2, "Bluemoon": 2},
	{"period": "2016-09-19", "licensed": 7, "Bluemoon": 6},
	{"period": "2016-09-18", "licensed": 4, "Bluemoon": 3},
	{"period": "2016-09-17", "licensed": 7, "Bluemoon": 7},
	{"period": "2016-09-16", "licensed": 8, "Bluemoon": 2},
	{"period": "2016-09-15", "licensed": 9, "Bluemoon": 3},
	{"period": "2016-09-10", "licensed": 2, "Bluemoon": 9}
];
Morris.Bar({
	element: 'xLabelsDiagonally',
	data: day_data,
	xkey: 'period',
	ykeys: ['licensed', 'Bluemoon'],
	labels: ['Licensed', 'Bluemoon'],
	xLabelAngle: 60,
	gridLineColor: "#e4e6f2",
	resize: true,
	hideHover: "auto",
	barColors:['#0063bf', '#e5e8f2', '#ff5661'],
});