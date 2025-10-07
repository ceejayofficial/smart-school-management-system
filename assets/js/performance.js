function updateSystemPerformance() {
  const percent = Math.floor(Math.random() * 12) + 89; // 89-100%
  document.getElementById("systemCircle").setAttribute("stroke-dasharray", `${percent}, 100`);
  document.getElementById("systemPercent").textContent = `${percent}%`;
}

// Initial run
updateSystemPerformance();

// Update every 1 minute
setInterval(updateSystemPerformance, 10000);

