CREATE DATABASE IF NOT EXISTS isro_drdo_portal CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE isro_drdo_portal;

CREATE TABLE IF NOT EXISTS applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  dob DATE NOT NULL,
  email VARCHAR(160) NOT NULL,
  mobile VARCHAR(20) NOT NULL,
  gender VARCHAR(30) NOT NULL,
  address TEXT NOT NULL,
  ug_degree VARCHAR(80) NOT NULL,
  ug_percentage DECIMAL(5,2) NOT NULL,
  pg_degree VARCHAR(80) NULL,
  pg_percentage DECIMAL(5,2) NULL,
  phd_qualification VARCHAR(160) NULL,
  experience_years DECIMAL(4,1) NOT NULL,
  route VARCHAR(30) NOT NULL,
  status VARCHAR(40) NOT NULL DEFAULT 'Submitted',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS application_documents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  application_id INT NOT NULL,
  document_type VARCHAR(40) NOT NULL,
  file_name VARCHAR(255) NOT NULL,
  stored_path VARCHAR(500) NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_document_application FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS interview_bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  application_id INT NOT NULL,
  mode VARCHAR(40) NOT NULL,
  city VARCHAR(80) NOT NULL,
  interview_date DATE NOT NULL,
  interview_time VARCHAR(30) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_interview_application FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS test_results (
  id INT AUTO_INCREMENT PRIMARY KEY,
  application_id INT NOT NULL,
  test_name VARCHAR(40) NOT NULL,
  score INT NOT NULL,
  total_marks INT NOT NULL,
  passed TINYINT(1) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_test_application FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE
);
