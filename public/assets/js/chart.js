document.addEventListener('DOMContentLoaded', function() {

    function initializeCharts() {
        console.log('Initializing charts');
        
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not defined. Make sure it is loaded correctly.');
            return;
        }

        // Bar Chart
        if (document.getElementById('bar-charts')) {
            console.log('Initializing bar chart');
            try {
                new Chart(document.getElementById('bar-charts'), {
                    type: 'bar',
                    data: {
                        labels: ['2006', '2007', '2008', '2009', '2010', '2011', '2012'],
                        datasets: [{
                            label: 'Total Income',
                            data: [100, 75, 50, 75, 50, 75, 100],
                            backgroundColor: '#f43b48'
                        }, {
                            label: 'Total Outcome',
                            data: [90, 65, 40, 65, 40, 65, 90],
                            backgroundColor: '#453a94'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error initializing bar chart:', error);
            }
        } else {
            console.warn('Bar chart container not found');
        }

        // Add similar blocks for line charts and other charts as needed
    }

    // Initialize charts immediately
    initializeCharts();
});
