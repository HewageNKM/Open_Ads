CREATE TABLE IF NOT EXISTS posts (
  post_id VARCHAR(64) PRIMARY KEY,
  title TEXT NOT NULL,
  description TEXT,
  image MEDIUMTEXT,                     -- Stores base64 encoded image data
  createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
