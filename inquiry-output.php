<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- inquiryRegMain -->
				<section id="inquiryRegMain">
					<?php
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
						$datetime = date("Y/m/d His");
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
									'inquiry_no'=>$_SESSION['inquiry']['inquiry_no'],
									'update_datetime'=>$datetime,
									'user_id'=>$user_id,							//念のため再設定
									'facility_code'=>$facility_code,	//念のため再設定
									'facility_name'=>$facility_name,	//念のため再設定
									'priority_flg'=>0,
									'order_kind'=>$_REQUEST['order_kind'],
									'contents'=>$_REQUEST['contents'],
									'kanja_id'=>$_REQUEST['kanja_id'],
									'sbs_comment'=>$_REQUEST['sbs_comment']];

							echo '<p>お問合せ情報を更新しました。<br>';
							echo 'サポートセンターからの回答をお待ちください。</p>';

						} else {
							// 新規お問合せ登録
							$sql=$pdo->prepare('insert into inquiry (inquiry_no,insert_datetime,update_datetime,user_id,facility_code,facility_name,priority_flg,order_kind,contents,kanja_id,sbs_comment) values(nextval(\'inquiry_seq\'),?,?,?,?,?,?,?,?,?,?)');
							$sql->execute([
								$datetime,
								$datetime,
								$user_id,
								$facility_code,
								$facility_name,
								0,
								$_REQUEST['order_kind'],
								$_REQUEST['contents'],
								$_REQUEST['kanja_id'],
								$_REQUEST['sbs_comment']]);

							// 今登録したinquiry_noを取得
							$inquiry_no=0;
							$sql=$pdo->prepare('select currval(\'inquiry_seq\')');
							$sql->execute();
							foreach ($sql as $row) {
								$inquiry_no=$row['currval'];
							}

							// お問合せセッション情報を更新
							$_SESSION['inquiry']=[
								'inquiry_no'=>$inquiry_no,
								'insert_datetime'=>$datetime,
								'update_datetime'=>$datetime,
								'user_id'=>$user_id,
								'facility_code'=>$facility_code,
								'facility_name'=>$facility_name,
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
						echo '<li><a href="main.php" class="button big">ホーム</a></li>';
						echo '</ul>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
