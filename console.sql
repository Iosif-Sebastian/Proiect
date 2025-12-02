create table users(
    id int auto_increment primary key,
    name varchar(255) NOT NULL ,
    prenume varchar(255) not null,
    email varchar(255) not null unique ,
    password varchar(255) not null
)


