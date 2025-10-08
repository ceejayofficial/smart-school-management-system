
<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Include SweetAlert CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<div class="min-h-screen bg-white ml-0 md:ml-64">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-700">New Student</h2>

        <?php
        function generateAppID($length = 8) {
            return substr(str_shuffle("0123456789"), 0, $length);
        }
        $application_id = generateAppID();

        // Show SweetAlert messages if success or error exists
        if(isset($_GET['success']) && $_GET['success'] == 1){
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Student registered successfully.',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }

        if(isset($_GET['error'])){
            $errorMsg = htmlspecialchars($_GET['error']);
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: '{$errorMsg}',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }
        ?>
        <form method="POST" action="admin_dashboard.php?process=create_student_process" enctype="multipart/form-data" class="space-y-6" id="studentForm">
<?php if(isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded shadow">
        Student registered successfully!
    </div>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
    <div class="mb-4 p-4 bg-red-100 text-red-800 rounded shadow">
    Error: <?= htmlspecialchars($_GET['error']) ?>
    </div>
<?php endif; ?>

            <div class="flex flex-col md:flex-row md:space-x-6">
                <!-- Left: Student Info -->
                <div class="flex-1 space-y-4">

                    <!-- Application ID -->
                    <input type="text" value="<?php echo $application_id; ?>" disabled class="input-field bg-white cursor-not-allowed">
                    <input type="hidden" name="application_id_hidden" value="<?php echo $application_id; ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <input type="text" name="first_name" placeholder="First Name" required class="input-field">
                        <input type="text" name="last_name" placeholder="Last Name" required class="input-field">

                        <input type="date" name="dob" required class="input-field">

                        <select name="gender" required class="input-field">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>

                        <input type="text" name="nationality" placeholder="Nationality" required class="input-field">

                        <select name="religion" required class="input-field">
                            <option value="">Select Religion</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Islam">Islam</option>
                            <option value="Traditional">Traditional</option>
                            <option value="Other">Other</option>
                        </select>

                        <select name="disability" class="input-field">
                            <option value="">Any Disability?</option>
                            <option value="None">None</option>
                            <option value="Physical">Physical</option>
                            <option value="Visual">Visual</option>
                            <option value="Hearing">Hearing</option>
                            <option value="Other">Other</option>
                        </select>

                        <input type="text" name="previous_school" placeholder="Previous School" class="input-field">
                        <input type="text" name="town" placeholder="Town" required class="input-field">
                        <input type="text" name="ghana_card" placeholder="Ghana Card Number" class="input-field">
                        <input type="text" name="house_address" placeholder="House Address" required class="input-field">
                        <input type="text" name="phone" placeholder="Phone" required class="input-field" pattern="\d{10}" title="Enter 10-digit phone number">

                        <select name="region" required class="input-field">
                            <option value="">Select Region</option>
                            <?php
                            $regions = ["Greater Accra","Ashanti","Western","Eastern","Northern","Upper East","Upper West","Central","Volta","Bono","Bono East","Ahafo","Oti","North East","Savannah","Western North"];
                            foreach($regions as $region) {
                                echo "<option value='$region'>$region</option>";
                            }
                            ?>
                        </select>

                        <label class="flex items-center space-x-2 mt-2 md:mt-0">
                            <input type="checkbox" name="special_student" value="1" class="rounded border-gray-300 focus:ring focus:ring-blue-400">
                            <span class="text-gray-600">Special Student?</span>
                        </label>
                    </div>

                    <!-- Level & Class -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <select name="level" id="level" required class="input-field">
                            <option value="">Select Level</option>
                            <option value="Creche">Creche</option>
                            <option value="Nursery">Nursery</option>
                            <option value="Primary">Primary</option>
                            <option value="JHS">JHS</option>
                            <option value="SHS">SHS</option>
                        </select>
                        <select name="class_name" id="class_name" required class="input-field">
                            <option value="">Select Class</option>
                        </select>
                    </div>

                    <!-- Parent / Guardian Info -->
                    <div class="space-y-4 mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="father_name" placeholder="Father's Full Name" required class="input-field">
                            <input type="text" name="father_phone" placeholder="Father's Phone Number" required class="input-field">
                            <input type="text" name="mother_name" placeholder="Mother's Full Name" required class="input-field">
                            <input type="text" name="mother_phone" placeholder="Mother's Phone Number" required class="input-field">
                        </div>

                        <div class="mt-2">
                            <div class="flex items-center space-x-4 mt-1">
                                <label class="flex items-center space-x-1">
                                    <input type="radio" name="result_receiver" value="father" required class="form-radio">
                                    <span>Father's Phone</span>
                                </label>
                                <label class="flex items-center space-x-1">
                                    <input type="radio" name="result_receiver" value="mother" required class="form-radio">
                                    <span>Mother's Phone</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Top: Passport Photo -->
                <div class="flex-shrink-0 flex flex-col items-center md:ml-auto md:mt-0">
                    <span class="text-gray-700 font-semibold mb-2">Passport Picture</span>
                    <label for="passport" class="w-40 h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer flex items-center justify-center overflow-hidden hover:border-blue-400 transition">
                        <img id="passportPreview" src="" alt="Passport Preview" class="w-full h-full object-cover hidden">
                        <span id="uploadText" class="text-gray-400 text-center text-sm">Click to upload</span>
                    </label>
                    <input type="file" id="passport" name="passport" accept="image/*" class="hidden" required>
                    <span class="text-red-500 text-sm mt-1">Photo size:  200kb</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end mt-6 space-x-3">
                <a href="admin_dashboard.php?page=students" class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                    Register Student
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script src="../assets/js/student_form.js"></script>
<script src="../assets/js/validation.js"></script>
<script src="../assets/js/passport_pic.js"></script>



