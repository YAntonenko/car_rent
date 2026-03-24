CREATE DATABASE IF NOT EXISTS car_rent CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE car_rent;

DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS cars;

CREATE TABLE cars (
  id INT AUTO_INCREMENT PRIMARY KEY,
  brand VARCHAR(100) NOT NULL,
  model VARCHAR(100) NOT NULL,
  year INT NOT NULL,
  registration_number VARCHAR(50) NOT NULL,
  price_per_day DECIMAL(10,2) NOT NULL,
  engine VARCHAR(100) NOT NULL,
  fuel_type VARCHAR(50) NOT NULL,
  transmission VARCHAR(50) NOT NULL,
  seats INT NOT NULL,
  description TEXT,
  image VARCHAR(255) NOT NULL,
  status ENUM('available', 'rented', 'service') NOT NULL DEFAULT 'available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role ENUM('admin', 'customer') NOT NULL DEFAULT 'customer',
  first_name VARCHAR(100) NOT NULL,
  last_name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  phone VARCHAR(50) DEFAULT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  car_id INT NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  total_price DECIMAL(10,2) NOT NULL,
  status ENUM('active', 'cancelled', 'finished') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_reservation_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_reservation_car FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

INSERT INTO users (role, first_name, last_name, email, phone, password_hash) VALUES
('admin', 'Admin', 'User', 'admin@example.com', '+37255551234', '$2y$12$lMIxKxdvb4ifv2OQdYaeQuWrTWQz/KIc7ol99hpeO2wAb.K4vcVtS'),
('customer', 'Mari', 'Tamm', 'mari@example.com', '+3725000001', '$2y$12$lMIxKxdvb4ifv2OQdYaeQuWrTWQz/KIc7ol99hpeO2wAb.K4vcVtS');

INSERT INTO cars (brand, model, year, registration_number, price_per_day, engine, fuel_type, transmission, seats, description, image, status) VALUES
('BMW', '320d', 2022, '123ABC', 69.90, '2.0', 'Diisel', 'Automaat', 5, 'Heas korras mugav sedaan nii linnasõiduks kui ka pikemateks reisideks.', 'https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=1200&q=80', 'available'),
('Audi', 'A6', 2021, '456DEF', 79.90, '2.0 TDI', 'Diisel', 'Automaat', 5, 'Ruumikas premium-klassi auto ärikliendile ja perele.', 'https://images.unsplash.com/photo-1542282088-fe8426682b8f?auto=format&fit=crop&w=1200&q=80', 'available'),
('Toyota', 'Corolla', 2023, '789GHI', 49.90, '1.8 Hybrid', 'Bensiin/Hübriid', 'Automaat', 5, 'Ökonoomne ja töökindel igapäevaauto.', 'https://images.unsplash.com/photo-1494976388531-d1058494cdd8?auto=format&fit=crop&w=1200&q=80', 'available'),
('Volkswagen', 'Passat', 2020, '321JKL', 59.90, '2.0 TDI', 'Diisel', 'Manuaal', 5, 'Praktiline universaal suure pagasiruumiga.', 'https://images.unsplash.com/photo-1502877338535-766e1452684a?auto=format&fit=crop&w=1200&q=80', 'service'),
('Mercedes-Benz', 'C200', 2022, '654MNO', 84.90, '2.0', 'Bensiin', 'Automaat', 5, 'Elegantne valik, kui soovid rohkem mugavust ja vaikust.', 'https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=1200&q=80', 'available'),
('Skoda', 'Octavia', 2021, '987PQR', 55.00, '1.5 TSI', 'Bensiin', 'Manuaal', 5, 'Soodne ja ruumikas valik igapäevaseks kasutuseks.', 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=1200&q=80', 'rented');

INSERT INTO reservations (user_id, car_id, start_date, end_date, total_price, status) VALUES
(2, 1, '2026-04-10', '2026-04-12', 209.70, 'active');
