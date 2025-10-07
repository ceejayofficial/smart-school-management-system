<?php include("src/con/profile-logic.php"); ?>

<div class="p-3 mb-4" style="max-width: 700px;">


  <form action="src/contact/send_contact.php" method="POST" class="border-top pt-3">
    <div class="mb-3">
      <label for="name" class="form-label text-muted">Your Name</label>
      <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label text-muted">Your Email</label>
      <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="message" class="form-label text-muted">Message</label>
      <textarea class="form-control" id="message" name="message" rows="4" placeholder="Write your message here..." required></textarea>
    </div>

    <button type="submit" class="btn btn-outline-success btn-sm">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
        <path d="M15.854.146a.5.5 0 0 1 .11.638l-.057.07-15 15a.5.5 0 0 1-.765-.638l.057-.07L13.293 1H1.5a.5.5 0 0 1-.09-.992L1.5 0h14a.5.5 0 0 1 .354.146z"/>
      </svg>
      Send Message
    </button>

    <small class="d-block text-muted mt-2">
      Your message will be sent to <strong>ceejaytech@gmail.com</strong> and <strong>0550190460</strong> via SMS.
    </small>
  </form>
</div>
