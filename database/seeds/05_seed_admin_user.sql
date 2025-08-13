-- 05_seed_admin_user.sql

USE game_store;

-- Replace 'Codeslayer' with an actual bcrypt or Argon2 hash generated via PHP’s password_hash()
INSERT INTO users (username, password_hash, role)
VALUES
  ('admin', '$2y$10$XXXXXXXXXXXXXXXXXXXXXXXXXXXXX', 'admin'),
  ('Kuro',  '$2y$10$WYr2edI8yPdq89CRhwCzAOGvpCLHjRkFs25kUuZBKtiSu/upnwOQm', 'admin')
ON DUPLICATE KEY UPDATE
  password_hash = VALUES(password_hash),
  role          = VALUES(role);
