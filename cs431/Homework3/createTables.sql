CREATE TABLE USERS (
	UserFullName varchar(255) NOT NULL,
	Username varchar(255) NOT NULL,
	Password varchar(255) NOT NULL,
	PRIMARY KEY (Username)
);

CREATE TABLE MAILBOX (
	MessageID int NOT NULL AUTO_INCREMENT,
	Subject varchar(255),
	MsgTime datetime NOT NULL,
	MsgText text,
	Sender varchar(255) NOT NULL,
	Receiver varchar(255) NOT NULL,
	Status varchar(6) NOT NULL,
	PRIMARY KEY (MessageID),
	FOREIGN KEY (Sender) REFERENCES USERS(Username),
	FOREIGN KEY (Receiver) REFERENCES USERS(Username)
);

INSERT INTO USERS VALUES('Richard Hammond','CaptHamster',Password('porsche'));
INSERT INTO USERS VALUES('Jeremy Clarkson','CaptJezza',Password('merc'));
INSERT INTO USERS VALUES('James May','CaptSlow',Password('alfa'));

INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,Status)
	VALUES('Check out the new 911 Turbo', NOW(), 'It will lap your merc!', 'CaptHamster', 'CaptJezza','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,Status)
	VALUES('(no subject)', NOW(), 'Hurry up, James!', 'CaptHamster', 'CaptSlow','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,Status)
	VALUES('911 Turbo', NOW(), "It's just a beetle", 'CaptJezza', 'CaptHamster','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,Status)
	VALUES('CAPTAIN SLOW!!', NOW(), 'Hurry up, James', 'CaptJezza', 'CaptSlow','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,Status)
	VALUES('Ello', NOW(), 'I just spent the night replacing my piston heads!', 'CaptSlow', 'CaptJezza','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,Status)
	VALUES('Alfa', NOW(), 'You must check out my new ride, Hammond', 'CaptSlow', 'CaptHamster','Unread');