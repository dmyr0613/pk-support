<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- inquiryMain -->
				<section id="inquiryMain">
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
					$inquiry_no=$insert_datetime=$update_datetime=$user_id=$facility_code=$facility_name=$email=$department=$person=$priority_flg=$order_kind=$contents=$kanja_id=$sbs_comment=$file_name='';
					if ($index>=0){
						//インデックス番号が渡された場合は、inquiry_list配列よりデータを取得（インデックス番号がない場合は新規登録）
						if (isset($_SESSION['inquiry_list'])) {
							$inquiry_no=$_SESSION['inquiry_list'][$index]['inquiry_no'];
							$insert_datetime=$_SESSION['inquiry_list'][$index]['insert_datetime'];
							$update_datetime=$_SESSION['inquiry_list'][$index]['update_datetime'];
							$user_id=$_SESSION['inquiry_list'][$index]['user_id'];
							$facility_code=$_SESSION['inquiry_list'][$index]['facility_code'];
							$facility_name=$_SESSION['inquiry_list'][$index]['facility_name'];
							$email=$_SESSION['inquiry_list'][$index]['email'];
							$department=$_SESSION['inquiry_list'][$index]['department'];
							$person=$_SESSION['inquiry_list'][$index]['person'];
							$priority_flg=$_SESSION['inquiry_list'][$index]['priority_flg'];
							$order_kind=$_SESSION['inquiry_list'][$index]['order_kind'];
							$contents=$_SESSION['inquiry_list'][$index]['contents'];
							$kanja_id=$_SESSION['inquiry_list'][$index]['kanja_id'];
							$sbs_comment=$_SESSION['inquiry_list'][$index]['sbs_comment'];
							$file_name=$_SESSION['inquiry_list'][$index]['file_name'];
						}
					}

					// ファイル添付のため、enctype="multipart/form-data"を追加
					if ($index>=0) {
						echo '<form action="inquiry-output.php?index=',$index,'" method="post" enctype="multipart/form-data">';
					} else {
						echo '<form action="inquiry-output.php" method="post" enctype="multipart/form-data">';
					}
					echo '<table>';

					echo '<tr><td>お問合せ番号</td><td>';
					echo '', $inquiry_no, '';
					echo '</td></tr>';

					if ($_SESSION['userinfo']['kind'] == 0) {
						//SBS管理者の場合は施設名を表示
						echo '<tr><td>施設名</td><td>';
						echo '', $facility_name, '';
					}

					echo '<tr><td>緊急度</td><td>';
					echo '<div class="col-4 col-12-small">';
					echo '	<input type="radio" id="priority-normal" name="priority" checked>';
					echo '	<label for="priority-normal">通常</label>';
					echo '	<input type="radio" id="priority-high" name="priority">';
					echo '	<label for="priority-high">至急</label>';
					echo '</div>';
					echo '</td></tr>';

					echo '<tr><td>オーダ種</td><td>';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//修正できるのはSBS管理者以外
						echo '<input type="text" name="order_kind" value="', $order_kind, '" readonly="readonly">';
					} else {
						echo '<input type="text" name="order_kind" value="', $order_kind, '">';
					}
					echo '</td></tr>';

					echo '<tr><td>事象・内容</td><td>';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//修正できるのはSBS管理者以外
						echo '<textarea name="contents" placeholder="Enter your message" rows="5" readonly="readonly">', $contents, '</textarea>';
					} else {
						echo '<textarea name="contents" placeholder="Enter your message" rows="5">', $contents, '</textarea>';
					}
					echo '</td></tr>';

					echo '<tr><td>患者ID</td><td>';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//修正できるのはSBS管理者以外
						echo '<input type="text" name="kanja_id" value="', $kanja_id, '" readonly="readonly">';
					} else {
						echo '<input type="text" name="kanja_id" value="', $kanja_id, '">';
					}

					echo '<tr><td>添付ファイル</td><td>';
					echo '<input type="file" name="input_file" value=""><br>';
					if (!empty($file_name)) {
						//まずファイルの存在を確認し、その後画像形式を確認する
						if(file_exists('./attachment/' . $file_name) && exif_imagetype('./attachment/' . $file_name)){
							echo '<br><img src="./attachment/' . $file_name. '" alt="./attachment/'. $file_name . '" width ="300">';
						}
						echo '<br><a href="./attachment/' . $file_name . '" target="_blank">' . $file_name . '</a>';
					}

					echo '<tr><td>SBS回答</td><td>';
					//修正できるのはSBS管理者のみ
					echo '<textarea name="sbs_comment" placeholder="Reply message" rows="5"';
					if ($_SESSION['userinfo']['kind'] != 0) {
					echo 'readonly="readonly"'; }
					echo '>', $sbs_comment, '</textarea>';
					echo '</td></tr>';

					echo '</table>';
					echo '<input type="submit" class="button big primary" value="問合せ情報更新">';
					// if (isset($_SESSION['inquiry'])) {
					if (isset($_SESSION['inquiry_list'])) {
						// お問合せセッション情報ある場合は一覧から遷移したため、戻るボタン表示
						echo '　';

						//戻るボタン
						if ($index<=0) {
							echo '<span class="button disabled">Prev</span>　';
					  } else {
							echo '<a class="button big" href="inquiry.php?index=',$index-1,'" class="button disabled">Prev</a>　';
						}
						//一覧に戻る
						echo '<a class="button big" href="status-list.php?index=',$index,'"">一覧に戻る</a>　';
						//次へボタン
						if ($index==count($_SESSION['inquiry_list'])-1 or $index==-1) {
							echo '<span class="button disabled">Next</span>　';
					  } else {
							echo '<a class="button big" href="inquiry.php?index=',$index+1,'" class="button disabled">Next</a>　';
						}
					}

					echo '</form>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
