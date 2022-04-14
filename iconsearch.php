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
						<!-- <input type="text" name="keyword" placeholder="Search"/><br> -->
						検索ワード<input type="text" name="key_word"><br>
						<p><input type="submit" value="アイコン検索"></p>
					</form>

				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
