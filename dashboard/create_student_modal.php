<?php
// create_student_modal.php
?>
<div x-data="{ open: false }" x-init="window.openModal = () => open = true">
    <!-- Modal -->
    <div x-show="open" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50">
        <div x-show="open" @click.away="open = false" class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative overflow-y-auto max-h-[90vh]">
            <button @click="open = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Create Student</h2>

            <form id="createStudentForm" class="space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <input type="text" name="student_id" placeholder="Student ID" required class="input-field">
                    <input type="text" name="admission_no" placeholder="Admission No" required class="input-field">
                    <input type="text" name="student_number" placeholder="Student Number" required class="input-field">
                    <input type="text" name="first_name" placeholder="First Name" required class="input-field">
                    <input type="text" name="last_name" placeholder="Last Name" required class="input-field">
                    <input type="date" name="dob" placeholder="Date of Birth" required class="input-field">
                    <select name="gender" required class="input-field">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <input type="text" name="region" placeholder="Region" required class="input-field">
                    <input type="text" name="town" placeholder="Town" required class="input-field">
                    <input type="text" name="ghana_card" placeholder="Ghana Card Number" required class="input-field">
                    <input type="text" name="house_address" placeholder="House Address" required class="input-field">
                    <input type="text" name="phone" placeholder="Phone" required class="input-field">
                    <input type="email" name="email" placeholder="Email" required class="input-field">
                    <input type="text" name="class_id" placeholder="Class ID" required class="input-field">
                    <select name="promoted" required class="input-field">
                        <option value="">Promoted?</option>
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Create Student
                    </button>
                </div>
            </form>

            <div id="formMessage" class="mt-3 text-center text-green-600"></div>
        </div>
    </div>
</div>

<style>
.input-field {
    width: 100%;
    border: 1px solid #d1d5db;
    padding: 0.5rem;
    border-radius: 0.375rem;
    focus:outline-none;
    focus:ring-2;
    focus:ring-blue-400;
}
</style>

<script>
document.getElementById('createStudentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch('create_student.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('formMessage').innerHTML = data;
        this.reset();
    })
    .catch(error => {
        document.getElementById('formMessage').innerHTML = '<span class="text-red-600">Error submitting form</span>';
        console.error(error);
    });
});
</script>
