# E-Commerce Application

## Project Overview
This project is an e-commerce platform designed to offer a seamless shopping experience to users. It includes features like user authentication, product management, a shopping cart, checkout, and payment processing. The application is built using a combination of relational and non-relational databases, following best practices for scalability, security, and performance.

![ER](https://github.com/user-attachments/assets/724e9134-f6ab-4ae1-b7b2-548076021718)

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Project Structure](#project-structure)
- [Setup and Installation](#setup-and-installation)
- [Database Design](#database-design)
- [Development Process](#development-process)
- [Technologies Used](#technologies-used)
- [Next Steps](#next-steps)

## Features
### 1. User Authentication
- Secure user registration and login.
- Role-based access for buyers and sellers.
- Password hashing and email verification for security.

### 2. Product Listings
- Sellers can add, update, and remove products.
- Buyers can browse and search for products by category, price, or keyword.
- Detailed product pages with descriptions, images, and seller information.

### 3. Shopping Cart
- Buyers can add items to their cart, update quantities, and remove items.
- Dynamic calculation of total costs, including taxes and shipping.

### 4. Checkout and Payment
- Secure checkout process with multiple payment gateway integrations.
- Confirmation of payment and detailed order summaries.

### 5. Order Management
- Buyers can track the status of their orders.
- Sellers can manage and track orders for fulfillment.

### 6. User Profiles
- Users can manage personal information, addresses, and payment methods.
- Sellers can manage their store profiles and product listings.

### 7. Reviews and Ratings
- Buyers can leave reviews and ratings for products.
- Review moderation by sellers.

## Project Structure
- **auth/**: Contains user authentication logic (login, registration, logout).
- **config/**: Database connection and configuration files.
- **public/**: Core frontend pages and PHP scripts for cart and checkout.
- **vendor/**: Composer dependencies and third-party libraries (e.g., Stripe for payments).
- **scripts/**: Sample SQL scripts for database creation.

## Setup and Installation
### Prerequisites
- MySQL Database
- XAMPP/WAMP for local server
- Composer for PHP package management
- Stripe/PayPal accounts for payment integration
- Node.js for backend development

### Installation Steps
1. **Clone the Repository**:
   ```bash
   git clone [https://github.com/your-repo/ecommerce-app](https://github.com/NavyaBoga1109/ecommerce_web_application).git
   cd ecommerce-web-application
   ```
2. **Set Up Database**:
   - Use the provided `scripts/db_schema.sql` to create the database schema.
   - Update `config/db_connection.php` with your database credentials.

3. **Install Dependencies**:
   - Run `composer install` in the project root to install PHP dependencies.
   - Use `npm install` to install frontend dependencies (if applicable).

4. **Configure Environment Variables**:
   - Create a `.env` file and add your environment-specific configurations (e.g., database credentials, API keys).

5. **Start the Local Server**:
   - Start your XAMPP/WAMP server.
   - Navigate to `http://localhost/ecommerce-app` in your browser.

## Database Design
### ER Diagram
- **Users**: Stores user information, including roles (buyer/seller).
- **Sellers**: Extends `Users` with seller-specific details.
- **Products**: Product information, linked to sellers and categories.
- **Categories**: Product categorization details.
- **Orders**: Stores order information, linked to users.
- **Order_Items**: Details of each product in an order.
- **Shopping_Cart**: Temporary storage of items in the cart.
- **Reviews**: Product review and rating data.

### Sample Table Schema
```sql
CREATE TABLE Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    user_type ENUM('buyer', 'seller'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    seller_id INT,
    category_id INT,
    name VARCHAR(255),
    description TEXT,
    price DECIMAL(10, 2),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (seller_id) REFERENCES Sellers(seller_id),
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);
```

## Development Process
### Step 1: Requirements Gathering
- Identify functional and non-functional requirements.
- Define data to be stored and create a detailed document outlining features.

### Step 2: Database Design
- Create an ER diagram and normalize the database.
- Define relationships and write SQL scripts for schema creation.

### Step 3: Backend Implementation
- Implement user authentication and secure password storage.
- Develop APIs for CRUD operations on products and orders.

### Step 4: Frontend Design
- Use React or a similar framework for a dynamic user interface.
- Ensure seamless communication with the backend via API calls.

### Step 5: Shopping Cart and Checkout
- Implement cart functionality with session management.
- Integrate payment gateways for secure transactions.

### Step 6: Order Management
- Develop order tracking for buyers and sales management for sellers.

### Step 7: Testing and Deployment
- Conduct unit and integration tests.
- Optimize the application for performance and security.

## Technologies Used
- **Frontend**: React.js, HTML, CSS, Bootstrap
- **Backend**: PHP, Node.js, Express.js
- **Database**: MySQL, Neo4j (optional for scalability)
- **Payment Integration**: Stripe, PayPal
- **Version Control**: Git, GitHub

## Next Steps
- **Frontend Enhancements**: Improve UI/UX and add advanced features.
- **Order Tracking**: Implement real-time order updates and notifications.
- **Security**: Conduct a security audit and implement best practices.
- **Scalability**: Consider migrating to NoSQL for large-scale operations.

## License
This project is licensed under the MIT License. See `LICENSE` for more details.
