CREATE TABLE article(
   id_article INT AUTO_INCREMENT,
   title VARCHAR(255) ,
   slug VARCHAR(255) ,
   content TEXT,
   summary VARCHAR(500) ,
   created_at DATETIME,
   authors TEXT,
   PRIMARY KEY(id_article)
);

CREATE TABLE role(
   id_role INT AUTO_INCREMENT,
   label VARCHAR(50) ,
   PRIMARY KEY(id_role)
);

CREATE TABLE user(
   id_user INT AUTO_INCREMENT,
   username VARCHAR(50) ,
   password VARCHAR(255) ,
   id_role INT NOT NULL,
   PRIMARY KEY(id_user),
   FOREIGN KEY(id_role) REFERENCES role(id_role)
);

INSERT INTO role (label) VALUES ('admin'), ('subscriber'), ('guest');

INSERT INTO user (username, password, id_role) VALUES 
('admin', 'admin', 1),
('xyz', 'xyz', 3);