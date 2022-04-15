<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- statusListMain -->
				<section id="statusListMain">

					<div class="table-wrapper">
						<form action="status-list-output.php" method="post">
						<table class="alt">
							<?php
								if (isset($_SESSION['userinfo']) == false){
									//ログイン情報がなければ、トップページに遷移
									header("location: main.php");
								}

								echo '<thead>';
								echo '	<tr>';
								// echo '		<th>更新</th>';
								echo '		<th>お問合せ番号</th>';
								if ($_SESSION['userinfo']['kind'] == 0) {
									//SBS管理者は施設名を表示
									echo '		<th>施設名</th>';
								}
								echo '		<th>事象・内容</th>';
								echo '		<th>SBS回答</th>';
								echo '		<th>ステータス</th>';
								echo '	</tr>';
								echo '</thead>';
								echo '<tbody>';

								//お問合せ情報セッションをクリア
								unset($_SESSION['inquiry']);

								if ($_SESSION['userinfo']['kind'] == 0) {
									//SBS管理者は有効データ全て検索
									$sql=$pdo->prepare('select * from inquiry order by inquiry_no');
									$sql->execute();
								} else {
									//ログイン者と同じ病院コードの問合せを検索（継続中のみ）
									$sql=$pdo->prepare('select * from inquiry where facility_code=? order by inquiry_no');
									$sql->execute([$_SESSION['userinfo']['facility_code']]);
								}

								foreach ($sql as $row) {

									// echo '<tr>';
									echo '<tr data-href="inquiry.php?inquiry_no='", $row['inquiry_no'], '"'>';
									// echo '	<td width= "50">　</td>';
									echo '  <td width= "100"><input type="submit" class="button small fit" name="inquiry_no" value="', $row['inquiry_no'], '"></td>';
									if ($_SESSION['userinfo']['kind'] == 0) {
										//SBS管理者は施設名を表示
										echo '	<td>', $row['facility_name'], '</td>';
									}
									echo '	<td>', $row['contents'], '</td>';
									echo '	<td>', $row['sbs_comment'], '</td>';
									echo '	<td>　</td>';
									echo '</tr>';

								}
							?>

							</tbody>
							<tfoot>
								<!-- <tr>
									<td colspan="2"></td>
									<td>100.00</td>
								</tr> -->
							</tfoot>
						</table>
						</form>
					</div>
				</section>

			</div>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script>
			jQuery(function($) {

			  //data-hrefの属性を持つtrを選択しclassにclickableを付加
			  $('tr[data-href]').addClass('clickable')

			    //クリックイベント
			    .click(function(e) {
			      //e.targetはクリックした要素自体、それがa要素以外であれば
			      if(!$(e.target).is('a')){

			        //その要素の先祖要素で一番近いtrの
			        //data-href属性の値に書かれているURLに遷移する
			        window.location = $(e.target).closest('tr').data('href');}
			  });
			});
		</script>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
