<?php session_start(); ?>
<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- iconsearch -->
				<section id="iconsearch">

					<form action="iconsearch-output.php" method="post">
						<input type="text" name="keyword" placeholder="Search"/>
						<input type="submit" value="アイコン検索">
					</form>

					<!-- <form action="login-output.php" method="post">
					ユーザID<input type="text" name="user_id"><br>
					パスワード<input type="password" name="password"><br>
					<input type="submit" value="ログイン">
					</form> -->

				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
