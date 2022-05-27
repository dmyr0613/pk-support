<?php

  //Asana定数
  define('ASANA_BASE_TASK', '1202259197104657');    //コピー元となる、SAS調査依頼タスクgid
  define('ASANA_PROJECTS_ID', '1172128163255929');  //【医療】開発A テスト
  define('ASANA_WORKSPACE_ID', '505269877956434');  //ワークスペースID
  define('ASANA_ACCESS_TOKEN', '1/1166806708833131:49f5a1356f45646ae9be47b5adab52ce');

  //サポートセンターメールアドレス
  define('SUPPORT_MAIL_ADDRESS', 'd_ota@sbs-infosys.co.jp');
  
  //メールヘッダー
  $hsign  = "お世話になっております、ＳＢＳ情報システム PrimeKarteサポートチームです。\n";
  $hsign .= "平素は弊社PrimeKarteをご利用いただき、誠にありがとうございます。\n\n";
  define('MAIL_HSIGN', $hsign);
  //メールフッダー
  $fsign  = "\nお忙しいところ申し訳ございませんが、ご確認の程、よろしくお願いいたします。\n";
  $fsign .= "～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～～\n";
  $fsign .= "※システム停止等の緊急時には、電話にてご連絡下さい。\n";
  $fsign .= "※本メールについてのお問い合わせは、下記までお問い合わせください。\n\n";
  $fsign .= "株式会社ＳＢＳ情報システム\n";
  $fsign .= "医療事業本部　Primekarteサポートチーム\n";
  $fsign .= "http://localhost/pk-support/main.php\n";
  $fsign .= "静岡県静岡市駿河区登呂3-1-1\n";
  $fsign .= "　電話　 054-283-1450\n";
  $fsign .= "　ＦＡＸ 054-284-9181\n";
  define('MAIL_FSIGN', $fsign);
  //メールヘッダー
  $hsignUser  = "ＳＢＳ情報システム PrimeKarteサポート様\n";
  $hsignUser .= "PKサポートサイトより新規問合せ\n\n";
  define('MAIL_HSIGN_USER', $hsignUser);


?>
