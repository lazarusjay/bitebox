CREATE DATABASE IF NOT EXISTS bitebox;
USE bitebox;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE foods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    category VARCHAR(50)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total DECIMAL(10,2),
    address TEXT,
    phone VARCHAR(20),
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    food_id INT,
    quantity INT,
    price DECIMAL(10,2)
);

INSERT INTO foods (name, description, price, image, category) VALUES
('Classic Burger', 'Juicy beef patty with cheese, lettuce and tomato', 8.99, 'burger.jpg', 'Burgers'),
('Pepperoni Pizza', 'Hand-tossed with mozzarella and pepperoni', 12.50, 'pizza.jpg', 'Pizza'),
('Caesar Salad', 'Crisp romaine, parmesan, croutons', 6.75, 'salad.jpg', 'Salads'),
('Chicken Wings', 'Spicy buffalo wings with ranch dip', 9.50, 'wings.jpg', 'Sides'),
('Chocolate Shake', 'Rich creamy chocolate milkshake', 4.50, 'shake.jpg', 'Drinks'),
('Sushi Platter', 'Assorted fresh sushi rolls', 15.99, 'sushi.jpg', 'Asian'),
('French Fries', 'Golden crispy fries with sea salt', 3.99, 'fries.jpg', 'Sides'),
('Tacos Trio', 'Three beef tacos with salsa', 7.99, 'tacos.jpg', 'Mexican');