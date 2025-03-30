# ADET

CREATE DATABASE PawShop;
USE PawShop
CREATE TABLE Users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    f_name VARCHAR(50),
    m_name VARCHAR(50),
    l_name VARCHAR(50),
    age INT,
    address VARCHAR(255),
    phone_number VARCHAR(12),
    username VARCHAR(50) UNIQUE,
    email VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE Roles (
    rolesID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    role ENUM('customer', 'admin'),
    FOREIGN KEY (userID) REFERENCES Users(userID)
);

CREATE TABLE ProductCategories (
    product_categoryID INT AUTO_INCREMENT PRIMARY KEY,
    pd_name VARCHAR(50),
    pd_description VARCHAR(255)
);

CREATE TABLE Products (
    productID INT AUTO_INCREMENT PRIMARY KEY,
    product_categoryID INT,
    p_name VARCHAR(255),
    p_description VARCHAR(255),
    p_price DECIMAL(10,2),
    p_quantity INT,
    p_stock INT,
    p_brand VARCHAR(255),
    FOREIGN KEY (product_categoryID) REFERENCES ProductCategories(product_categoryID)
);

CREATE TABLE Orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    promoID INT,
    o_date DATETIME,
    o_status ENUM('Pending', 'Shipped', 'Delivered', 'Cancelled'),
    o_shipping_address VARCHAR(255),
    o_shipping_fee DECIMAL(10,2),
    o_total_amount DECIMAL(10,2),
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (promoID) REFERENCES Promos(promoID)
);

CREATE TABLE OrderDetails (
    order_detailID INT AUTO_INCREMENT PRIMARY KEY,
    productID INT,
    orderID INT,
    od_quantity INT,
    od_tax DECIMAL(10,2),
    od_subtotal DECIMAL(10,2),
    od_change DECIMAL(10,2),
    FOREIGN KEY (productID) REFERENCES Products(productID),
    FOREIGN KEY (orderID) REFERENCES Orders(orderID)
);

CREATE TABLE Payment (
    paymentID INT AUTO_INCREMENT PRIMARY KEY,
    orderID INT,
    p_method ENUM('COD', 'Ewallet', 'Credit Card'),
    p_status ENUM('Pending', 'Paid', 'Cancelled'),
    p_date DATETIME,
    FOREIGN KEY (orderID) REFERENCES Orders(orderID)
);

CREATE TABLE Reviews (
    reviewID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    productID INT,
    r_description VARCHAR(255),
    r_date DATETIME,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (productID) REFERENCES Products(productID)
);

CREATE TABLE Shippings (
    shippingID INT AUTO_INCREMENT PRIMARY KEY,
    orderID INT,
    s_courier VARCHAR(50),
    s_status ENUM('Waiting', 'Shipped', 'Delivered', 'Cancelled'),
    s_delivery_date DATETIME,
    FOREIGN KEY (orderID) REFERENCES Orders(orderID)
);

CREATE TABLE Wishlists (
    wishlistID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    productID INT,
    w_date DATETIME,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (productID) REFERENCES Products(productID)
);

CREATE TABLE Carts (
    cartID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    productID INT,
    c_quantity INT,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (productID) REFERENCES Products(productID)
);

CREATE TABLE Promos (
    promoID INT AUTO_INCREMENT PRIMARY KEY,
    p_code VARCHAR(50),
    p_discount DECIMAL(10,2),
    p_valid_from DATETIME,
    p_valid_until DATETIME,
    p_usage_limit INT
);

CREATE TABLE PromoUsages (
    usageID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    promoID INT,
    u_date DATE,
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (promoID) REFERENCES Promos(promoID)
);
