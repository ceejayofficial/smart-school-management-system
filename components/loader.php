<script>
  // Create the loader dynamically using JS
  const loader = document.createElement('div');
  loader.id = 'page-loader';
  loader.style.position = 'fixed';
  loader.style.top = '0';
  loader.style.left = '0';
  loader.style.width = '100%';
  loader.style.height = '100%';
  loader.style.background = '#ffffffee';
  loader.style.display = 'flex';
  loader.style.alignItems = 'center';
  loader.style.justifyContent = 'center';
  loader.style.zIndex = '100';
  loader.style.transition = 'opacity 0.3s ease';
  loader.innerHTML = `
    <div style="
      width: 50px;
      height: 50px;
      border: 6px solid #ddd;
      border-top: 6px solid #00FF00;
      border-radius: 50%;
      animation: spin 0.3s linear infinite;
    "></div>
    <style>
      @keyframes spin {
        to { transform: rotate(360deg); }
      }
    </style>
  `;
  document.body.appendChild(loader);

  // Hide loader after page fully loads
  window.addEventListener('load', function () {
    loader.style.opacity = '0';
    setTimeout(() => loader.style.display = 'none', 300);
  });

  // Show loader on nav-link click
  document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', function () {
      loader.style.display = 'flex';
      loader.style.opacity = '1';
    });
  });
</script>
