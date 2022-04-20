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

					$inquiry_no=$insert_datetime=$update_datetime=$user_id=$facility_code=$facility_name=$email=$department=$person=$priority_flg=$order_kind=$contents=$kanja_id=$sbs_comment='';
					if (isset($_SESSION['inquiry'])) {
						// お問合せセッション情報ある場合
						$inquiry_no=$_SESSION['inquiry']['inquiry_no'];
						$insert_datetime=$_SESSION['inquiry']['insert_datetime'];
						$update_datetime=$_SESSION['inquiry']['update_datetime'];
						$user_id=$_SESSION['inquiry']['user_id'];
						$facility_code=$_SESSION['inquiry']['facility_code'];
						$facility_name=$_SESSION['inquiry']['facility_name'];
						$email=$_SESSION['inquiry']['email'];
						$department=$_SESSION['inquiry']['department'];
						$person=$_SESSION['inquiry']['person'];
						$priority_flg=$_SESSION['inquiry']['priority_flg'];
						$order_kind=$_SESSION['inquiry']['order_kind'];
						$contents=$_SESSION['inquiry']['contents'];
						$kanja_id=$_SESSION['inquiry']['kanja_id'];
						$sbs_comment=$_SESSION['inquiry']['sbs_comment'];
					}

					echo '<form action="inquiry-output.php" method="post">';
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

					echo '<tr><td>SBS回答</td><td>';
					//修正できるのはSBS管理者のみ
					echo '<textarea name="sbs_comment" placeholder="Reply message" rows="5"';
					if ($_SESSION['userinfo']['kind'] != 0) {
					echo 'readonly="readonly"'; }
					echo '>', $sbs_comment, '</textarea>';
					echo '</td></tr>';

					echo '</table>';
					echo '<input type="submit" class="button big primary" value="問合せ情報更新">';
					if (isset($_SESSION['inquiry'])) {
						// お問合せセッション情報ある場合は一覧から遷移したため、戻るボタン表示
						echo '　';
						echo '<a class="button big" href="status-list.php">一覧に戻る</a>';
					}
					echo '</form>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
