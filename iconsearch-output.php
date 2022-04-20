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
							<p>アイコン素材は全てフリーで商用利用可能です。<br>
							右クリックメニューの「名前を付けて画像を保存...」からダウンロードしてください。</p>
						<?php

							echo '<h2 id="content">「' , $_POST['search'], '」の検索結果です。</h2>';

							//アイコン検索
							$sqltxt  = 'select * from iconlist where keyword like \'%';
							$sqltxt .= $_POST['search'];
							$sqltxt .= '%\' order by code';
							$sql = $pdo->prepare($sqltxt);
							$sql->execute();

							foreach ($sql as $row) {
								//検索結果を表示
								echo '<tr>';
								// echo '	<td><img src="icon/512w/' , $row['icon_name'] , '.png" width="150">　', $row['disp_name'], '</td>';
								echo '	<td><img src="https://pk-support.herokuapp.com/icon/512w/' , $row['icon_name'] , '.png" width="150">　', $row['disp_name'], '</td>';
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
