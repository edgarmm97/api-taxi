drop table if exists cat_usuario;

/*==============================================================*/
/* table: cat_usuario                                           */
/*==============================================================*/
create table cat_usuario
(
   id_usuario           int not null AUTO_INCREMENT,
   nombre               varchar(20),
   ap_paterno           varchar(20),
   ap_materno           varchar(20),
   correo_electronio    varchar(50),
   contrasenia          varchar(255),
   is_deleted           tinyint,
   is_activo            tinyint,
   login_at             datetime,
   created_at           datetime,
   updated_at           datetime,
   deleted_at           datetime,
   num_telefono         varchar(10),
   fecha_nacimiento     datetime,
   sexo                 tinyint,
   primary key (id_usuario)
);

drop table if exists cat_chofer;

/*==============================================================*/
/* table: cat_chofer                                            */
/*==============================================================*/
create table cat_chofer
(
   id_chofer            int not null,
   nombre               varchar(20),
   ap_paterno           varchar(20),
   ap_materno           varchar(20),
   tarjeton             varchar(13),
   vencimiento_tarjeton datetime,
   vencimiento_licencia datetime,
   qr_tarjeton          text,
   created_at           datetime,
   updated_at           datetime,
   deleted_at           datetime,
   is_deleted           datetime,
   foto                 text,
   correo_electronico   varchar(50),
   num_telefono         varchar(10),
   primary key (id_chofer)
);

drop table if exists cat_unidad;

/*==============================================================*/
/* table: cat_unidad                                            */
/*==============================================================*/
create table cat_unidad
(
   id_unidad            int not null,
   placa                varchar(10),
   num_economico        varchar(10),
   marca                varchar(50),
   modelo               varchar(50),
   qr_vehiculo          text,
   concesion            text,
   primary key (id_unidad)
);

drop table if exists aud_solicitud;

/*==============================================================*/
/* table: aud_solicitud                                         */
/*==============================================================*/
create table aud_solicitud
(
   id_solicitud         int not null,
   id_usuario           int,
   id_unidad            int,
   hora_solicitud       datetime,
   hora_llegada         datetime,
   is_activo            tinyint,
   latitud              float,
   longitud             float,
   primary key (id_solicitud)
);

drop table if exists aud_viaje;

/*==============================================================*/
/* table: aud_viaje                                             */
/*==============================================================*/
create table aud_viaje
(
   id_viaje             int not null,
   id_unidad            int,
   id_chofer            int,
   id_usuario           int,
   total                float,
   uid                  varchar(36),
   hora_inicio          datetime,
   hora_fin             datetime,
   latitud_inicio       float,
   longitud_inicio      float,
   latitud_llegada      float,
   longitud_llegada     float,
   primary key (id_viaje)
);

drop table if exists aud_sesion_transporte;

/*==============================================================*/
/* table: aud_sesion_transporte                                 */
/*==============================================================*/
create table aud_sesion_transporte
(
   id_sesion_transporte int not null,
   id_chofer            int,
   id_unidad            int,
   login_at             datetime,
   is_servicio          tinyint,
   is_viaje             tinyint,
   is_solicitud         tinyint,
   primary key (id_sesion_transporte)
);

