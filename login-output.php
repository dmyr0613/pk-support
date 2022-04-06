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
					unset($_SESSION['userinfo']);

					$sql=$pdo->prepare('select * from userinfo where user_id=? and password=?');
					$sql->execute([$_REQUEST['user_id'], $_REQUEST['password']]);
					foreach ($sql as $row) {
						$_SESSION['userinfo']=[
							'user_id'=>$row['user_id'],
							'facility_code'=>$row['facility_code'],
							'facility_name'=>$row['facility_name'],
							'password'=>$row['password'],
							'email'=>$row['email'],
							'department'=>$row['department'],
							'person'=>$row['person']];
					}
					if (isset($_SESSION['userinfo'])) {
						echo '<p>ようこそ、', $_SESSION['userinfo']['facility_name'], '様</p>';
						echo '<ul class="actions">';
						echo '<li><a href="main.php" class="button big">ホーム</a></li>';
						echo '</ul>';
						header("location: main.php");
					} else {
						echo '<p>ログイン名またはパスワードが違います。</p>';
						echo '<ul class="actions">';
						echo '<li><a href="login-input.php" class="button big">戻る</a></li>';
						echo '</ul>';
					}
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
