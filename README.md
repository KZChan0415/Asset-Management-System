# E-Commerce Asset Management System

## Overview
This project is an E-Commerce Asset Management System built to monitor and manage inventory stocks.

## Features
- **View Assets  :** A responsive dashboard displaying all inventory with status indicatiors.
- **Add Assets   :** A form to input new items, categories, and stock quantities.
- **Edit Assets  :** Update existing asset details as inventory changes.
- **Delete Assets:** Remove specific asset from the database.

## Database Setup
CREATE TABLE assets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    item_name VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    quantity INT NOT NULL,
    status VARCHAR(50) DEFAULT 'In Stock',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);