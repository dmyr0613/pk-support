<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- defaultpage -->
				<section id="defaultpage">

					<form method="post" action="./file-check.php" enctype="multipart/form-data">
					 <input type="file" name="input_file" value="">
					 <input type="submit" value="確認画面へ">
					</form>

				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
