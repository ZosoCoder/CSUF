CREATE TABLE USERS (
    Fullname varchar(255) NOT NULL,
    Username varchar(255) NOT NULL,
    Password varchar(255) NOT NULL,
    Status varchar(10) NOT NULL,
    PRIMARY KEY (Username)
) ENGINE=InnoDB;

CREATE TABLE MAILBOX (
    MessageID int NOT NULL AUTO_INCREMENT,
    Subject varchar(255),
    MsgTime datetime NOT NULL,
    MsgText text,
    Sender varchar(255) NOT NULL,
    Receiver varchar(255) NOT NULL,
    InStatus varchar(10) NOT NULL,
    OutStatus varchar(10) NOT NULL,
    PRIMARY KEY (MessageID),
    CONSTRAINT FOREIGN KEY (Sender) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (Receiver) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE CHATROOMS (
    RoomId int NOT NULL AUTO_INCREMENT,
    Creator varchar(255) NOT NULL,
    PRIMARY KEY (RoomId),
    CONSTRAINT FOREIGN KEY (Creator) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE CHATMSGS (
    MsgId int NOT NULL AUTO_INCREMENT,
    MsgText text,
    Author varchar(255) NOT NULL,
    Chatroom int NOT NULL,
    PRIMARY KEY (MsgId),
    CONSTRAINT FOREIGN KEY (Author) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (Chatroom) REFERENCES CHATROOMS(RoomId) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE CLUBS (
    ClubName varchar(255) NOT NULL,
    Picture mediumblob,
    mimetype ENUM('image/png', 'image/jpg', 'image/gif', 'image/jpeg'),
    Profile text,
    Admin varchar(255),
    PRIMARY KEY (ClubName),
    CONSTRAINT FOREIGN KEY (Admin) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE FORUMS (
    ForumId int NOT NULL AUTO_INCREMENT,
    ForumName varchar(255) NOT NULL,
    Description varchar(255) NOT NULL,
    Club varchar(255) NOT NULL,
    Moderator varchar(255) NOT NULL,
    PRIMARY KEY (ForumId),
    CONSTRAINT FOREIGN KEY (Club) REFERENCES CLUBS(ClubName) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (Moderator) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE THREADS (
    ThreadId int NOT NULL AUTO_INCREMENT,
    Title varchar(255) NOT NULL,
    DateCreated datetime NOT NULL,
    Creator varchar(255) NOT NULL,
    Forum int NOT NULL,
    PRIMARY KEY (ThreadId),
    CONSTRAINT FOREIGN KEY (Creator) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (Forum) REFERENCES FORUMS(ForumId) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE POSTS (
    PostId int NOT NULL AUTO_INCREMENT,
    PostText text NOT NULL,
    PostTime datetime NOT NULL,
    Author varchar(255) NOT NULL,
    Thread int NOT NULL,
    PRIMARY KEY (PostId),
    CONSTRAINT FOREIGN KEY (Author) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (Thread) REFERENCES THREADS(ThreadId) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE CLUBMEMBERS (
    Club varchar(255) NOT NULL,
    User varchar(255) NOT NULL,
    CONSTRAINT FOREIGN KEY (Club) REFERENCES CLUBS(ClubName) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (User) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE CLUBREQUESTS (
    Club varchar(255) NOT NULL,
    User varchar(255) NOT NULL,
    CONSTRAINT FOREIGN KEY (Club) REFERENCES CLUBS(ClubName) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (User) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE CHATMEMBERS (
    Chatroom int NOT NULL,
    User varchar(255) NOT NULL,
    CONSTRAINT FOREIGN KEY (Chatroom) REFERENCES CHATROOMS(RoomId) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT FOREIGN KEY (User) REFERENCES USERS(Username) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

INSERT INTO USERS VALUES('Administrator','admin',Password('admin'),'allowed');
INSERT INTO USERS VALUES('Anthony Gonzalez','ZosoCoder',Password('pass'),'allowed');
INSERT INTO USERS VALUES('Richard Hammond','CaptHamster',Password('turbo'),'allowed');
INSERT INTO USERS VALUES('Jeremy Clarkson','CaptJezza',Password('merc'),'allowed');
INSERT INTO USERS VALUES('James May','CaptSlow',Password('alfa'),'allowed');

INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,InStatus,OutStatus)
    VALUES('Check out the new 911 Turbo', NOW(), 'It will lap your merc!', 'CaptHamster', 'CaptJezza','Unread','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,InStatus,OutStatus)
    VALUES('(no subject)', NOW(), 'Hurry up, James!', 'CaptHamster', 'CaptSlow','Unread','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,InStatus,OutStatus)
    VALUES('911 Turbo', NOW(), "It's just a beetle", 'CaptJezza', 'CaptHamster','Unread','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,InStatus,OutStatus)
    VALUES('CAPTAIN SLOW!!', NOW(), 'Hurry up, James', 'CaptJezza', 'CaptSlow','Unread','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,InStatus,OutStatus)
    VALUES('Ello', NOW(), 'I just spent the night replacing my piston heads!', 'CaptSlow', 'CaptJezza','Unread','Unread');
INSERT INTO MAILBOX (Subject,MsgTime,MsgText,Sender,Receiver,InStatus,OutStatus)
    VALUES('Alfa', NOW(), 'You must check out my new ride, Hammond', 'CaptSlow', 'CaptHamster','Unread','Unread');

