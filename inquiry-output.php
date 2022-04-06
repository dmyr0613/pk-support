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
						$user_id=$facility_code=$facility_name=$password=$email=$department=$person='';
						if (isset($_SESSION['userinfo'])) {
							$user_id=$_SESSION['userinfo']['user_id'];
							$facility_code=$_SESSION['userinfo']['facility_code'];
							$facility_name=$_SESSION['userinfo']['facility_name'];
							$password=$_SESSION['userinfo']['password'];
							$email=$_SESSION['userinfo']['email'];
							$department=$_SESSION['userinfo']['department'];
							$person=$_SESSION['userinfo']['person'];
						}


						// if (isset($_SESSION['userinfo'])) {
						//
						// 	// ログイン中であれば、userinfoテーブルをUPDATE。
						// 	$sql=$pdo->prepare('update userinfo set name=?, password=?, email=?, department=?, person=? where user_id=?');
						// 	$sql->execute([
						// 		$_REQUEST['name'],
						// 		$_REQUEST['password'],
						// 		$_REQUEST['email'],
						// 		$_REQUEST['department'],
						// 		$_REQUEST['person'],
						// 		$_SESSION['userinfo']['user_id']]);
						//
						// 	$_SESSION['userinfo']=[
						// 		'user_id'=>$_SESSION['userinfo']['user_id'],
						// 		'name'=>$_REQUEST['name'],
						// 		'password'=>$_REQUEST['password'],
						// 		'email'=>$_REQUEST['email'],
						// 		'department'=>$_REQUEST['department'],
						// 		'person'=>$_REQUEST['person']];
						//
						// 	echo '<p>ユーザ情報を更新しました。</p>';
						// 	echo '<ul class="actions">';
						// 	echo '<li><a href="main.php" class="button big">ホーム</a></li>';
						// 	echo '</ul>';
						//
						// } else {
							// 新規ユーザ登録
							$sql=$pdo->prepare('insert into inquiry (inquiry_no,user_id,facility_code,facility_name,priority_flg,order_kind,contents,kanja_id,sbs_comment) values(nextval(\'inquiry_seq\'),?,?,?,?,?,?,?,?)');
							$sql->execute([
								$user_id,
								$facility_code,
								$facility_name,
								0,
								$_REQUEST['order_kind'],
								$_REQUEST['contents'],
								$_REQUEST['kanja_id'],
								$_REQUEST['sbs_comment']]);

							// お問合せセッション情報を更新
							$_SESSION['inquiry']=[
								'inquiry_no'=>'新規番号',
								'user_id'=>$user_id,
								'facility_code'=>$facility_code,
								'facility_name'=>$facility_name,
								'priority_flg'=>0
								'order_kind'=>$_REQUEST['order_kind'],
								'contents'=>$_REQUEST['contents'],
								'kanja_id'=>$_REQUEST['kanja_id'],
								'sbs_comment'=>$_REQUEST['sbs_comment']];

							echo '<p>お問合せ情報を登録しました。<br>';
							echo 'サポートセンターからの回答をお待ちください。</p>';
							echo '<ul class="actions">';
							echo '<li><a href="inquiry.php" class="button big">お問合せフォームに戻る</a></li>';
							echo '<li><a href="main.php" class="button big">ホーム</a></li>';
							echo '</ul>';
						// }
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
