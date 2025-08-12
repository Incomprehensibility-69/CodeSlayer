<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
CREATE DATABASE game_store;
USE game_store;

>>>>>>> Stashed changes
=======
CREATE DATABASE game_store;
USE game_store;

>>>>>>> Stashed changes
CREATE TABLE games (
  game_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(100) NOT NULL,
  price DECIMAL(6,2) NOT NULL,
  genre VARCHAR(50),
  stock INT DEFAULT 0,
  image_path VARCHAR(255)
);
<<<<<<< Updated upstream
<<<<<<< Updated upstream
=======
=======
>>>>>>> Stashed changes

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(20) DEFAULT 'admin'
);


CREATE TABLE activity_log (
  log_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50),
  action VARCHAR(100),
  timestamp DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- After generating your password hash in PHP, use this SQL to add an admin user:
INSERT INTO users (username, password_hash)
VALUES ('admin', 'Codeslayer');
INSERT INTO users (username, password_hash, role)
<<<<<<< Updated upstream
VALUES ('Kuro', '$2y$10$WYr2edI8yPdq89CRhwCzAOGvpCLHjRkFs25kUuZBKtiSu/upnwOQm', 'admin');
>>>>>>> Stashed changes
=======
VALUES ('Kuro', '$2y$10$WYr2edI8yPdq89CRhwCzAOGvpCLHjRkFs25kUuZBKtiSu/upnwOQm', 'admin');
>>>>>>> Stashed changes
