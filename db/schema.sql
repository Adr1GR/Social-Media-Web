create table if not exists usuario (
    id integer primary key auto_increment,
    nombre varchar(10) not null unique,
    clave varchar(512) not null,
    email varchar(200) not null,
    avatar varchar(200),
    registrado integer not null default UNIX_TIMESTAMP()
) engine=InnoDB;

create table if not exists entrada (
    id integer primary key auto_increment,
    texto varchar(128) not null,
    imagen varchar(200) default null,
    autor integer not null,
    creado integer not null default UNIX_TIMESTAMP(),
    constraint fk_autor_usuario foreign key (autor) references usuario (id)
) engine=InnoDB;

create table if not exists megusta (
    id integer primary key auto_increment,
    usuario int not null,
    entrada int not null,
    constraint unique_item_tag unique (usuario, entrada),
    constraint fk_usuario_megusta_usuario foreign key (usuario) references usuario (id) on delete cascade,
    constraint fk_entrada_megusta_entrada foreign key (entrada) references entrada (id) on delete cascade
) engine=InnoDB;

create table if not exists comentario (
    id integer primary key auto_increment,
    comentario varchar(64) not null,
    usuario int not null,
    entrada int not null,
    constraint unique_item_tag unique (usuario, entrada),
    constraint fk_usuario_comentario_usuario foreign key (usuario) references usuario (id) on delete cascade,
    constraint fk_entrada_comentario_entrada foreign key (entrada) references entrada (id) on delete cascade
) engine=InnoDB;
