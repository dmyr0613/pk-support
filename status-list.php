<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- statusListMain -->
				<section id="statusListMain">

					<div class="table-wrapper">

						<!-- 一覧条件部 -->
						<?php
						if (!empty($_REQUEST)) {
							$obj = $_REQUEST;
							error_log(print_r($obj, true));
						}

						$step_flg = "";
						// if ($_SERVER["REQUEST_METHOD"] === "POST") {
						if (!empty($_REQUEST)) {
						  if (!empty($_POST["step_flg"])) {
						    $step_flg = $_POST["step_flg"];
							}
						}
						?>

						<form action="status-list.php" method="post">
							<div class="col-6 col-12-small">
								<?php
								if ($step_flg == "on") {
									echo '<input type="checkbox" id="step_flg" name="step_flg" checked>';
								} else {
									echo '<input type="checkbox" id="step_flg" name="step_flg" >';
								}
								?>
								<label for="step_flg">継続中のみ</label>
							</div>
							<p>
								<?php
								//現在時刻を取得
								date_default_timezone_set('Asia/Tokyo');
								error_log("from_date : " . date("Y-m-d", strtotime("YYYY-mm-dd -1 month")));
								error_log("to_date : " . date("Y-m-d"));
								echo date("Y-m-d", strtotime("2021-09-30 -1 day")); //2021-09-29

								echo '<input type="date" name="from_date" value="', date("Y-m-d", strtotime("YYYY-mm-dd -1 month")) ,'">';
								echo ' 〜 ';
								echo '<input type="date" name="to_date" value="', date("Y-m-d") ,'">';
								?>
							</p>
							<input type="submit" value="再検索">
						</form>

						<form action="status-list-output.php" method="post">
						<table class="alt">
							<?php
								if (isset($_SESSION['userinfo']) == false){
									//ログイン情報がなければ、トップページに遷移
									header("location: main.php");
								}

								//タイトル
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
								// echo '		<th>ステータス</th>';
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
									$sql=$pdo->prepare('select * from inquiry where facility_code=? and condition_flg=0 order by inquiry_no');
									$sql->execute([$_SESSION['userinfo']['facility_code']]);
								}

								foreach ($sql as $row) {

									// 行クリックで詳細表示
									echo '<tr data-href="status-list-output.php?inquiry_no=',$row['inquiry_no'],'">';
									// echo '	<td width= "50">　</td>';
									// echo '  <td width= "100"><input type="submit" class="button small fit" name="inquiry_no" value="', $row['inquiry_no'], '"></td>';
									echo '	<td>', $row['inquiry_no'], '</td>';
									if ($_SESSION['userinfo']['kind'] == 0) {
										//SBS管理者は施設名を表示
										echo '	<td>', $row['facility_name'], '</td>';
									}
									echo '	<td>', $row['contents'], '</td>';
									echo '	<td>', $row['sbs_comment'], '</td>';
									// echo '	<td>　</td>';
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
		 //行クリックでページ遷移できるスクリプト
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
