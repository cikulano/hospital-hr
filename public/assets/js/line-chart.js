function initLineChart() {
	// Find all the elements with the ID "lineChart"
	var lineChartElements = document.querySelectorAll('#lineChart');
  
	// Loop through each "lineChart" element and initialize the chart
	lineChartElements.forEach(function(lineChartElement) {
	  // Check if the element is within a parent container with the class "card-body"
	  var cardBody = lineChartElement.closest('.card-body');
	  if (cardBody) {
		// Line Chart
		var ctx = lineChartElement.getContext('2d');
		var lineChart = new Chart(ctx, {
		  type: 'line',
		  data: {
			labels: ["Jan", "Feb", "Mar", "Apr", "May"],
			datasets: [
			  // Your chart data
			]
		  },
		  options: {
			responsive: true,
			legend: {
			  display: false
			}
		  }
		});
	  } else {
		console.error("The #lineChart element is not within a .card-body container.");
	  }
	});
  }
  
  window.onload = function() {
	initLineChart();
  };