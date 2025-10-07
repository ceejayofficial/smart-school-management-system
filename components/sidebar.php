

<head>
  <link rel="stylesheet" href="assets/css/sidebar.css">

</head>
<!-- Sidebar Toggle Button -->
<button class="d-md-none p-2" id="sidebarToggle">
  <span id="toggleIcon">☰</span>
</button>
<nav class="sidebar" id="mainSidebar">
  <div>
    <h4>
      <!-- <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="me-2" viewBox="0 0 24 24">
        <path d="M4 17l6-5-6-5v10zm8 0h8v-2h-8v2z" />
      </svg>
      Smart Sender -->
    </h4>

    <ul class="nav flex-column">
      <li class="nav-item">
        <a href="dashboard.php?page=dashboard-home" class="nav-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24">
            <path d="M3 13h8V3H3v10zm10 8h8v-6h-8v6zM3 21h8v-6H3v6zm10-8h8V3h-8v10z" />
          </svg>
          Dashboard  
        </a>
      </li>
      <li class="nav-item">
        <a href="dashboard.php?page=send-sms-form" class="nav-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24">
            <path d="M20 2H4a2 2 0 0 0-2 2v16l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z" />
          </svg>
          Send SMS
        </a>
      </li>
      <li class="nav-item">
        <a href="dashboard.php?page=send_results_form" class="nav-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24">
            <path d="M20 2H4a2 2 0 0 0-2 2v16l4-4h14a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2z" />
          </svg>
          Send Results
        </a>
      </li>
      <!-- <li class="nav-item">
        <a href="dashboard.php?page=create-sender-form" class="nav-link">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24">
            <path d="M7 2C5.9 2 5 2.9 5 4v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2H7zm5 18c-.6 0-1-.4-1-1s.4-1 1-1 1 .4 1 1-.4 1-1 1zm5-3H7V5h10v12z" />
          </svg>

          Senders
        </a>
      </li> -->
      <li class="nav-item">
        <a href="dashboard.php?page=wallet" class="nav-link">
          <!-- Heroicons wallet icon (clean and professional) -->
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 24 24">
            <path d="M2 7a4 4 0 0 1 4-4h12a2 2 0 1 1 0 4H6a2 2 0 0 0-2 2v1h18v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V7z" />
            <circle cx="18" cy="14" r="1.5" fill="white" />
          </svg>
          Wallet
        </a>
      </li>
      <li class="nav-item">
  <a href="dashboard.php?page=branding" class="nav-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-person" viewBox="0 0 16 16">
      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
      <path d="M2 14s-1 0-1-1 1-4 7-4 7 3 7 4-1 1-1 1H2z"/>
    </svg>
    Branding
  </a>
</li>

  
      <li class="nav-item">
  <a href="dashboard.php?page=profile" class="nav-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-person" viewBox="0 0 16 16">
      <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
      <path d="M2 14s-1 0-1-1 1-4 7-4 7 3 7 4-1 1-1 1H2z"/>
    </svg>
    Profile
  </a>
</li>

<li class="nav-item">
  <a href="dashboard.php?page=report" class="nav-link">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" class="bi bi-file-earmark-text" viewBox="0 0 16 16">
      <path d="M5 8.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
      <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zM13.5 5H9a1 1 0 0 1-1-1V.5L13.5 5z"/>
    </svg>
    Report
  </a>
</li>


    </ul>
  </div>

  <!-- Logout Button -->
  <button id="logoutBtn" class="btn btn-outline-light w-100 d-flex align-items-center justify-content-center logout-btn">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="me-2" viewBox="0 0 16 16">
      <path d="M6 13.5a.5.5 0 0 1-.5.5h-4A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h4a.5.5 0 0 1 0 1h-4A.5.5 0 0 0 1 3.5v9a.5.5 0 0 0 .5.5h4a.5.5 0 0 1 .5.5z" />
      <path d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z" />
    </svg>
    Logout
  </button>
</nav>


<script src="assets/js/sidebar.js"></script>
