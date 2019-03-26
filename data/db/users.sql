DROP TABLE IF EXISTS user;

CREATE TABLE user (
  id VARCHAR(36) NOT NULL,
  name VARCHAR(80),
  email VARCHAR(255) NOT NULL,
  password VARCHAR(96) NOT NULL,
  PRIMARY KEY (id)
);

INSERT INTO user
  (id, name, email, password)
VALUES
  ('f3d7aa4a-ae5c-4b46-a716-67c3d55da5c0', 'Foo', 'foo@host.com', '$2y$10$KeC2tLA3g6Xel8ZN/HHsMumaaZIoGwcYwcADzPaXRXifBWWDSedR2'),
  ('6604ab7c-ae39-4c95-ba04-ff0623bbde5b', 'Bar', 'bar@host.com', '$2y$10$GDnOwBpHPnX49A7/9sNGnubP/AM7RmxFOXU0lUwDQOn5bwknUtp/q');
