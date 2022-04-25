<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- statusListMain -->
				<section id="statusListMain">

					<div class="table-wrapper">

						<?php
							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
							// 表示条件テーブル
							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

							//ログイン情報がなければ、トップページに遷移
							if (isset($_SESSION['userinfo']) == false){
								header("location: main.php");
							}

							//現在時刻を取得
							date_default_timezone_set('Asia/Tokyo');
							$from_date = date('Y-m-d', strtotime('last month'));
							$to_date = date("Y-m-d");

							//検索条件をセット
							$search_kind=$keyword=$facility_code="";
							if (!empty($_REQUEST)) {
								// $obj = $_REQUEST;
								// echo print_r($obj, true);
								// echo '検索条件を画面で指定';

								$facility_code = $_REQUEST['facility_code'];
								$search_kind = $_REQUEST['search_kind'];
								$from_date = $_REQUEST['from_date'];
								$to_date = $_REQUEST['to_date'];
								$keyword = $_REQUEST['keyword'];

								//検索条件セッションにもセット
								$_SESSION['searchpara']=[
									'facility_code'=>$facility_code,
									'search_kind'=>$search_kind,
									'from_date'=>$from_date,
									'to_date'=>$to_date,
									'keyword'=>$keyword];

							} elseif (!empty($_SESSION['searchpara'])) {
								//検索条件セッションにデータがあえばセット
								// echo '検索条件はセッションで指定';
								$facility_code = $_SESSION['searchpara']['facility_code'];
								$search_kind = $_SESSION['searchpara']['search_kind'];
								$from_date = $_SESSION['searchpara']['from_date'];
								$to_date = $_SESSION['searchpara']['to_date'];
								$keyword = $_SESSION['searchpara']['keyword'];
							}
							// echo print_r($_REQUEST, true);
							// echo $facility_code;

							// 再検索は自分自身にPOSTする
							echo '<form action="status-list.php" method="post">';
								//ヘッダー部
								echo '<table>';
								echo '<thead>';
								echo '	<tr>';
								echo '		<th>検索条件</th>';
								echo '	</tr>';
								echo '</thead>';
								echo '<tbody>';

								if ($_SESSION['userinfo']['kind'] == 0) {
									//SBS管理者は検索条件に施設名を表示
									echo '<tr><td>';
									echo '施設名';
									echo '</td><td>';
									echo '<div class="col-12">';
									echo '	<select name="facility_code" id="facility_code">';
									echo '		<option value="">全て</option>';

									$sqltxt = 'select facility_code,facility_name from userinfo group by facility_code,facility_name having facility_code <> "C000" order by facility_code';
									$sql=$pdo->prepare($sqltxt);
									$sql->execute();
									foreach ($sql as $row) {
										echo '<option value="', $row['facility_code'] ,'"';
										if ($row['facility_code'] == $facility_code) {
											echo ' selected';
										}
										echo '>', $row['facility_name'] ,'</option>';
									}
									echo '	</select>';
									echo '</div>';
									echo '</td></tr>';
								} else {
									//facility_codeをPOSTする必要があるため、hidden表示
									echo '<input type="hidden" id="facility_code" name="facility_code" value="">';
								}

								//ステータス
								echo '<tr><td width="150">';	//タイトル幅指定
								echo '	<input type="radio" id="search_kind0" name="search_kind" value="0" ';
								if ($search_kind==0) { echo 'checked>'; } else { echo '>'; };
								echo '	<label for="search_kind0">継続中のみ</label>';
								echo '</td><td>';
								echo '</td></tr>';
								//検索期間
								echo '<tr><td>';
								echo '	<input type="radio" id="search_kind1" name="search_kind" value="1" ';
								if ($search_kind==1) { echo 'checked>'; } else { echo '>'; };
								echo '	<label for="search_kind1">検索期間</label>';
								echo '</td><td>';
								echo '	<input type="date" name="from_date" value="', $from_date ,'">';
								echo ' 〜 ';
								echo '	<input type="date" name="to_date" value="', $to_date ,'">';
								echo '</td></tr>';
								//キーワード
								echo '<tr><td>';
								echo '	<input type="radio" id="search_kind2" name="search_kind" value="2" ';
								if ($search_kind==2) { echo 'checked>'; } else { echo '>'; };
								echo '	<label for="search_kind2">検索ワード</label>';
								echo '</td><td>';
								echo '	<input type="text" name="keyword" value="', $keyword, '">';
								echo '</td></tr>';
								// 検索ボタン
								echo '<tr><td>';
								echo '</td><td align="right">';
								echo '<input type="submit" value="再検索">';
								echo '</td></tr>';

								echo '</tbody>';
								echo '</table>';

							echo '</form>';
							// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
							// 表示条件テーブル
							// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
							// 問合せ一覧テーブル
							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
							echo '<form action="status-list-output.php" method="post">';
							echo '<table class="alt">';
								//ヘッダー部
								echo '<thead>';
								echo '	<tr>';
								echo '		<th>お問合せ番号</th>';
								echo '		<th>更新日</th>';
								if ($_SESSION['userinfo']['kind'] == 0) {
									//SBS管理者は施設名を表示
									echo '		<th>施設名</th>';
								}
								echo '		<th>オーダ種</th>';
								echo '		<th>事象・内容</th>';
								echo '		<th>SBS回答</th>';
								// echo '		<th>ステータス</th>';
								echo '	</tr>';
								echo '</thead>';
								echo '<tbody>';

								//お問合せ情報セッションをクリア
								unset($_SESSION['inquiry']);

								$sqltxt ="";
								$sqltxt = 'select * from inquiry where condition_flg = 0 ';

								if ($facility_code!="") {
									//SBS管理者で施設名を指定した場合
									$sqltxt .= ' and facility_code = "' . $facility_code . '"';
								}

								switch ($search_kind) {
									case 0;
										//継続中のみ
										$sqltxt .= ' and step_flg = 0';
										break;
									case 1:
										//検索期間指定
										$sqltxt .= ' and update_datetime >= "' . $from_date . '"';
										$sqltxt .= ' and update_datetime <= "' . $to_date . ' 23:59:59"';
										break;
									case 2;
										//検索ワード
										$sqltxt .= ' and (contents    like "%' . $keyword . '%" ';
										$sqltxt .= '  or  sbs_comment like "%' . $keyword . '%" ';
										$sqltxt .= '  or  order_kind  like "%' . $keyword . '%")';
										break;
								}

								if ($_SESSION['userinfo']['kind'] != 0) {
									//SBS以外はログイン者と同じ病院コードの問合せを検索（SBS管理者は有効データ全て検索）
									$sqltxt .= ' and facility_code = "' . $_SESSION['userinfo']['facility_code'] . '"';
								}
								$sqltxt .= ' order by inquiry_no';


								//inquiry_listセッションをクリア
								unset($_SESSION['inquiry_list']);
								$cnt=1;

								//検索SQL実行
								echo $sqltxt;
								$sql=$pdo->prepare($sqltxt);
								$sql->execute();
								foreach ($sql as $row) {

									//inquiry_list配列に全て設定する
									$_SESSION['inquiry_list'][$cnt]=[
										'user_id'=>$row['user_id'],
										'insert_datetime'=>$row['insert_datetime'],
										'update_datetime'=>$row['update_datetime'],
										'inquiry_no'=>$row['inquiry_no'],
										'user_id'=>$row['user_id'],
										'facility_code'=>$row['facility_code'],
										'facility_name'=>$row['facility_name'],
										'email'=>$row['email'],
										'department'=>$row['department'],
										'person'=>$row['person'],
										'priority_flg'=>$row['priority_flg'],
										'order_kind'=>$row['order_kind'],
										'contents'=>$row['contents'],
										'kanja_id'=>$row['kanja_id'],
										'sbs_comment'=>$row['sbs_comment'],
										'file_name'=>$row['file_name']];
										$cnt++;
								}

								//問合せ一覧テーブル描画
								$maxcnt=$cnt;
								for ($cnt=1; $cnt<$maxcnt; $cnt++) {
									// 行クリックで詳細表示
									// echo '<tr data-href="status-list-output.php?index=',$cnt,'">';
									echo '<tr data-href="inquiry.php?index=',$cnt,'">';
								echo '	<td width="100">', $_SESSION['inquiry_list'][$cnt]['inquiry_no'];
									if ($_SESSION['inquiry_list'][$cnt]['update_datetime'] >= date('Y-m-d', strtotime("-1 day"))) {
										//更新日が3日前であれば、NEWアイコンを表示
										echo ' <img src="images/new.gif" height="20">';
									}
									echo '</td>';
									echo '	<td width="150">', date('Y年m月d日', strtotime($_SESSION['inquiry_list'][$cnt]['update_datetime'])), '</td>';
									if ($_SESSION['userinfo']['kind'] == 0) {
										//SBS管理者は施設名を表示
										echo '	<td>', $_SESSION['inquiry_list'][$cnt]['facility_name'], '</td>';
									}
									echo '	<td>', $_SESSION['inquiry_list'][$cnt]['order_kind'], '</td>';
									echo '	<td>', $_SESSION['inquiry_list'][$cnt]['contents'], '</td>';
									echo '	<td>', $_SESSION['inquiry_list'][$cnt]['sbs_comment'], '</td>';
									echo '</tr>';
								}
								// echo '<br>';
								// echo print_r($_SESSION['inquiry_list'], true);

								echo '</tbody>';
							echo '</table>';
							echo '</form>';
							// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
							// 問合せ一覧テーブル
							// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
						?>

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
