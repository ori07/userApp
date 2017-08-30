CREATE USER 'admin_app'@'localhost' IDENTIFIED BY 'admin123';
CREATE USER 'test_user'@'localhost' IDENTIFIED BY 'test123';
CREATE DATABASE appWeb_db;
CREATE DATABASE test_db;
GRANT ALL PRIVILEGES ON appWeb_db. * TO 'admin_app'@'localhost';
GRANT ALL PRIVILEGES ON test_db. * TO 'test_user'@'localhost';

CREATE TABLE appWeb_db.user(
	_id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(30) NOT NULL,
  password varchar(30) NOT NULL,
  PRIMARY KEY (_id)
);

CREATE TABLE test_db.user(
	_id int(11) NOT NULL AUTO_INCREMENT,
  user_name varchar(30) NOT NULL,
  password varchar(30) NOT NULL,
  PRIMARY KEY (_id)
);

CREATE TABLE appWeb_db.role(
	_id int(11) NOT NULL AUTO_INCREMENT,
  role varchar(20) NOT NULL,
  user_id varchar(11) NOT NULL,
  PRIMARY KEY (_id),
  FOREIGN KEY (user_id) REFERENCES user (_id) ON DELETE CASCADE
);

CREATE TABLE test_db.role(
   _id int(11) NOT NULL AUTO_INCREMENT,
  role varchar(20) NOT NULL,
  user_id varchar(11) NOT NULL,
  PRIMARY KEY (_id),
  FOREIGN KEY (user_id) REFERENCES user (_id) ON DELETE CASCADE
);
