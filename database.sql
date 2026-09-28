CREATE DATABASE IF NOT EXISTS `database` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `database`;

CREATE TABLE IF NOT EXISTS admins (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(100) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 nama VARCHAR(150) NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS services (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nama VARCHAR(150) NOT NULL,
 harga INT NOT NULL DEFAULT 0,
 deskripsi TEXT NULL,
 foto VARCHAR(500) NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS barbers (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nama VARCHAR(150) NOT NULL,
 jabatan VARCHAR(150) NULL,
 foto VARCHAR(500) NOT NULL,
 skills TEXT NULL,
 urutan INT NOT NULL DEFAULT 0,
 status ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS bookings (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nama VARCHAR(150) NOT NULL,
 whatsapp VARCHAR(50) NOT NULL,
 layanan VARCHAR(150) NOT NULL,
 harga INT NOT NULL DEFAULT 0,
 barber VARCHAR(150) NULL,
 tanggal DATE NOT NULL,
 jam TIME NOT NULL,
 status ENUM('pending','confirmed','done','cancelled') NOT NULL DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admins(username,password,nama)
VALUES('admin','$2y$10$8Xv3F9P4kKxjJ8cJx6l7yO5b9V1vQ9wH3fK6d8rW0zJ2mX5pL7nS2','Administrator')
ON DUPLICATE KEY UPDATE nama=VALUES(nama);

INSERT INTO services(nama,harga,deskripsi,foto) VALUES
('Classic Cut',150000,'Potongan klasik dengan teknik presisi tinggi.',''),
('Beard Sculpt',75000,'Pembentukan dan styling jenggot.',''),
('Hot Towel Shave',100000,'Cukur dengan pengalaman handuk panas.','');

INSERT INTO barbers(nama,jabatan,foto,skills,urutan,status) VALUES
('Anuar Silitonga','Head Barber & Founder','https://images.unsplash.com/photo-1622286342621-4bd786c2447c?w=600&q=80','Fade, Classic Cut, Beard Art',1,'aktif'),
('Maleakhi','Senior Barber','https://images.unsplash.com/photo-1618077360395-f3068be8e001?w=600&q=80','Skin Fade, Pompadour, Shave',2,'aktif'),
('Reza Pratama','Barber Specialist','https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80','Undercut, Textured, Color',3,'aktif');
