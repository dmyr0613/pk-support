<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- inquiryRegMain -->
				<section id="inquiryRegMain">
					<?php
					try{

						//最初にユーザ情報を取得
						$user_id=$kind=$facility_code=$facility_name=$password=$email=$department=$person='';
						if (isset($_SESSION['userinfo'])) {
							$user_id=$_SESSION['userinfo']['user_id'];
							$kind=$_SESSION['userinfo']['kind'];
							$facility_code=$_SESSION['userinfo']['facility_code'];
							$facility_name=$_SESSION['userinfo']['facility_name'];
							$password=$_SESSION['userinfo']['password'];
							$email=$_SESSION['userinfo']['email'];
							$department=$_SESSION['userinfo']['department'];
							$person=$_SESSION['userinfo']['person'];
						}

						//現在時刻を取得
						date_default_timezone_set('Asia/Tokyo');
						// $datetime = date("Y/m/d His");
						$datetime = date("Y-m-d H:i:s");	//mySQL時は時刻フォーマットを指定する
						error_log("DateTime：" . $datetime);

						if (isset($_SESSION['inquiry'])) {
							// お問合せセッション情報がある場合は、inquiryテーブルをUPDATE
							$sql=$pdo->prepare('update inquiry set priority_flg=?, update_datetime=?, order_kind=?, contents=?, kanja_id=?, sbs_comment=? where inquiry_no=?');
							$sql->execute([
								0,
								$datetime,
								$_REQUEST['order_kind'],
								$_REQUEST['contents'],
								$_REQUEST['kanja_id'],
								$_REQUEST['sbs_comment'],
								$_SESSION['inquiry']['inquiry_no']]);

								// お問合せセッション情報を更新
								$_SESSION['inquiry']=[
									//inquiryセッションは、クリアされるため再設定
									'inquiry_no'=>$_SESSION['inquiry']['inquiry_no'],
									'insert_datetime'=>$_SESSION['inquiry']['insert_datetime'],
									'update_datetime'=>$datetime,
									'user_id'=>$_SESSION['inquiry']['user_id'],
									'facility_code'=>$_SESSION['inquiry']['facility_code'],
									'facility_name'=>$_SESSION['inquiry']['facility_name'],
									'email'=>$_SESSION['inquiry']['email'],
									'department'=>$_SESSION['inquiry']['department'],
									'person'=>$_SESSION['inquiry']['person'],
									'priority_flg'=>$_SESSION['inquiry']['priority_flg'],
									//入力内容で更新
									'order_kind'=>$_REQUEST['order_kind'],
									'contents'=>$_REQUEST['contents'],
									'kanja_id'=>$_REQUEST['kanja_id'],
									'sbs_comment'=>$_REQUEST['sbs_comment']];

							if ($_SESSION['userinfo']['kind'] == 0) {
								//SBS管理者
								echo '<p>SBS回答情報を更新しました。<br>';
								echo 'サポートセンターよりメールにて回答をお送りしました。</p>';
							} else {
								//ユーザ
								echo '<p>お問合せ情報を更新しました。<br>';
								echo 'サポートセンターからの回答をお待ちください。</p>';
							}

						} else {
							// 新規お問合せ登録
							// $sql=$pdo->prepare('insert into inquiry (inquiry_no,condition_flg,insert_datetime,update_datetime,step_flg,user_id,facility_code,facility_name,priority_flg,order_kind,contents,kanja_id,sbs_comment) values(nextval(\'inquiry_seq\'),?,?,?,?,?,?,?,?,?,?,?,?)');
							$sql=$pdo->prepare('insert into inquiry (condition_flg,insert_datetime,update_datetime,step_flg,user_id,facility_code,facility_name,email,department,person,priority_flg,order_kind,contents,kanja_id,sbs_comment) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
							$sql->execute([
								0,
								$datetime,
								$datetime,
								0,
								$user_id,
								$facility_code,
								$facility_name,
								$email,
								$department,
								$person,
								0,
								$_REQUEST['order_kind'],
								$_REQUEST['contents'],
								$_REQUEST['kanja_id'],
								$_REQUEST['sbs_comment']]);

							// 今登録したinquiry_noを取得
							$inquiry_no=0;
							// $sql=$pdo->prepare('select currval(\'inquiry_seq\')');
							// $sql->execute();
							// foreach ($sql as $row) {
							// 	$inquiry_no=$row['currval'];
							// }
							//今登録したinquiry_noを取得（mySQL時はSEQが利用できない）
							$sql=$pdo->prepare('select last_insert_id() FROM inquiry');
							$sql->execute();
							foreach ($sql as $row) {
								$inquiry_no=$row['last_insert_id()'];
							}

							// お問合せセッション情報を更新
							$_SESSION['inquiry']=[
								'inquiry_no'=>$inquiry_no,
								'insert_datetime'=>$datetime,
								'update_datetime'=>$datetime,
								'user_id'=>$user_id,
								'facility_code'=>$facility_code,
								'facility_name'=>$facility_name,
								'email'=>$email,
								'department'=>$department,
								'person'=>$person,
								'priority_flg'=>0,
								'order_kind'=>$_REQUEST['order_kind'],
								'contents'=>$_REQUEST['contents'],
								'kanja_id'=>$_REQUEST['kanja_id'],
								'sbs_comment'=>$_REQUEST['sbs_comment']];

							echo '<p>お問合せ情報を登録しました。<br>';
							echo 'サポートセンターからの回答をお待ちください。</p>';
						}
						echo '<ul class="actions">';
						echo '<li><a href="inquiry.php" class="button big">お問合せフォームに戻る</a></li>';
						echo '<li><a href="status-list.php" class="button big">問合せ状況一覧</a></li>';
						echo '<li><a href="main.php" class="button big">ホーム</a></li>';
						echo '</ul>';

						// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
						// メール送信処理
						// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
						mb_language("Japanese");
				    mb_internal_encoding("UTF-8");

						// KIND:0=SBS管理者、1=病院、2=パートナー企業
						if ($kind==0) {
							//管理者の場合はユーザへメールを返す
							$to = $_SESSION['inquiry']['email'];
						} else {
							//ユーザの場合はPKSupportセンターへメール
							$to = "d_ota@sbs-infosys.co.jp";
						}

						$title  = "【PKSupput】お問合せ番号：" . $_SESSION['inquiry']['inquiry_no'];
						$title .= "　" . $facility_name . "様";

				    $message  = "";
						$message .= "【質問者】" . "\n" . "施設名：" . $_SESSION['inquiry']['facility_name'] . "\n部署名：" . $_SESSION['inquiry']['department'] . "\n担当者：" . $_SESSION['inquiry']['person'] . "様\n\n";
						if (!empty($_SESSION['inquiry']['order_kind'])) { $message .= "【オーダ種】" . "\n" . $_SESSION['inquiry']['order_kind'] . "\n\n"; }
						if (!empty($_SESSION['inquiry']['contents'])) { $message .= "【事象・内容】" . "\n" . $_SESSION['inquiry']['contents'] . "\n\n"; }
						if (!empty($_SESSION['inquiry']['kanja_id'])) { $message .= "【患者ID】" . "\n" . $_SESSION['inquiry']['kanja_id'] . "\n\n"; }

						if ($kind==0 && !empty($_SESSION['inquiry']['sbs_comment'])) {
							//SBS管理者の場合はSBS回答を追加
							$message .= "【SBS回答】" . "\n" . $_SESSION['inquiry']['sbs_comment'] . "\n\n";
						}

						if ($kind==0) {
							//SBSからユーザにメールを返す場合は、署名と結合する
							$hsign  = "お世話になっております、ＳＢＳ情報システム PrimeKarteサポートチームです。\n";
							$hsign .= "平素は弊社PrimeKarteをご利用いただき、誠にありがとうございます。\n\n";

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

							$message = $hsign . $message . $fsign;
						}

						$headers = "From: " . $email;
						// $headers = "From: PrimeKarte Supput Center";

				    if(mb_send_mail($to, $title, $message, $headers))
				    {
				      // echo "メール送信成功です";
				    }
						// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
						// メール送信処理
						// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

					}catch (PDOException $e){
						print('Error:'.$e->getMessage());
						die();
					}

					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
