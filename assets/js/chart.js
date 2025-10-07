Chart.defaults.animation = false;

document.addEventListener('DOMContentLoaded', () => {
  if (!window.chartData) {
    console.warn("Chart data not available.");
    return;
  }

  // Chart 1 - Doughnut
  const ctx1 = document.getElementById('chartDoughnut1');
  if (ctx1) {
    new Chart(ctx1, {
      type: 'doughnut',
      data: {
        labels: ['Delivered', 'Failed'],
        datasets: [{
          data: [window.chartData.sms_sent_success, window.chartData.sms_sent_failed],
          backgroundColor: ['#4caf50', '#f44336'],
          borderWidth: 0
        }]
      },
      options: {
        cutout: '60%',
        plugins: { legend: { display: false } },
        responsive: true,
        animation: false
      }
    });
  }

  // Chart 2 - Pie
  const ctx2 = document.getElementById('chartPie2');
  if (ctx2) {
    new Chart(ctx2, {
      type: 'pie',
      data: {
        labels: ['Queued', 'Processed'],
        datasets: [{
          data: [12, 18],
          backgroundColor: ['#2196f3', '#ffc107'],
          borderWidth: 0
        }]
      },
      options: {
        plugins: { legend: { display: false } },
        responsive: true,
        animation: false
      }
    });
  }

  // Chart 3 - Doughnut
  const ctx3 = document.getElementById('chartDoughnut3');
  if (ctx3) {
    new Chart(ctx3, {
      type: 'doughnut',
      data: {
        labels: ['Success', 'Error', 'Pending'],
        datasets: [{
          data: [10, 3, 7],
          backgroundColor: ['#9c27b0', '#e91e63', '#00bcd4'],
          borderWidth: 0
        }]
      },
      options: {
        cutout: '60%',
        plugins: { legend: { display: false } },
        responsive: true,
        animation: false
      }
    });
  }
});


const ctxBar = document.getElementById('chartBarUsage').getContext('2d');

new Chart(ctxBar, {
  type: 'bar',
  data: {
    labels: ['Used', 'Remaining'],
    datasets: [{
      label: 'SMS Usage',
      data: [window.smsData.used, Math.max(window.smsData.limit - window.smsData.used, 0)],
      backgroundColor: ['#ff6384', '#36a2eb'],
      borderRadius: 6,
      borderSkipped: false
    }]
  },
  options: {
    indexAxis: 'y',
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        callbacks: {
          label: (ctx) => `${ctx.label}: ${ctx.raw} SMS`
        }
      }
    },
    scales: {
      x: {
        beginAtZero: true,
        ticks: { stepSize: 1 }
      }
    }
  }
});

