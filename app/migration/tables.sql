drop table if exists users;
create table users
(
    id bigserial primary key,
    name TEXT,
    description TEXT,
    email TEXT,
    password TEXT,
    address TEXT,
    tel varchar(50),
    age int,
    deleted boolean default false,
    created timestamp default now(),
    updated timestamp default now()
);

