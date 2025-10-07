<?php if (isset($user_id)): ?>
<form id="addSenderForm" class="mb-4">
    <div class="row g-2">
        <div class="col-md-3">
            <input type="number" name="user_id" class="form-control" value="<?= htmlspecialchars($user_id) ?>" readonly>
        </div>

        <div class="col-md-4">
            <input type="text" name="sender_name" class="form-control" placeholder="Enter sender name" required>
        </div>

        <!-- Purpose -->
        <div class="col-md-4">
            <input type="text" name="purpose" class="form-control" placeholder="Enter purpose" required>
        </div>

        <!-- Submit -->
        <div class="col-md-1 d-grid">
            <button class="btn btn-success" type="submit">Add</button>
        </div>
    </div>
</form>
<?php endif; ?>


<script>
document.getElementById("addSenderForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    fetch("crud/add.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: "success",
                title: "Sender Added",
                text: "The sender was successfully added.",
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                // Reload senders table
                location.reload();
            });
        } else {
            Swal.fire({
                icon: "error",
                title: "Error",
                text: data.message || "Something went wrong.",
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: "error",
            title: "Request Failed",
            text: error.message || "An unexpected error occurred.",
        });
    });
});
</script>
