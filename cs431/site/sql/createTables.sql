CREATE TABLE USERS (
    Fullname varchar(255) NOT NULL,
    Username varchar(255) NOT NULL,
    Password varchar(255) NOT NULL,
    Status varchar(10) NOT NULL,
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

CREATE TABLE CHATROOMS (
    RoomId int NOT NULL AUTO_INCREMENT,
    Creator varchar(255) NOT NULL,
    PRIMARY KEY (RoomId),
    FOREIGN KEY (Creator) REFERENCES USERS(Username)
);

CREATE TABLE CHATMSGS (
    MsgId int NOT NULL AUTO_INCREMENT,
    MsgText text,
    Author varchar(255) NOT NULL,
    Chatroom int NOT NULL,
    PRIMARY KEY (MsgId),
    FOREIGN KEY (Author) REFERENCES USERS(Username),
    FOREIGN KEY (Chatroom) REFERENCES CHATROOMS(RoomId)
);

CREATE TABLE CLUBS (
    ClubName varchar(255) NOT NULL,
    Picture mediumblob,
    mimetype ENUM('image/png', 'image/jpg', 'image/gif', 'image/jpeg'),
    Profile text,
    Moderator varchar(255),
    PRIMARY KEY (ClubName),
    FOREIGN KEY (Moderator) REFERENCES USERS(Username)
);

CREATE TABLE FORUMS (
    ForumName varchar(255) NOT NULL,
    Description varchar(255) NOT NULL,
    Club varchar(255) NOT NULL,
    Moderator varchar(255),
    PRIMARY KEY (ForumName),
    FOREIGN KEY (Club) REFERENCES CLUBS(ClubName),
    FOREIGN KEY (Moderator) REFERENCES USERS(Username)
);

CREATE TABLE THREADS (
    ThreadId int NOT NULL AUTO_INCREMENT,
    Title varchar(255) NOT NULL,
    DateCreated datetime NOT NULL,
    Creator varchar(255) NOT NULL,
    Forum varchar(255) NOT NULL,
    PRIMARY KEY (ThreadId),
    FOREIGN KEY (Creator) REFERENCES USERS(Username),
    FOREIGN KEY (Forum) REFERENCES FORUMS(ForumName)
);

CREATE TABLE POSTS (
    PostId int NOT NULL AUTO_INCREMENT,
    PostText text NOT NULL,
    PostTime datetime NOT NULL,
    Author varchar(255) NOT NULL,
    Thread int NOT NULL,
    PRIMARY KEY (PostId),
    FOREIGN KEY (Author) REFERENCES USERS(Username),
    FOREIGN KEY (Thread) REFERENCES THREADS(ThreadId)
);

CREATE TABLE CLUBMEMBERS (
    Club varchar(255) NOT NULL,
    User varchar(255) NOT NULL,
    FOREIGN KEY (Club) REFERENCES CLUBS(ClubName),
    FOREIGN KEY (User) REFERENCES USERS(Username)
);

CREATE TABLE CHATMEMBERS (
    Chatroom int NOT NULL,
    User varchar(255) NOT NULL,
    FOREIGN KEY (Chatroom) REFERENCES CHATROOMS(RoomId),
    FOREIGN KEY (User) REFERENCES USERS(Username)
);

INSERT INTO USERS VALUES('Administrator','admin',Password('admin'),'allowed');
INSERT INTO USERS VALUES('Anthony Gonzalez','ZosoCoder',Password('pass'),'allowed');
INSERT INTO USERS VALUES('Richard Hammond','CaptHamster',Password('turbo'),'allowed');
INSERT INTO USERS VALUES('Jeremy Clarkson','CaptJezza',Password('merc'),'allowed');
INSERT INTO USERS VALUES('James May','CaptSlow',Password('alfa'),'allowed');

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