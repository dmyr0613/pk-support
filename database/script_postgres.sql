drop database if exists pksupport;
create database pksupport default character set utf8 collate utf8_general_ci;
grant all on pksupport.* to 'sbs'@'localhost' identified by 'sbs_toro';
use pksupport;

drop table userinfo;
create table userinfo (
  user_id varchar(15) not null unique,
  kind int,
	facility_code varchar(15) not null,
  facility_name varchar(100) not null,
	password varchar(15) not null,
  email varchar(30),
  department varchar(100),
  person varchar(100)
);

--KIND:0=SBS管理者、1=病院、2=パートナー企業
insert into userinfo values('000',0,'C000','SBS情報システム','000','d_ota@sbs-infosys.co.jp','IS部','駿河 葵');
insert into userinfo values('001',1,'H001','SBS総合病院','001','d_ota@sbs-infosys.co.jp','情報室','菊川 良子');
insert into userinfo values('002',1,'H001','SBS総合病院','002','d_ota@sbs-infosys.co.jp','情報室','掛川 良夫');
insert into userinfo values('003',1,'H002','SBS医療センター','003','d_ota@sbs-infosys.co.jp','企画室','若林 源三');
insert into userinfo values('300',2,'C300','BSNアイネット','300','d_ota@sbs-infosys.co.jp','ヘルスケアビジネス事業部','前潟 新也');

--STEP_FLG:0=回答待ち、1=回答済み、2=完了
drop table inquiry;
create table inquiry (
  inquiry_no int not null unique,
  condition_flg int,
  insert_datetime timestamp,
  update_datetime timestamp,
  step_flg int,
  user_id varchar(15),
  facility_code varchar(15),
  facility_name varchar(100),
  priority_flg int,
	order_kind varchar(100),
	contents varchar(1000),
  kanja_id varchar(15),
  sbs_comment varchar(1000)
);

--シーケンス
CREATE SEQUENCE inquiry_seq;
--シーケンスの現在値取得（currvalは同じセッションにおいて、nextvalの値を戻すため、last_valueであれば最大値となる）
select currval('inquiry_seq');
SELECT last_value FROM inquiry_seq;

insert into inquiry
  (inquiry_no,condition_flg,insert_datetime,update_datetime,step_flg,user_id,facility_code,facility_name,priority_flg,order_kind,contents,kanja_id,sbs_comment)
  values(nextval('inquiry_seq'),0,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,0,'001','H001','SBS総合病院',0,'テストオーダ種','質問です。','1234567','SBS回答です。');

--ICONテーブル
drop table iconlist;
create table iconlist (
  code varchar(15) not null,
  icon_name varchar(100),
  disp_name varchar(100),
  keyword varchar(1000)
);

insert into iconlist values('1001','1001_医師','医師','医師、医者、男性医師');
insert into iconlist values('1002','1002_医師女性','女性医師','医師、医者、女性医師');
insert into iconlist values('1003','1003_看護師','女性看護師','看護師、女性看護師');
insert into iconlist values('1004','1004_看護師2','女性看護師','看護師、女性看護師');
insert into iconlist values('1005','1005_看護師男性','男性看護師','看護師、男性看護師');
insert into iconlist values('1006','1006_患者女性','患者女性','患者女性');
insert into iconlist values('1007','1007_患者男性','患者男性','患者男性');
insert into iconlist values('1008','1008_研修医','研修医','医師、医者、研修医、男性医師');
insert into iconlist values('1009','1009_薬剤師女性','薬剤師女性','薬剤師女性');
insert into iconlist values('1010','1010_手術医','手術医','手術医、オペ');
insert into iconlist values('1011','1011_医事課','医事課','医事課、事務');
insert into iconlist values('1012','1012_放射線技師','放射線技師','放射線技師、放射線科');
insert into iconlist values('1013','1013_療法士','療法士','療法士、リハビリ、理学、言語、');
insert into iconlist values('1014','1014_医療事務','医療事務','医療事務、医事課、メディカルクラーク');
insert into iconlist values('1015','1015_看護助手','看護助手','看護助手、ヘルパー');
insert into iconlist values('1016','1016_栄養士・検査技師','栄養士・検査技師','栄養士、検査技師');

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
