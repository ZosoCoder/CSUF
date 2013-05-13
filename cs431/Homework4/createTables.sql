CREATE TABLE IF NOT EXISTS USERS (
	UserFullName varchar(255) NOT NULL,
	Username varchar(255) NOT NULL,
	Password varchar(255) NOT NULL,
	PRIMARY KEY (Username)
);

CREATE TABLE PHOTOS (
	PhotoName varchar(255) NOT NULL,
	caption varchar(255),
	photodata mediumblob NOT NULL,
	mimetype ENUM('image/png', 'image/jpg', 'image/gif', 'image/jpeg'),
	Username varchar(255) NOT NULL,
	FOREIGN KEY(Username) REFERENCES USERS(Username)
);