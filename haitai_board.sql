create table haitai_board (
    idx int auto_increment,
    name varchar(50) not null,
    email varchar(100) not null,
    subject varchar(100) not null,
    content varchar(1000) not null,
    write_pass varchar(50) not null,
    regdate varchar(20),
    hit int default 0,
    primary key(idx)
)engine=innoDB charset=utf8;