<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- loginpage -->
				<section id="loginpage">
					<form action="login-output.php" method="post">
					ユーザID<input type="text" name="user_id"><br>
					パスワード<input type="password" name="password"><br>
					<input type="submit" value="ログイン">
					</form>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
