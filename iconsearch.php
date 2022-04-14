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

						<div class="col-4 col-12-small">
							アイコンサイズ
							<input type="radio" id="priority-normal" name="priority" checked>
							<label for="priority-normal">256px</label>
							<input type="radio" id="priority-high" name="priority">
							<label for="priority-high">512px</label>
						</div>
											<!-- <input type="text" name="keyword" placeholder="Search"/><br> -->
						検索ワード<input type="text" name="search"><br>
						<p><input type="submit" value="アイコン検索"></p>
					</form>

				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
