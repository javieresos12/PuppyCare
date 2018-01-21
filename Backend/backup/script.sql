create database puppycare;
use puppycare;
show tables;
create table usuarios(
	Ind int primary key auto_increment,
    Nombres varchar(60) null,
    Apellidos varchar(60) null,
    Cedula int null,
    Telefono int(15) null,
    Celular varchar(25) null,
    Ciudad varchar(20) null,
    Email varchar(30) not null,
    Nombre_Usuario varchar(16) not null,
    Contraseña text not null,
    Token text not null,
    Rol varchar(15) default "Usuario",
    Pass_key text not null,
    Estado varchar(10) default "NoActivado",
    Estado_Inf varchar(10) default "Incompleto",
    Estado_Conexion varchar(15) default "Desconectado",
    Fecha_Creacion datetime default current_timestamp,
	Fecha_Ultima_Conexion datetime null,
    Foto_Perfil varchar(500) null
);

insert into usuarios(Email, Nombre_Usuario, Contraseña, Estado, Foto_Perfil) 
					values 
                    ("wijurost@gmail.com", "WinstonR96", md5("123"), "Activado", "https://instagram.fctg1-1.fna.fbcdn.net/t51.2885-15/e35/11378811_609541975864417_1758677152_n.jpg");

create table mascotas(
	Ind int primary key auto_increment,
    Nombre varchar(60) null,
    Raza varchar(25) null,
    Ciudad varchar(25) null,
    Edad varchar(10) null,
    Descripcion text null,
    Foto text null
);

insert into mascotas(Nombre, Raza, Ciudad, Edad, Descripcion)
					values
                    ("Princesa","Chanda","Barranquilla", "1 año", "Perro chanda disponible para adopcion", "https://instagram.fctg1-1.fna.fbcdn.net/t51.2885-15/e35/18514084_284958161966795_8985987223014866944_n.jpg");


create table soporte(
	Ind int primary key auto_increment,
    Fecha_radicado datetime default current_timestamp,
    Descripcion text not null,
    Id_usuario int not null,
    Estado varchar(15) default "Enviado",
    Respuesta varchar(500) default "Sin respuesta",
    constraint fk_user foreign key (Id_usuario) references usuarios(Ind)
);

create table adopcion(
	Ind int primary key auto_increment,
    Id_mascota int not null,
    Id_usuario int not null,
    Fecha_solicitud datetime default current_timestamp,
    Estado varchar(15) default "Solicitado",
    constraint fk_admc foreign key (Id_mascota) references mascotas(Ind),
    constraint fk_adus foreign key (Id_usuario) references usuarios(Ind)
);

select ad.Ind, mc.Nombre, ad.Id_usuario, ad.Fecha_solicitud, ad.Estado from adopcion as ad, mascotas as mc, usuarios as us where ad.Id_mascota = mc.Ind and ad.Id_usuario = us.Ind;


drop table usuarios;
drop table mascotas;
drop table soporte;
drop table adopcion;
select * from usuarios;
select * from mascotas;
select * from soporte;
select * from adopcion;