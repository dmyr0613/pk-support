drop database if exists pksupport;
create database pksupport default character set utf8 collate utf8_general_ci;
grant all on pksupport.* to 'sbs'@'localhost' identified by 'sbs_toro';
use pksupport;

-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-- ユーザテーブル
-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
drop table userinfo;
create table userinfo (
  user_id varchar(15) not null unique,
  kind int,
	facility_code varchar(15) not null,
  facility_name varchar(100) not null,
	password varchar(15) not null,
  email varchar(30),
  department varchar(100),
  person varchar(50)
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

drop table facility;
create table facility (
	facility_code varchar(15) not null unique,
  facility_name varchar(100) not null,
	asana_gid varchar(15)
);

-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-- 問合せ情報テーブル
-- /Volumes/sec2/PrimeKarteサポートセンター/資料/20170906 ユーザ向け案内文/案内文オリジナル/【PrimeKarteサポートセンター向けフォーマット】.txt
-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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
  person varchar(50),
  facility_code_02 varchar(15),
  facility_name_02 varchar(100),
  priority_flg int,
  inquiry_title varchar(100),
  inquiry_kind int,
	order_kind varchar(100),
	contents varchar(1000),
  kanja_id varchar(15),
  file_name varchar(100),
  hakkou_datetime timestamp,
  order_no int,
  rep_flg int,
  rep_process varchar(1000),
  hassei_datetime timestamp,
  pc_name varchar(50),
  end_user_id varchar(15),
  log_file_name varchar(100),
  contents_02 varchar(1000),
  contents_03 varchar(1000),
  sbs_comment varchar(1000),
  doc_file_name varchar(100),
  asana_gid varchar(30)
);

--ON UPDATE CURRENT_TIMESTAMP属性が付いてしまったら、下記SQLで設定を外す
alter table inquiry modify insert_datetime timestamp default '0000-00-00 00:00:00';

--シーケンス（mySql時は利用せず）
CREATE SEQUENCE inquiry_seq;
--シーケンスの現在値取得（currvalは同じセッションにおいて、nextvalの値を戻すため、last_valueであれば最大値となる）
select currval('inquiry_seq');
SELECT last_value FROM inquiry_seq;
--シーケンスの現在値取得（mySQL）
SELECT last_insert_id(inquiry_no) FROM inquiry;
--PostgreSQL
insert into inquiry (inquiry_no) values(nextval('inquiry_seq'));

--mySQL
insert into inquiry (
  condition_flg,
  insert_datetime,
  update_datetime,
  step_flg,
  user_id,
  facility_code,
  facility_name,
  email,
  department,
  person,
  facility_code_02,
  facility_name_02,
  priority_flg,
  inquiry_title,
  inquiry_kind,
  order_kind,
  contents,
  kanja_id,
  file_name,
  hakkou_datetime,
  order_no,
  rep_flg,
  rep_process,
  hassei_datetime,
  pc_name,
  end_user_id,
  log_file_name,
  contents_02,
  contents_03,
  sbs_comment,
  doc_file_name,
  asana_gid
) values (
  0,
  CURRENT_TIMESTAMP,
  CURRENT_TIMESTAMP,
  0,
  '001',
  'H001',
  'SBS総合病院',
  'd_ota@sbs-infosys.co.jp',
  '情報室',
  '大空 翼',
  null,
  null,
  0,
  'テストデータについて',
  0,
	'テストオーダ種',
	'テスト質問',
  '1234567',
  null,
  '2022/03/01',
  null,
  0,
  null,
  '2022/03/01',
  'DT001',
  null,
  null,
  'テスト再現手順',
  'テストその他',
  'テストSBS回答',
  null,
  null);

-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-- 通知情報テーブル
-- /Volumes/sec2/PrimeKarteサポートセンター/資料/20200624 ML(PK-Info、Pk-Info-partner)/ぷらさぽ通信送付資料/案内文
-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
--KIND:0=共通、1=病院様向け、2=パートナー様向け
--STR_01対象機能 02適用対象病院 03対応内容 04更新内容 05運用・適用について 06その他 07本件のお問い合わせについて
drop table pkinfo;
create table pkinfo (
  pkinfo_no int Primary Key AUTO_INCREMENT,
  condition_flg int,
  insert_datetime timestamp,
  update_datetime timestamp,
  kind int,
  info_title varchar(1000),
  contents varchar(1000),
  str_01 varchar(1000),
  str_02 varchar(1000),
  str_03 varchar(1000),
  str_04 varchar(1000),
  str_05 varchar(1000),
  str_06 varchar(1000),
  str_07 varchar(1000),
  str_08 varchar(1000),
  str_09 varchar(1000),
  str_10 varchar(1000),
  file_name varchar(100)
);

--ON UPDATE CURRENT_TIMESTAMP属性が付いてしまったら、下記SQLで設定を外す
alter table pkinfo modify insert_datetime timestamp default '0000-00-00 00:00:00';

insert into pkinfo
  (condition_flg,insert_datetime,update_datetime,kind,info_title,contents,str_01,str_02,str_03,str_04,str_05,str_06,str_07,str_08,str_09,str_10,file_name)
  values(0,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,1,'SBS情報システムからのお知らせ','診療報酬改定におけるPrimeKarteの対応スケジュールについてご案内します。','','','','','','','','','','','');
insert into pkinfo
  (condition_flg,insert_datetime,update_datetime,kind,info_title,contents,str_01,str_02,str_03,str_04,str_05,str_06,str_07,str_08,str_09,str_10,file_name)
  values(0,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,2,'XXオーダでXX時にエラーが発生する','',
    'XXオーダ','XXオーダご利用のお客様','XX現象があるため、XXいたします。','SBS作業中です。','SBS作業中です。','現在、弊社にて対応プログラムの準備を進めています。',
    '対応準備が整い次第、再度ご連絡致します','下記メールアドレスまでメールにてお問い合わせください。','','','');

-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-- アイコンテーブル
-- >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
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
