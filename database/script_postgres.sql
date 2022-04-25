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
insert into userinfo values('001',1,'H001','SBS総合病院','001','d_ota@sbs-infosys.co.jp','情報室','大空 翼');
insert into userinfo values('002',1,'H001','SBS総合病院','002','d_ota@sbs-infosys.co.jp','情報室','日向 小次郎');
insert into userinfo values('003',1,'H002','SBS医療センター','003','d_ota@sbs-infosys.co.jp','企画室','若林 源三');
insert into userinfo values('004',1,'H003','SBS市立病院','004','d_ota@sbs-infosys.co.jp','常駐SE','岬 太郎');
insert into userinfo values('300',2,'C300','BSNアイネット','300','d_ota@sbs-infosys.co.jp','ヘルスケアビジネス事業部','新田 駿');
--施設コード、施設名をユーザテーブルから取得する
select facility_code,facility_name from userinfo group by facility_code,facility_name having facility_code <> "C000"


--STEP_FLG:0=回答待ち、1=回答済み、2=完了
drop table inquiry;
create table inquiry (
--  inquiry_no int not null unique,
  inquiry_no int Primary Key AUTO_INCREMENT,
  condition_flg int,
  insert_datetime timestamp,
  update_datetime timestamp,
  step_flg int,
  user_id varchar(15),
  facility_code varchar(15),
  facility_name varchar(100),
  email varchar(30),
  department varchar(100),
  person varchar(100),
  priority_flg int,
	order_kind varchar(100),
	contents varchar(1000),
  kanja_id varchar(15),
  sbs_comment varchar(1000),
  file_name varchar(100)
);

--シーケンス（mySql時は利用せず）
CREATE SEQUENCE inquiry_seq;

--シーケンスの現在値取得（currvalは同じセッションにおいて、nextvalの値を戻すため、last_valueであれば最大値となる）
select currval('inquiry_seq');
SELECT last_value FROM inquiry_seq;
--シーケンスの現在値取得（mySQL）
SELECT last_insert_id(inquiry_no) FROM inquiry;

--PostgreSQL
insert into inquiry
  (inquiry_no,condition_flg,insert_datetime,update_datetime,step_flg,user_id,facility_code,facility_name,email,department,person,priority_flg,order_kind,contents,kanja_id,sbs_comment)
  values(nextval('inquiry_seq'),0,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,0,'001','H001','SBS総合病院','d_ota@sbs-infosys.co.jp','情報室','菊川 良子',0,'テストオーダ種','質問です。','1234567','SBS回答です。');

--mySQL
insert into inquiry
  (condition_flg,insert_datetime,update_datetime,step_flg,user_id,facility_code,facility_name,email,department,person,priority_flg,order_kind,contents,kanja_id,sbs_comment)
  values(0,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,0,'001','H001','SBS総合病院','d_ota@sbs-infosys.co.jp','情報室','菊川 良子',0,'テストオーダ種','質問です。','1234567','SBS回答です。');

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
insert into iconlist values('1010','1010_手術医','手術医','手術医、オペ、医師');
insert into iconlist values('1011','1011_医事課','医事課','医事課、事務');
insert into iconlist values('1012','1012_放射線技師','放射線技師','放射線技師、放射線科');
insert into iconlist values('1013','1013_療法士','療法士','療法士、リハビリ、理学、言語、作業');
insert into iconlist values('1014','1014_医療事務','医療事務','医療事務、医事課、メディカルクラーク');
insert into iconlist values('1015','1015_看護助手','看護助手','看護助手、ヘルパー');
insert into iconlist values('1016','1016_栄養士・検査技師','栄養士・検査技師','栄養士、検査技師');
