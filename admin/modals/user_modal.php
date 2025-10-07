<div class="modal fade" id="createUserModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
    <form class="modal-content bg-white text-dark" id="userForm">
    <div class="modal-header border-0">
        <h5 class="modal-title" id="userModalTitle">Create New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="user-id">
        <input type="hidden" name="unique_code" id="user-unique-code" value="<?= $new_code ?>">

        <div class="row">
          <div class="col-md-6 mb-3">
            <label>Username</label>
            <input type="text" name="username" id="user-username" class="form-control" required placeholder="Max 10 chars, no spaces">
          </div>
          <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" id="user-email" class="form-control" required placeholder="e.g. user@example.com">
          </div>
          <div class="col-md-6 mb-3">
            <label>Phone</label>
            <input type="text" name="phone" id="user-phone" class="form-control" placeholder="e.g. +233501234567">
          </div>
          <div class="col-md-6 mb-3 password-field">
            <label>Password</label>
            <input type="password" name="password" id="user-password" class="form-control" required placeholder="Min 8 chars incl. @, A-Z, a-z, 0-9">
          </div>
          <div class="col-md-6 mb-3">
            <label>Role</label>
            <select name="role" id="user-role" class="form-select" required>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="btn btn-dark" id="modal-submit-btn">Create</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>



