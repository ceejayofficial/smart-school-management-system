-- USERS / ADMINS
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'teacher', 'accountant', 'registrar') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- CLASSES
CREATE TABLE classes (
    class_id INT AUTO_INCREMENT PRIMARY KEY,
    level ENUM('Creche', 'Nursery', 'Primary', 'JHS', 'SHS', 'Tertiary') NOT NULL,
    class_name VARCHAR(100) NOT NULL
);

-- STUDENTS
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    admission_no VARCHAR(50) UNIQUE NOT NULL,   -- auto generated admission number
    student_number VARCHAR(50) UNIQUE NOT NULL, -- assigned by registrar
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    region VARCHAR(100) NOT NULL,
    town VARCHAR(100) NOT NULL,
    ghana_card VARCHAR(100),   -- optional
    house_address TEXT,
    phone VARCHAR(20),
    email VARCHAR(100),
    class_id INT NOT NULL,
    promoted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE CASCADE
);

-- =========================
CREATE TABLE admissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admission_number VARCHAR(50) UNIQUE NOT NULL,   -- Auto-generated (e.g. ADM2025-001)
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    gender ENUM('Male','Female') NOT NULL,
    date_of_birth DATE NOT NULL,
    region VARCHAR(100),
    town VARCHAR(100),
    house_address VARCHAR(255),
    ghana_card_number VARCHAR(20) UNIQUE NULL,

    -- Father Info
    father_name VARCHAR(100),
    father_contact VARCHAR(20),
    father_email VARCHAR(100),

    -- Mother Info
    mother_name VARCHAR(100),
    mother_contact VARCHAR(20),
    mother_email VARCHAR(100),

    -- Guardian Info
    guardian_name VARCHAR(100),
    guardian_contact VARCHAR(20),
    guardian_email VARCHAR(100),

    emergency_contact VARCHAR(20),

    application_status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- SUBJECTS
CREATE TABLE subjects (
    subject_id INT AUTO_INCREMENT PRIMARY KEY,
    subject_name VARCHAR(100) NOT NULL,
    level ENUM('Creche', 'Nursery', 'Primary', 'JHS', 'SHS', 'Tertiary') NOT NULL
);

-- EXAMS
CREATE TABLE exams (
    exam_id INT AUTO_INCREMENT PRIMARY KEY,
    exam_name VARCHAR(100) NOT NULL,
    exam_term ENUM('1st', '2nd', '3rd') NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    class_id INT NOT NULL,
    subject_id INT NOT NULL,
    exam_date DATE,
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE
);

-- RESULTS (Added parent_contact for SMS)
CREATE TABLE results (
    result_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    subject_id INT NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    grade VARCHAR(5),
    remarks VARCHAR(255),
    parent_contact VARCHAR(20) NOT NULL, -- added field for SMS notifications
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(exam_id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(subject_id) ON DELETE CASCADE
);

-- FEES (School and other fees)
CREATE TABLE fees (
    fee_id INT AUTO_INCREMENT PRIMARY KEY,
    class_id INT NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    term ENUM('1st', '2nd', '3rd') NOT NULL,
    fee_type ENUM('School', 'PTA', 'Exam', 'Other') DEFAULT 'School',
    amount DECIMAL(10,2) NOT NULL,
    UNIQUE(class_id, academic_year, term, fee_type),
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE CASCADE
);

-- PAYMENTS
CREATE TABLE fee_payments (
    payment_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    fee_id INT NOT NULL,
    amount_paid DECIMAL(10,2) NOT NULL,
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (fee_id) REFERENCES fees(fee_id) ON DELETE CASCADE
);

-- OUTSTANDING BALANCES (Debt carried forward)
CREATE TABLE outstanding_balances (
    balance_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    class_id INT NOT NULL,
    academic_year VARCHAR(20) NOT NULL,
    total_due DECIMAL(10,2) NOT NULL,
    total_paid DECIMAL(10,2) DEFAULT 0.00,
    balance DECIMAL(10,2) GENERATED ALWAYS AS (total_due - total_paid) STORED,
    status ENUM('Cleared', 'Owing') DEFAULT 'Owing',
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(class_id) ON DELETE CASCADE
);

-- =========================
-- PROMOTIONS (carry over unpaid balances on promotion or repeat)
-- =========================
CREATE TABLE promotions (
    promotion_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    from_class_id INT NOT NULL,
    to_class_id INT NOT NULL, -- same as from_class_id if repeated
    from_academic_year VARCHAR(20) NOT NULL,
    to_academic_year VARCHAR(20) NOT NULL,
    promoted_or_repeated ENUM('Promoted','Repeated') NOT NULL,
    promoted_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    balance_carried DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (from_class_id) REFERENCES classes(class_id) ON DELETE CASCADE,
    FOREIGN KEY (to_class_id) REFERENCES classes(class_id) ON DELETE CASCADE
);
