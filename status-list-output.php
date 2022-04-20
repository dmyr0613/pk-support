<?php session_start(); ?>
<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- loginpage -->
				<section id="loginpage">
					<?php
					///お問合せ情報セッションをクリア
					unset($_SESSION['inquiry']);

					//お問合せ情報をセッションに設定
					$sql=$pdo->prepare('select * from inquiry where inquiry_no=?');
					$sql->execute([$_REQUEST['inquiry_no']]);
					foreach ($sql as $row) {
						$_SESSION['inquiry']=[
							'user_id'=>$row['user_id'],
							'insert_datetime'=>$row['insert_datetime'],
							'update_datetime'=>$row['update_datetime'],
							'inquiry_no'=>$row['inquiry_no'],
							'user_id'=>$row['user_id'],
							'facility_code'=>$row['facility_code'],
							'facility_name'=>$row['facility_name'],
							'email'=>$row['email'],
							'department'=>$row['department'],
							'person'=>$row['person'],
							'priority_flg'=>$row['priority_flg'],
							'order_kind'=>$row['order_kind'],
							'contents'=>$row['contents'],
							'kanja_id'=>$row['kanja_id'],
							'sbs_comment'=>$row['sbs_comment']];
					}
					if (isset($_SESSION['inquiry'])) {
						//お問合せページに遷移
						header("location: inquiry.php");
					}
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
