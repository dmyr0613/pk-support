drop database if exists pksupport;
create database pksupport default character set utf8 collate utf8_general_ci;
grant all on pksupport.* to 'sbs'@'localhost' identified by 'sbs_toro';
use pksupport;

create table userinfo (
  user_id varchar(15) not null unique,
	name varchar(100) not null,
	password varchar(15) not null,
  email varchar(30),
  department varchar(100),
  person varchar(100)
);

insert into userinfo values('111','SBS総合病院','111','d_ota@sbs-infosys.co.jp','医療事業本部','太田大介');


-----------


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
  no SERIAL auto_increment primary key,
  kanja_id int not null,
	line_id varchar(100) not null not null,
  phone_no varchar(100) not null
);

create table facility (
	no SERIAL primary key,
  facility_code varchar(50) not null unique,
	name varchar(100) not null,
	password varchar(100) not null
);

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

-- insert into kanja values('9000001', '駿河　葵', '9000001', 'U657e8de8b409504ac329af7ebcefc723', '駿河LINE', '', '');
-- insert into kanja values('9000001', '駿河　葵', '9000001', '111111111', '駿河LINE', '', '');
-- insert into kanja values('9000002', '静岡　菜々子', '9000002', '222222222', '菜々子LINE', '', '');
-- insert into kanja values('9000003', '菊川　良子', '9000003', '333333333', '菊川LINE', '', '');
insert into kanja values('9000002','静岡　菜々子','9000002','222222222','09012345678','','');
insert into kanja values('9000003','菊川　良子','9000003','333333333','09012345678','','');
insert into kanja values('222','Matsu','222','Uebf74ca3eba8f139972dda65ed5873ae','09012345678','1234567890','09:00');
insert into kanja values('777','鈴木','aaa','U96769b144c492370726277a567ce5108','09012345678','1234567890','09:00');
insert into kanja values('9000001','駿河　葵','9000001','111111111','09012345678','1234567890','09:00');
insert into kanja values('333','原田','sbs1404','U61d18c70ef94c6d4c3cf826dc4f72813','09012345678','1234567890','09:00');
insert into kanja values('12345','Shimizu','qazx','U3b7289f3698d67aed6869267ee07f679','09012345678','1234567890','09:00');
insert into kanja values('111','太田','111','U657e8de8b409504ac329af7ebcefc723','09012345678','1234567890','10:30');
insert into kanja values('111301','寺内啓海','11130','Ufdaf811d7c44b9a7738180f01faeb2f6','09012345678','1234567890','10:30');
insert into kanja values('123456','むらまつ','2233','U28013302cde74a3c683ee51166782f50','09012345678','1234567890','10:30');

insert into kanja_line values(null, '9000001', '111111111', '駿河LINE');
insert into kanja_line values(null, '9000002', '222222222', '菜々子LINE');
insert into kanja_line values(null, '9000003', '333333333', '菊川LINE');

	insert into facility values(1, '1234567890', 'SBSクリニック', '1234567890');
	insert into facility values(2, '9876543210', 'MARCS診療所', '9876543210');

insert into device values('dmyr-iPhone6s', 'SBS太田');
insert into device values('HamiPhone', 'SBS延原');
insert into device values("Jupon's-iPhone7", 'SBS佐野');
insert into device values('SugihoiPhone', 'SBS杉保');
insert into device values('kazu-iPhone', 'SBS松永');
insert into device values('net121iPhone', 'SBS原田');
insert into device values('takayama', 'SBS高山');

insert into device values('Maulana', 'SBSアリフ');
insert into device values('iPhone', 'SBS寺本');

insert into beacon values('D546DF97-4757-47EF-BE09-3E2DCBDD0C77', '医療2階', 'FeasyBeacom');
insert into beacon values('00000000-14FD-1001-B000-001C4D64F49A', 'ブースB', 'SK19008');
insert into beacon values('00000000-216E-1001-B000-001C4D64988A', 'ブースA', 'SK19009');
insert into beacon values('00000000-67FB-1001-B000-001C4DAEA337', 'ブースC', 'SK19010');
insert into beacon values('00000000-5C83-1001-B000-001C4D265200', 'ブースD', 'SK19011');
insert into beacon values('00000000-C5E4-1001-B000-001C4D495191', 'ブースE', 'SK19012');

insert into beacon values('00000000-5C83-1001-B000-001C4D265200', '6F交流ホール', 'SK19011');
insert into beacon values('00000000-C5E4-1001-B000-001C4D495191', '9Fセミナー会場', 'SK19012');

--SK19008
  update beacon
  set name = 'ブース1'
  where uuid = '00000000-14FD-1001-B000-001C4D64F49A';
--SK19009
  update beacon
  set name = 'ブース2'
  where uuid = '00000000-216E-1001-B000-001C4D64988A';
--SK19010
  update beacon
  set name = 'ブース3'
  where uuid = '00000000-67FB-1001-B000-001C4DAEA337';
--SK19011
  update beacon
  set name = 'ブース4'
  where uuid = '00000000-5C83-1001-B000-001C4D265200';
--SK19012
  update beacon
  set name = 'ブース5'
  where uuid = '00000000-C5E4-1001-B000-001C4D495191';


-- locationからデバイス毎の最新情報を取得する
  select COALESCE(b.name,a.device_name) disp_name,a.device_name,COALESCE(c.name,a.uuid) beacon_name,
         a.uuid,a.lat,a.lon,a.proximity,a.status,a.update_datetime
    from (
         (
         select aa.*
           from location aa inner join
                (select device_name,max(update_datetime) update_datetime from location group by device_name) bb
             on aa.device_name     = bb.device_name
            and aa.update_datetime = bb.update_datetime
         ) a
         left join device b on a.device_name = b.device_name
         )
         left join beacon c on a.uuid = c.uuid
   order by update_datetime desc

-- locationからデバイス名指定で全データを取得する
-- select COALESCE(b.name,a.device_name) disp_name,a.device_name,COALESCE(c.name,a.uuid) beacon_name,
--        a.uuid,a.lat,a.lon,a.proximity,a.status,a.update_datetime
--   from location a
--        inner join device b
--                on a.device_name = b.device_name
--               and b.device_name = 'dmyr-iPhone6s'
--         left join beacon c
--                on a.uuid        = c.uuid
--  order by update_datetime desc

 -- locationからデバイス名指定で全データを取得する
 select COALESCE(c.name,a.uuid) beacon_name,
       a.uuid,a.lat,a.lon,a.proximity,a.status,a.update_datetime
  from location a inner join beacon c
    on a.uuid        = c.uuid
   and a.device_name = 'dmyr-iPhone6s'
 order by update_datetime desc

 -- locationからデバイス名指定で全データを取得する2
  select c.comment,a.status,a.update_datetime,a.proximity,
       a.uuid,a.lat,a.lon
  from location a inner join beacon c
    on a.uuid        = c.uuid
   and a.device_name = 'dmyr-iPhone6s'
 order by update_datetime desc

--削除
 delete from location
  where device_name = 'dmyr-iPhone6s'

  delete from location
   where update_datetime < '2019/07/03'

   -- 最新のlocationデータを取得する
   SELECT *
     FROM location AS A
    WHERE update_datetime = (
        SELECT MAX(update_datetime)
        FROM location AS B
        WHERE A.device_name = B.device_name
          AND B.device_name = 'kazu-iPhone'
          AND B.UUID        = '00000000-14FD-1001-B000-001C4D64F49A'
        )
      AND A.device_name     = 'kazu-iPhone'
      AND A.UUID            = '00000000-14FD-1001-B000-001C4D64F49A'
