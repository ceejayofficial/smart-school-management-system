document.addEventListener('DOMContentLoaded', function () {
    const userForm = document.getElementById('userForm');
  
    userForm.addEventListener('submit', function (e) {
      const username = document.getElementById('user-username').value.trim();
      const email = document.getElementById('user-email').value.trim();
      const phone = document.getElementById('user-phone').value.trim();
      const password = document.getElementById('user-password').value;
      const role = document.getElementById('user-role').value;
  
      // Email regex
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  
      // Strong password regex: at least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special char
      const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
  
      // Phone number validation
      const phoneRegex = /^\d{10,15}$/;
  
      let errors = [];
  
      // Username
      if (username.length === 0) {
        errors.push("Username is required.");
      }
  
      // Email
      if (!emailRegex.test(email)) {
        errors.push("Please enter a valid email address.");
      }
  
      // Phone (optional, but if filled, must be valid)
      if (phone && !phoneRegex.test(phone)) {
        errors.push("Phone number must contain only digits (10–15 characters).");
      }
  
      // Password
      if (!strongPasswordRegex.test(password)) {
        errors.push("Password must be at least 8 characters long, include uppercase, lowercase, number, and special character.");
      }
  
      // Role
      if (!role) {
        errors.push("Please select a role.");
      }
  
      // Show errors
      if (errors.length > 0) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Validation Error',
          html: errors.map(e => `<div>${e}</div>`).join(""),
        });
      }
    });
  });
  