<!--
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// 未使用
// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-->
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

					//渡されたinquiry_no
					$index = $_REQUEST['index'];
					if (isset($_SESSION['inquiry_list'])) {
						$_SESSION['inquiry']=[
							'user_id'=>$_SESSION['inquiry_list'][$index]['user_id'],
							'insert_datetime'=>$_SESSION['inquiry_list'][$index]['insert_datetime'],
							'update_datetime'=>$_SESSION['inquiry_list'][$index]['update_datetime'],
							'inquiry_no'=>$_SESSION['inquiry_list'][$index]['inquiry_no'],
							'user_id'=>$_SESSION['inquiry_list'][$index]['user_id'],
							'facility_code'=>$_SESSION['inquiry_list'][$index]['facility_code'],
							'facility_name'=>$_SESSION['inquiry_list'][$index]['facility_name'],
							'email'=>$_SESSION['inquiry_list'][$index]['email'],
							'department'=>$_SESSION['inquiry_list'][$index]['department'],
							'person'=>$_SESSION['inquiry_list'][$index]['person'],
							'priority_flg'=>$_SESSION['inquiry_list'][$index]['priority_flg'],
							'order_kind'=>$_SESSION['inquiry_list'][$index]['order_kind'],
							'contents'=>$_SESSION['inquiry_list'][$index]['contents'],
							'kanja_id'=>$_SESSION['inquiry_list'][$index]['kanja_id'],
							'sbs_comment'=>$_SESSION['inquiry_list'][$index]['sbs_comment'],
							'file_name'=>$_SESSION['inquiry_list'][$index]['file_name']];
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
