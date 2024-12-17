-- Create the 'read&relax' database
CREATE DATABASE `read&relax`;

-- Use the 'read&relax' database
USE `read&relax`;

-- Create the 'Books' table
CREATE TABLE Books (
    BookID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Author VARCHAR(255) NOT NULL,
    Genre VARCHAR(100) NOT NULL,
    Price DECIMAL(10, 2) NOT NULL,
    Stock INT NOT NULL
);
