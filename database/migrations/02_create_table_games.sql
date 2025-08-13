CREATE TABLE IF NOT EXISTS games (
  game_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  price DECIMAL(6,2) NOT NULL,
  genre VARCHAR(50),
  stock INT DEFAULT 0,
  image_path VARCHAR(255),
  description TEXT,
  release_date DATE,
  platform_id INT,
  FOREIGN KEY (platform_id) REFERENCES platforms(platform_id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
  featured BOOLEAN DEFAULT 0
);
