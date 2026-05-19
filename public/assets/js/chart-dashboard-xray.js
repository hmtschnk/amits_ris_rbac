document.addEventListener("DOMContentLoaded", function () {
    var ctxXray = document.getElementById("xrayPieChart").getContext("2d");

    new Chart(ctxXray, {
        type: 'pie',
        data: {
            labels: Object.keys(get_xray_types),
            datasets: [{
                data: Object.values(get_xray_types),
                backgroundColor: [
                    '#FF6384', // CR
                    '#36A2EB', // DX
                    '#FFCE56', // MG
                    '#4BC0C0', // US
                    '#9966FF', // CT
                    '#FF9F40'  // MR
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});