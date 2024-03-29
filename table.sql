DROP TABLE feedbackBooking;
DROP TABLE feedbackDocument;
DROP TABLE helpers;
DROP TABLE participants;
DROP TABLE schedule;
DROP TABLE societyevent;
DROP TABLE documentation;
DROP TABLE booking;
DROP TABLE announcement;
DROP TABLE venue;
DROP TABLE transhistory;
DROP TABLE student;
DROP TABLE society;
DROP TABLE admin;
DROP TABLE uniStudent;

CREATE TABLE uniStudent(
    studID        int(10)      not null,
    studName      varchar(50)  not null,
    PRIMARY KEY(studID)
);

CREATE TABLE admin(
    adminID      varchar(10)   not null,
    password     varchar(255)  not null,
    PRIMARY KEY(adminID)
);

CREATE TABLE society(
    societyID      varchar(10)    not null,
    societyName    varchar(100)   not null,
    societyDesc    varchar(300)   not null,
    societyPass    varchar(255)   not null,
    societyAcc     decimal(10,2)  not null,
    PRIMARY KEY(societyID)
);

CREATE TABLE student(
    userID        varchar(10)  not null,
    username      varchar(300) not null,
    password      varchar(255) not null,
    studEmail     varchar(300) not null,
    studID        int(10)      not null,
    PRIMARY KEY(userID),
    FOREIGN KEY(studID) references uniStudent(studID)
);

CREATE TABLE transhistory(
    transID       INT(6) auto_increment not null,
    transDate     date                  not null,
    amount        decimal(10,2)         not null,
    purpose       varchar(300)          not null,
    societyID     varchar(10)           not null,
    PRIMARY KEY(transID),
    FOREIGN KEY (societyID) REFERENCES society(societyID)
);

CREATE TABLE venue(
    venueID        varchar(10)   not null,
    venueName      varchar(20)   not null,
    venueDesc      varchar(100)  not null,
    venueStatus    varchar(10)   not null,
    PRIMARY KEY(venueID)
);

CREATE TABLE announcement(
    annID         varchar(10)    not null,
    annTitle      varchar(200)   not null,
    annContent    varchar(500)   not null,
    annDate       date           not null,
    adminID       varchar(10)    not null,
    PRIMARY KEY(annID),
    FOREIGN KEY(adminID) references admin(adminID)
);

CREATE TABLE booking (
    bookingID  INT(6) auto_increment not null,
    purpose    VARCHAR(300)          not null,
    bookDate   DATE                  not null,
    startTime  TIME                  not null,
    endTime    TIME                  not null,
    bookStatus VARCHAR(300)          not null,
    societyID  VARCHAR(10)           not null,
    venueID    varchar(10)           not null,
    PRIMARY KEY (bookingID),
    FOREIGN KEY (venueID)   REFERENCES venue(venueID),
    FOREIGN KEY (societyID) REFERENCES society(societyID)
);

CREATE TABLE documentation(
    docID         INT(6) auto_increment not null,
    docName       VARCHAR(300)          not null,
    mime          VARCHAR(300)          not null,
    docContent    LONGBLOB              not null,
    applyDate     DATETIME              not null,
    societyID     VARCHAR(300)          not null,
    status        VARCHAR(300)          not null,
    PRIMARY KEY (docID),
    FOREIGN KEY (societyID) REFERENCES society(societyID)
);

CREATE TABLE SocietyEvent(
    eventID            int(6) auto_increment not null,
    eventName          varchar(300)           not null,
    eventDesc          varchar(300)          not null,
    eventCategory      varchar(20)           not null,
    image              longblob              not null,
    noOfHelper         int(255)              not null,
    contactNo          varchar(300)          not null,
    societyID          varchar(10)           not null,
    applyID            int(11)               not null,
    PRIMARY KEY(eventID),
    FOREIGN KEY (societyID) REFERENCES society(societyID)
);

CREATE TABLE Schedule(
    scheduleID      INT(6)      not null auto_increment,
    venue           VARCHAR(255)not null,
    startDate       DATE        not null,
    startTime       TIME        not null,
    endDate         DATE        null,
    endTime         TIME        null,
    unlimited       VARCHAR(255)null,
    noOfParticipant INT(255)    null,
    noOfJoined      INT(6)      null,
    scheduleStatus VARCHAR(255) not null,
    eventID         INT(6)      not null,
    PRIMARY KEY(scheduleID),
    FOREIGN KEY (eventID) REFERENCES SocietyEvent(eventID)
);

CREATE TABLE participants(
    scheduleID       INT(6)       not null,
    eventID          INT(6)       not null,
    userID           VARCHAR(300) not null,
    applyDate        DATETIME     not null,
    applyStatus      VARCHAR(300) not null,
    attendanceStatus VARCHAR(300) not null,
    PRIMARY KEY(scheduleID,eventID,userID),
    FOREIGN KEY (scheduleID) REFERENCES Schedule(scheduleID),
    FOREIGN KEY (eventID)    REFERENCES SocietyEvent(eventID),
    FOREIGN KEY (userID)     REFERENCES student(userID)
);

CREATE TABLE helpers(
    eventID          INT(6)       not null,
    userID           VARCHAR(300) not null,
    applyDate        DATETIME     not null,
    applyStatus      VARCHAR(300) not null,
    PRIMARY KEY(eventID,userID),
    FOREIGN KEY (eventID) REFERENCES SocietyEvent(eventID),
    FOREIGN KEY (userID) REFERENCES student(userID)
);

CREATE TABLE feedbackDocument(
    feedbackDocumentID    int(6)      not null auto_increment,
    content               varchar(20) not null,
    adminID               varchar(10) not null,
    docID                 int(6)      not null,
    societyID             varchar(10) not null,
    PRIMARY KEY(feedbackDocumentID),
    FOREIGN KEY(adminID)   references admin(adminID),
    FOREIGN KEY(societyID) REFERENCES society(societyID),
    FOREIGN KEY(docID)     references documentation(docID)
);

CREATE TABLE feedbackBooking(
    feedbackBookingID int(6)      not null auto_increment,
    content           varchar(20) not null,
    adminID           varchar(10) not null,
    bookingID         int(6)      not null,
    societyID         varchar(10) not null,
    PRIMARY KEY(feedbackBookingID),
    FOREIGN KEY(adminID)   REFERENCES admin(adminID),
    FOREIGN KEY(societyID) REFERENCES society(societyID),
    FOREIGN KEY(bookingID) REFERENCES booking(bookingID)
);

INSERT INTO uniStudent (studID,studName) VALUES(1909705,'Tye Jun Hao');
INSERT INTO uniStudent (studID,studName) VALUES(1909656,'Ngo Kian Hee');
INSERT INTO uniStudent (studID,studName) VALUES(1909569,'Chin Ting Wei');
INSERT INTO uniStudent (studID,studName) VALUES(1909695,'Tee Sheng Te');
INSERT INTO uniStudent (studID,studName) VALUES(1909617,'Lee Kah Weng');
INSERT INTO uniStudent (studID,studName) VALUES(1909618,'Lee Khai Yan');
INSERT INTO uniStudent (studID,studName) VALUES(1909584,'Devin Choo Jian Chian');