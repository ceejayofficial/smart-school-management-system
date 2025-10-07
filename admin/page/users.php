<?php
require_once __DIR__ . '/../../db.php';
include 'get_users.php';
?>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body { background-color: #ffffff; }
    .table thead th { vertical-align: middle; }
    .modal-content { border-radius: 0 !important; }
    .pagination { justify-content: center; }
  </style>
</head>
<body>
  <div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
  <h2 class="fw-bold mb-0 d-flex align-items-center gap-2">
    <!-- Profile Icon -->
    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" viewBox="0 0 24 24">
      <path d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10zm0 12c-4.97 0-9 2.16-9 5v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-1c0-2.84-4.03-5-9-5z" />
    </svg>
    Users
  </h2>
  <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createUserModal">+ Create User</button>
</div>

    <?php include './includes/user_table.php'; ?>
    <?php include './modals/user_modal.php'; ?>
  </div>

  <script src="js/user_actions.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
