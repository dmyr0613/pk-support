drop database if exists marcs;
create database marcs default character set utf8 collate utf8_general_ci;
grant all on marcs.* to 'sbs'@'localhost' identified by 'sbs_toro';
use marcs;

create table kanja (
  kanja_id varchar(100) not null unique,
	name varchar(100) not null,
	password varchar(100) not null,
	line_id varchar(100) not null,
  phone_no varchar(100),
  facility_code varchar(50),
  yoyaku_datetime varchar(10)
);

create table kanja_line (
  no int auto_increment primary key,
  kanja_id int not null,
	line_id varchar(100) not null,
  phone_no varchar(100) not null
);

create table facility (
	no int auto_increment primary key,
  facility_code varchar(50) not null unique,
	name varchar(100) not null,
	password varchar(100) not null
);

--BeaFyl
create table location (
  device_name varchar(50) not null,
	uuid varchar(100),
	lat double precision,
  lon double precision,
  proximity varchar(10),
  status varchar(10),
  update_datetime timestamp
);

create table device (
  device_name varchar(50) not null,
  name varchar(100)
);

create table beacon (
  uuid varchar(100) not null,
  name varchar(100),
  comment varchar(100)
);

insert into kanja values( '9000001', '駿河　葵', '9000001', '111111111', '駿河LINE', null, null);
insert into kanja values( '9000002', '静岡　菜々子', '9000002', '222222222', '菜々子LINE', null, null);
insert into kanja values( '9000003', '菊川　良子', '9000003', '333333333', '菊川LINE', null, null);

insert into kanja_line values(null, '9000001', '111111111', '駿河LINE');
insert into kanja_line values(null, '9000002', '222222222', '菜々子LINE');
insert into kanja_line values(null, '9000003', '333333333', '菊川LINE');

insert into facility values(null, '1234567890', 'SBSクリニック', '1234567890');
insert into facility values(null, '9876543210', 'MARCS診療所', '9876543210');

--BeaFyl
insert into device values('dmyr-iPhone6s', 'SBS太田');

insert into beacon values('D546DF97-4757-47EF-BE09-3E2DCBDD0C77', '医療2階', 'FeasyBeacom');
insert into beacon values('00000000-14FD-1001-B000-001C4D64F49A', 'ブースB', 'SK19008');
insert into beacon values('00000000-216E-1001-B000-001C4D64988A', 'ブースA', 'SK19009');
insert into beacon values('00000000-67FB-1001-B000-001C4DAEA337', 'ブースC', 'SK19010');
insert into beacon values('00000000-5C83-1001-B000-001C4D265200', 'ブースD', 'SK19011');
insert into beacon values('00000000-C5E4-1001-B000-001C4D495191', 'ブースE', 'SK19012');

insert into location values('dmyr-iPhone-SE','00000000-14FD-1001-B000-001C4D64F49A','34.85972835087673','138.3043558471709','Unknown','IN','2019-06-30 09:01:59');
insert into location values('dmyr-iPhone-SE','00000000-216E-1001-B000-001C4D64988A','34.85972445706986','138.3043545640601','Unknown','OUT','2019-06-30 09:01:23');
insert into location values('dmyr-iPhone-SE','00000000-14FD-1001-B000-001C4D64F49A','34.859741512474116','138.30435213484486','Unknown','IN','2019-06-30 08:35:55');
insert into location values('dmyr-iPhone6s','00000000-14FD-1001-B000-001C4D64F49A','34.859678884001994','138.30435458979417','Unknown','OUT','2019-06-29 17:13:59');
insert into location values('dmyr-iPhone6s','00000000-14FD-1001-B000-001C4D64F49A','34.85975486590551','138.3043735667005','Far','IN','2019-06-29 17:12:48');
insert into location values('dmyr-iPhone6s','00000000-14FD-1001-B000-001C4D64F49A','34.85972631541296','138.3043543159505','Unknown','OUT','2019-06-29 17:05:36');
insert into location values('abc','00000000-216E-1001-B000-001C4D64988A','34.9589588615943','138.404754037019','near','IN','2019-06-03 14:00:56');
