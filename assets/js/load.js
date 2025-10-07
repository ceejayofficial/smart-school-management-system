document.addEventListener("DOMContentLoaded", function () {
    const swalType = document.getElementById('swal_type')?.value;
    const swalMsg = document.getElementById('swal_message')?.value;
    const userCode = document.getElementById('swal_user_code')?.value;

    if (swalMsg && swalType) {
        Swal.fire({
            icon: swalType,
            title: swalMsg,
            confirmButtonColor: '#3085d6',
        }).then(() => {
            setTimeout(() => {
                window.location.href = `dashboard.php?page=load&user_id=${encodeURIComponent(userCode)}`;
            }, 1000);
        });
    }
});
