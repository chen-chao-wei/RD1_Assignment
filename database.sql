CREATE DATABASE weather;
CREATE TABLE today (id int NOT NULL PRIMARY KEY AUTO_INCREMENT,locationName varchar(50),stime datetime ,etime datetime,Wx varchar(30),minT varchar(30),maxT varchar(30),POP varchar(30),CI varchar(30));
CREATE TABLE week (id int NOT NULL PRIMARY KEY AUTO_INCREMENT,locationName varchar(50),stime datetime ,etime datetime,Wx varchar(30),minT varchar(30),maxT varchar(30),POP varchar(30),CI varchar(30));
CREATE TABLE obsrain (id varchar(11) NOT NULL PRIMARY KEY ,locationName varchar(50),obsStationName varchar(50),obsTime datetime ,HOUR_24 varchar(30),RAIN varchar(30));