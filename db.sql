-- =========================
-- Table: classes
-- =========================
CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    class_name VARCHAR(100) NOT NULL,
    level ENUM('KG','Primary','JHS','SHS') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Pre-populate Classes
INSERT INTO classes (class_name, level) VALUES
('KG1','KG'),
('KG2','KG'),
('Class One','Primary'),
('Class Two','Primary'),
('Class Three','Primary'),
('Class Four','Primary'),
('Class Five','Primary'),
('Class Six','Primary'),
('Form One','JHS'),
('Form Two','JHS'),
('Form Three','JHS'),
('SHS One','SHS'),
('SHS Two','SHS'),
('SHS Three','SHS');

-- =========================
-- Table: admissions (Admission Form)
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

-- =========================
-- Table: students (Registered Students)
-- =========================
CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_number VARCHAR(50) UNIQUE,              -- Generated (e.g. STU2025-001)
    admission_id INT NOT NULL,
    class_id INT,
    email VARCHAR(100),
    phone VARCHAR(20),
    admission_date DATE DEFAULT CURRENT_DATE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admission_id) REFERENCES admissions(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL
);

-- =========================
-- Table: exams
-- =========================
CREATE TABLE exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    exam_name VARCHAR(100) NOT NULL,                -- e.g. Midterm, End of Term
    term ENUM('1st','2nd','3rd') NOT NULL,
    academic_year VARCHAR(20) NOT NULL,             -- e.g. 2024/2025
    class_id INT NOT NULL,
    exam_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE
);

-- =========================
-- Table: received_results (Raw results before approval)
-- =========================
CREATE TABLE received_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    teacher_comments VARCHAR(255),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending','Reviewed','Approved','Rejected') DEFAULT 'Pending',
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
);

-- =========================
-- Table: results (Final approved results)
-- =========================
CREATE TABLE results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    subject VARCHAR(100) NOT NULL,
    score DECIMAL(5,2) NOT NULL,
    grade VARCHAR(2),
    remarks VARCHAR(255),
    published_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE
);

-- =========================
-- Table: fees
-- =========================
CREATE TABLE fees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    description VARCHAR(255),
    status ENUM('Paid','Pending','Partial') DEFAULT 'Pending',
    due_date DATE,
    paid_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);
