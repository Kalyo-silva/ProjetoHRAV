create table tbsetor (
	setcodigo bigint not null,
	setdescricao varchar(200) not null,
	setativo smallint default 0,
	constraint pk_tbsetor primary key (setcodigo)
);

create table tbpergunta(
	percodigo bigint not null,
	perpergunta text not null,
	perativo smallint default 0,
	constraint pk_tbpergunta primary key (percodigo)
);

create table tbperguntasetor(
	percodigo bigint not null,
	setcodigo bigint not null,
	pstativo smallint not null default 0,
	constraint pk_tbperguntasetor primary key (percodigo, setcodigo),
	constraint fk_tbpergunta foreign key (percodigo)
	references tbpergunta(percodigo)
	        on update cascade on delete cascade,
	constraint fk_tbsetor foreign key(setcodigo)
	references tbsetor(setcodigo)
	        on update cascade on delete cascade
);

create table tbdispositivo(
	discodigo bigint not null,
	disstatus smallint not null default 0,
	disnome varchar(200) not null,
	setcodigo bigint not null
	constraint pk_tbdispositivo primary key (discodigo),
	constraint fk_tbsetor foreign key (setcodigo)
	references tbsetor(setcodigo)
	        on update cascade on delete cascade
);

create table tbavaliacao(
	avacodigo bigint not null,
	percodigo bigint not null,
	setcodigo bigint not null,
	discodigo bigint not null,
	avaresposta smallint not null,
	avafeedback text,
	avadatahora timestamp default now(),
	constraint pk_tbavaliacao primary key(avacodigo, percodigo),
    constraint fk_tbavaliacao_perguntasetor foreign key(percodigo,setcodigo) 
	references tbperguntasetor(percodigo,setcodigo),
	constraint fk_tbavaliacao_dispositivo foreign key(discodigo)
	references tbdispositivo(discodigo)
);

create table tbusuario(
	usucodigo bigint not null,
	usunome varchar(50) not null,
	ususenha varchar(32) not null,
	usuativo smallint not null default 0,
	constraint pk_tbusuario primary key(usucodigo)
);