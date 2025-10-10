<head>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Tailwind for styling (if not already included globally) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<div class="min-h-screen bg-white ml-0 md:ml-64">
    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-semibold mb-6 text-gray-700">New Teacher</h2>

        <?php
        require_once "../db.php";

        // Function to generate Teacher ID
        function generateTeacherID($length = 6): string {
            return "TCHR-" . substr(str_shuffle("0123456789"), 0, $length);
        }

        $teacher_id = generateTeacherID();

        // SweetAlert feedback
        if (isset($_GET['success']) && $_GET['success'] == "1") {
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Teacher registered successfully.',
                    confirmButtonText: 'OK'
                });
            </script>";
        }

        if (isset($_GET['error'])) {
            $errorMsg = htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8');
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: '{$errorMsg}',
                    confirmButtonText: 'OK'
                });
            </script>";
        }

        // Fetch subjects from database
        $subjects = [];
        $sql = "SELECT subject_id, subject_name FROM subjects ORDER BY subject_name ASC";

        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $subjects[] = $row;
            }
            $result->free();
        }
        ?>


        <form method="POST" action="admin_dashboard.php?process=create_teacher_process" enctype="multipart/form-data" class="space-y-6" id="teacherForm">

            <!-- Teacher ID -->
            <input type="text" value="<?php echo $teacher_id; ?>" disabled class="input-field bg-white cursor-not-allowed">
            <input type="hidden" name="teacher_id_hidden" value="<?php echo $teacher_id; ?>">

            <div class="flex flex-col md:flex-row md:space-x-6">
                <!-- Left Column -->
                <div class="flex-1 space-y-4">

                    <!-- Basic Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="first_name" placeholder="First Name" required class="input-field">
                        <input type="text" name="last_name" placeholder="Last Name" required class="input-field">

                        <input type="date" name="dob" required class="input-field">

                        <select name="gender" required class="input-field">
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>

                        <input type="text" name="phone" placeholder="Phone Number" required class="input-field" pattern="\d{10}" title="Enter 10-digit phone number">
                        <input type="email" name="email" placeholder="Email Address" required class="input-field">
                    </div>

                    <!-- Professional Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <!-- Qualification Dropdown -->
                        <select name="qualification" required class="input-field">
                            <option value="">Highest Qualification</option>
                            <option value="WASSCE">WASSCE</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Degree">Degree</option>
                            <option value="Masters">MSc / Masters</option>
                            <option value="PhD">PhD</option>
                        </select>

                        <input type="number" name="experience" placeholder="Years of Experience" min="0" required class="input-field">

                        <select name="employment_type" required class="input-field">
                            <option value="">Employment Type</option>
                            <option value="Full-time">Full-time</option>
                            <option value="Part-time">Part-time</option>
                            <option value="Contract">Contract</option>
                        </select>

                        <select name="region" required class="input-field">
                            <option value="">Select Region</option>
                            <?php
                            $regions = ["Greater Accra","Ashanti","Western","Eastern","Northern","Upper East","Upper West","Central","Volta","Bono","Bono East","Ahafo","Oti","North East","Savannah","Western North"];
                            foreach($regions as $region) {
                                echo "<option value='$region'>$region</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Assign Class & Subjects -->
                    <div class="mt-6">
                        <label class="block text-gray-700 font-medium mb-2">Assign Level</label>
                        <select name="level" id="level" class="input-field" required>
                            <option value="">Select Level</option>
                            <option value="Creche">Creche</option>
                            <option value="Nursery">Nursery</option>
                            <option value="Primary">Primary</option>
                            <option value="JHS">JHS</option>
                            <option value="SHS">SHS</option>
                        </select>
                    </div>

                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Assign Class</label>
                        <select name="class_assigned" id="class_name" class="input-field" required>
                            <option value="">Select Class</option>
                        </select>
                    </div>

                    <!-- ✅ Checkbox with search for Subjects -->
                    <div class="mt-4">
                        <label class="block text-gray-700 font-medium mb-2">Assign Subjects</label>
                        <input type="text" id="subjectSearch" placeholder="Search subject..." class="w-full mb-2 p-2 border rounded">

                        <div class="border rounded p-3 h-40 overflow-y-scroll bg-white">
                            <?php foreach($subjects as $sub): ?>
                                <label class="flex items-center space-x-2 mb-1">
                                    <input type="checkbox" name="subjects[]" value="<?= $sub['subject_id'] ?>" class="subject-checkbox">
                                    <span><?= htmlspecialchars($sub['subject_name']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Passport Photo -->
                <div class="flex-shrink-0 flex flex-col items-center md:ml-auto md:mt-0">
                    <span class="text-gray-700 font-semibold mb-2">Passport Picture</span>
                    <label for="passport" class="w-40 h-40 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer flex items-center justify-center overflow-hidden hover:border-blue-400 transition">
                        <img id="passportPreview" src="" alt="Passport Preview" class="w-full h-full object-cover hidden">
                        <span id="uploadText" class="text-gray-400 text-center text-sm">Click to upload</span>
                    </label>
                    <input type="file" id="passport" name="passport" accept="image/*" class="hidden" required>
                    <span class="text-red-500 text-sm mt-1">Photo size: 200kb max</span>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex justify-end mt-6 space-x-3">
                <a href="admin_dashboard.php?page=teachers" class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded transition">
                    Cancel
                </a>
                <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">
                    Register Teacher
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JS -->
<script>
    // Populate classes dynamically when level is selected
    const levelSelect = document.getElementById('level');
    const classSelect = document.getElementById('class_name');

    const classesByLevel = {
        "Creche": ["Creche 1", "Creche 2"],
        "Nursery": ["Nursery 1", "Nursery 2"],
        "Primary": ["Primary 1", "Primary 2", "Primary 3", "Primary 4", "Primary 5", "Primary 6"],
        "JHS": ["JHS 1", "JHS 2", "JHS 3"],
        "SHS": ["SHS 1", "SHS 2", "SHS 3"]
    };

    levelSelect.addEventListener('change', function(){
        const selectedLevel = this.value;
        classSelect.innerHTML = "<option value=''>Select Class</option>";

        if(classesByLevel[selectedLevel]){
            classesByLevel[selectedLevel].forEach(cls => {
                const option = document.createElement('option');
                option.value = cls;
                option.textContent = cls;
                classSelect.appendChild(option);
            });
        }
    });

    // ✅ Subject search filter
    const searchInput = document.getElementById("subjectSearch");
    searchInput.addEventListener("keyup", function() {
        const filter = this.value.toLowerCase();
        document.querySelectorAll(".subject-checkbox").forEach(checkbox => {
            const label = checkbox.parentElement;
            const text = label.innerText.toLowerCase();
            label.style.display = text.includes(filter) ? "flex" : "none";
        });
    });
</script>

<script src="../assets/js/validation.js"></script>
<script src="../assets/js/passport_pic.js"></script>
