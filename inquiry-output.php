<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- useiinfoRegMain -->
				<section id="useiinfoRegMain">
					<?php
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
							// $sql=$pdo->prepare('insert into kanja values(null, ?, ?, ?, ?, ?, null, null)');
							$sql=$pdo->prepare('insert into inquiry values(?, ?, ?, ?, ?, null, null, null)');
							$sql->execute([
								$_REQUEST['user_id'],
								$_REQUEST['name'],
								$_REQUEST['password'],
								$_REQUEST['email'],
								$_REQUEST['department'],
								$_REQUEST['person']]);

							//セッション情報を更新
							$_SESSION['userinfo']=[
								'user_id'=>$_REQUEST['user_id'],
								'name'=>$_REQUEST['name'],
								'password'=>$_REQUEST['password'],
								'email'=>$_REQUEST['email'],
								'department'=>$_REQUEST['department'],
								'person'=>$_REQUEST['person']];

								echo '<p>ユーザ情報を登録しました。</p>';
								echo '<ul class="actions">';
								echo '<li><a href="main.php" class="button big">ホーム</a></li>';
								echo '</ul>';
						// }
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
