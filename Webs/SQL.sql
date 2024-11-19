insert into meetingdate values 
('1','1','1','2024-11-10 08:00:00','Done'),
('2','2','2','2024-11-10 09:00:00','In progress'),
('3','3','3','2024-11-10 10:00:00','Succeeded'),
('4','4','4','2024-11-10 11:00:00','Failed');

SET FOREIGN_KEY_CHECKS = 0;
drop table users

create table users(
	Id varchar(20) PRIMARY KEY,
    name varchar(20),
    pass varchar(50),
    username varchar(50),
    useremail varchar(50),
    phone varchar(20),
    address varchar(50),
    usertype varchar(20)
);