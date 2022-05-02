<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- pkinfoMain -->
				<section id="pkinfoMain">
					<?php
					//ログイン情報がなければ、トップページに遷移
					if (isset($_SESSION['userinfo']) == false){
						header("location: main.php");
					}

					$index = -1;
					if (isset($_REQUEST['index'])) {
						$index = $_REQUEST['index'];
					}

					//変数初期化
					$pkinfo_no=$insert_datetime=$update_datetime=$kind=$info_title=$contents=$str_01=$str_02=$str_03=$str_04=$str_05=$str_06=$str_07=$str_08=$str_09=$str_10=$file_name='';
					if ($index>=0){
						//インデックス番号が渡された場合は、pkinfo_list配列よりデータを取得（インデックス番号がない場合は新規登録）
						if (isset($_SESSION['pkinfo_list'])) {
							$pkinfo_no=$_SESSION['pkinfo_list'][$index]['pkinfo_no'];
							$insert_datetime=$_SESSION['pkinfo_list'][$index]['insert_datetime'];
							$update_datetime=$_SESSION['pkinfo_list'][$index]['update_datetime'];
							$kind=$_SESSION['pkinfo_list'][$index]['kind'];
							$info_title=$_SESSION['pkinfo_list'][$index]['info_title'];
							$contents=$_SESSION['pkinfo_list'][$index]['contents'];
							$str_01=$_SESSION['pkinfo_list'][$index]['str_01'];
							$str_02=$_SESSION['pkinfo_list'][$index]['str_02'];
							$str_03=$_SESSION['pkinfo_list'][$index]['str_03'];
							$str_04=$_SESSION['pkinfo_list'][$index]['str_04'];
							$str_05=$_SESSION['pkinfo_list'][$index]['str_05'];
							$str_06=$_SESSION['pkinfo_list'][$index]['str_06'];
							$str_07=$_SESSION['pkinfo_list'][$index]['str_07'];
							$str_08=$_SESSION['pkinfo_list'][$index]['str_08'];
							$str_09=$_SESSION['pkinfo_list'][$index]['str_09'];
							$str_10=$_SESSION['pkinfo_list'][$index]['str_10'];
							$file_name=$_SESSION['pkinfo_list'][$index]['file_name'];
						}
					}

					// ファイル添付のため、enctype="multipart/form-data"を追加
					if ($index>=0) {
						echo '<form action="pkinfo-form-output.php?index=',$index,'" method="post" enctype="multipart/form-data">';
					} else {
						echo '<form action="pkinfo-form-output.php" method="post" enctype="multipart/form-data">';
					}
					echo '<table>';

					echo '<tr><td>通知番号</td><td>';
					echo '', $pkinfo_no, '';
					echo '</td></tr>';

					if ($_SESSION['userinfo']['kind'] == 0) {
						//SBS管理者は区分を表示
						$kind_name = "PrimeKarte通知情報";
						if ($_SESSION['pkinfo_list'][$index]['kind'] == 1) {
							$kind_name = "ぷらさぽ通信";
						}
						echo '<tr><td>通知区分</td><td>';
						echo '', $kind_name, '';
					}

					echo '<tr><td>タイトル</td><td>';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者以外
						echo '<input type="text" name="info_title" value="', $info_title, '" readonly="readonly">';
					} else {
						echo '<input type="text" name="info_title" value="', $info_title, '">';
					}
					echo '</td></tr>';


					echo '<tr><td>通知内容</td><td>';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者以外
						echo '<textarea name="contents" rows="5" readonly="readonly">', $contents, '</textarea>';
					} else {
						echo '<textarea name="contents" rows="5">', $contents, '</textarea>';
					}
					echo '</td></tr>';

					echo '<tr><td>１．対象機能</td><td>';
					echo '<input type="text" name="str_01" value="', $str_01, '"';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者のみ
						echo ' readonly="readonly"';
					}
					echo '>';
					echo '</td></tr>';

					echo '<tr><td>２．適用対象病院</td><td>';
					echo '<input type="text" name="str_02" value="', $str_02, '"';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者のみ
						echo ' readonly="readonly"';
					}
					echo '>';
					echo '</td></tr>';

					echo '<tr><td>３．対応内容</td><td>';
					echo '<textarea name="str_03" rows="5" ';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者のみ
						echo 'readonly="readonly"';
					}
					echo '>', $str_03, '</textarea>';
					echo '</td></tr>';

					echo '<tr><td>４．更新内容 </td><td>';
					echo '<textarea name="str_04" rows="5" ';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者のみ
						echo 'readonly="readonly"';
					}
					echo '>', $str_04, '</textarea>';
					echo '</td></tr>';

					echo '<tr><td>５．適用・適用について </td><td>';
					echo '<textarea name="str_05" rows="5" ';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者のみ
						echo 'readonly="readonly"';
					}
					echo '>', $str_05, '</textarea>';
					echo '</td></tr>';

					echo '<tr><td>６．その他 </td><td>';
					echo '<textarea name="str_06" rows="5" ';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者のみ
						echo 'readonly="readonly"';
					}
					echo '>', $str_06, '</textarea>';
					echo '</td></tr>';

					echo '<tr><td>７．本件のお問い合わせについて</td><td>';
					echo '<textarea name="str_07" rows="5" ';
					if ($_SESSION['userinfo']['kind'] != 0) {
						//修正できるのはSBS管理者のみ
						echo 'readonly="readonly"';
					}
					echo '>', $str_07, '</textarea>';
					echo '</td></tr>';

					echo '<tr><td>添付ファイル</td><td>';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//ファイル添付できるのはSBS管理者のみ
						echo '<input type="file" name="input_file" value=""><br>';
					}
					if (!empty($file_name)) {
						//まずファイルの存在を確認し、その後画像形式を確認する
						if(file_exists('./attachment/' . $file_name) && exif_imagetype('./attachment/' . $file_name)){
							echo '<br><img src="./attachment/' . $file_name. '" alt="./attachment/'. $file_name . '" width ="300">';
						}
						echo '<br><a href="./attachment/' . $file_name . '" target="_blank">' . $file_name . '</a>';
					}

					echo '</table>';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//修正できるのはSBS管理者以外
						echo '<input type="submit" class="button big primary" value="通知情報更新">';
					}

					// if (isset($_SESSION['inquiry'])) {
					if (isset($_SESSION['pkinfo_list'])) {
						// お問合せセッション情報ある場合は一覧から遷移したため、戻るボタン表示
						echo '　';

						//戻るボタン
						if ($index<=0) {
							echo '<span class="button disabled">Prev</span>　';
					  } else {
							echo '<a class="button big" href="pkinfo-form.php?index=',$index-1,'" class="button disabled">Prev</a>　';
						}
						//一覧に戻る
						echo '<a class="button big" href="pkinfo-list.php?index=',$index,'"">一覧に戻る</a>　';
						//次へボタン
						if ($index==count($_SESSION['pkinfo_list'])-1 or $index==-1) {
							echo '<span class="button disabled">Next</span>　';
					  } else {
							echo '<a class="button big" href="pkinfo-form.php?index=',$index+1,'" class="button disabled">Next</a>　';
						}
					}

					echo '</form>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
