-- Tabel user (jika ada login)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  password VARCHAR(100),
  role ENUM('admin', 'staff')
);

-- Supplier
CREATE TABLE suppliers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  contact VARCHAR(100)
);

-- Produk
CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  category VARCHAR(50),
  price DECIMAL(10,2),
  stock INT,
  supplier_id INT,
  FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

-- Transaksi penjualan
CREATE TABLE sales (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT,
  quantity INT,
  sale_date DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id)
);
