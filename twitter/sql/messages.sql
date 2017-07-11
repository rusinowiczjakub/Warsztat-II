CREATE TABLE message(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
sent_by INT,
sent_to INT,
content VARCHAR(255),
created_at DATETIME,
`read` BOOL,
FOREIGN KEY (sent_by) REFERENCES user(id),
FOREIGN KEY (sent_to) REFERENCES user(id)
);