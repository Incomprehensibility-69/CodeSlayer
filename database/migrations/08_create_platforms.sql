CREATE TABLE IF NOT EXISTS platforms (
  platform_id INT AUTO_INCREMENT PRIMARY KEY,
  name ENUM('PC', 'PS5', 'Xbox', 'Switch', 'Mobile') UNIQUE NOT NULL
);
