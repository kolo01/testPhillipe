$(function () {
    "use strict";


	
	// Extra chart
	 Morris.Area({
		element: 'extra-area-chart',
		data: [{
					period: '2023',
					iphone: 0,
					ipad: 0,
					itouch: 0
				}

				],
				lineColors: ['#fd9428', '#fed700', '#0a3eb8', '#2196f3'],
				xkey: 'period',
				ykeys: ['iphone', 'ipad', 'itouch', 'itouch'],
				labels: ['Orange', 'MTN', 'Moov', 'Wave'],
				pointSize: 0,
				lineWidth: 0,
				resize:true,
				fillOpacity: 0.8,
				behaveLikeLine: true,
				gridLineColor: '#e0e0e0',
				hideHover: 'auto'
			
		});
}); 