CREATE DATABASE IF NOT EXISTS portfolio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    technologies VARCHAR(255) DEFAULT '',
    image VARCHAR(255) DEFAULT '',
    website_url VARCHAR(255) DEFAULT '',
    github_url VARCHAR(255) DEFAULT '',
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    percentage INT NOT NULL DEFAULT 80,
    icon VARCHAR(100) DEFAULT 'bi-code-slash',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(150) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO skills (name, percentage, icon) VALUES
('HTML5', 95, 'bi-filetype-html'),
('CSS3', 90, 'bi-filetype-css'),
('Bootstrap 5', 92, 'bi-bootstrap'),
('JavaScript', 82, 'bi-filetype-js'),
('PHP', 88, 'bi-filetype-php'),
('MySQL', 85, 'bi-database');

INSERT INTO admins (name, email, password)
VALUES (
  'Mukhtar',
  'emiabatamukhtar7@gmail.com',
  '$2y$10$A582Kao3HLq9FHEaS8LH9OllklbygBeHvBWOK5rQqDhXnUIxppXJi'
);