CREATE TABLE restaurant.users(
	Username varchar(50) not null,
	UserEmail varchar(100) not null,
	passwordhash varchar(100) not null,
	salt varchar(100) not null,
	bdate varchar(100) not null,
	gender varchar(20) not null,
	favouratetype varchar(100),
	primary key (UserEmail),
	Unique (Username)
);
	
CREATE TABLE restaurant.restaurants(
	ID int not null auto_increment,
	ownername varchar(50) not null,
	RestaurantName varchar(100) not null,
	Location varchar(100) not null,
	Addresss varchar(100),
	RestaurantType varchar(100),
	Description varchar(500),
	PicturePath varchar(500),
	rating int default 0,
	primary key (ID)
);

CREATE TABLE restaurant.reviews(
	Rid int not null,
	name varchar(100) not null,
	comments varchar(500),
	foreign key (Rid) references restaurant.restaurants(ID)
	on delete cascade
	on update cascade
);
CREATE TABLE restaurant.rating(
	Rid int not null,
	Theuser varchar(50) not null,
	rate int default 0,
	foreign key (Rid) references restaurant.restaurants(ID)
	on delete cascade
	on update cascade,
	foreign key (Theuser) references restaurant.users(Username)
	on delete cascade
	on update cascade
);
