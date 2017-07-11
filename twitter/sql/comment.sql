CREATE TABLE comment(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
post_id INT,
user_id INT,
content VARCHAR(255),
created_at DATETIME,
FOREIGN KEY (post_id) REFERENCES post(id),
FOREIGN KEY (user_id) REFERENCES user(id)
);