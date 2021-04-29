CREATE TABLE IMSlogin
( 
  userName varchar(16) primary key,
  userPassword char(40) not null,
  Email varchar(100) not null
);

CREATE TABLE IMSitem
(
  itemName varchar(40) primary key,
  itemPrice float(4, 2) not null,
  itemQty  tinyint unsigned not null
);