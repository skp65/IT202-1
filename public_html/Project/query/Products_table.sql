CREATE TABLE Products (
ID int auto_increment,
name varchar(100) NOT NULL unique,
quantity int default 0,
price decimal(10,2) default 0.00,
description TEXT,
modified datetime default current_timestamp  on update current_timestamp,
created datetime default  current_timestamp,
PRIMARY KEY(ID)
)