<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- logout -->
				<section id="logout">
					<?php
					//ログアウト後、ログイン画面に遷移
					unset($_SESSION['userinfo']);
					header("location: login-input.php");
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
