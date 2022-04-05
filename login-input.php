<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- loginpage -->
				<section id="loginpage">
					<form action="login-output.php" method="post">
					診察券番号<input type="text" name="kanja_id"><br>
					パスワード<input type="password" name="password"><br>
					<input type="submit" value="LOGIN">
					</form>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
