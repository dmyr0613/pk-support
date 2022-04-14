<?php session_start(); ?>
<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- iconlist -->
				<section id="iconlist">

					<table class="alt">
						<tbody>

						<?php
						  error_log('select * from iconlist where keyword like \'%?%\' order by code');
							error_log([$_REQUEST['search']]);

							//アイコン検索
							$sql=$pdo->prepare('select * from iconlist where keyword like \'%?%\' order by code');
							$sql->execute([$_REQUEST['search']]);

							foreach ($sql as $row) {

								echo '<tr>';
								echo '	<td><p><img src="icon/' , $row['icon_name'] , '.png" alt="' , $row['icon_name'] , '"></p></td>';
								echo '</tr>';
							}
						?>

						</tbody>
					</table>

				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
