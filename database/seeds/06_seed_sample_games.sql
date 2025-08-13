-- 06_seed_sample_games.sql

USE game_store;

INSERT INTO games (title, price, genre, stock, image_path)
VALUES
  ('Echo Drift', 19.99, 'Indie', 30, 'img/echo_drift.jpg'),
  ('Rune Runners', 24.50, 'Action', 20, 'img/rune_runners.jpg'),
  ('Azuron Legacy', 34.99, 'Adventure', 15, 'img/azuron_legacy.jpg'),
  ('Synthwave Rally', 17.00, 'Racing', 25, 'img/synthwave_rally.jpg');
