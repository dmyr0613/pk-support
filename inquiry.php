<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- inquiryMain -->
				<section id="inquiryMain">
					<?php
					$inquiry_no=$insert_datetime=$update_datetime=$user_id=$facility_code=$facility_name=$priority_flg=$order_kind=$contents=$kanja_id=$sbs_comment='';
					if (isset($_SESSION['inquiry'])) {
						// お問合せセッション情報ある場合
						$inquiry_no=$_SESSION['inquiry']['inquiry_no'];
						$insert_datetime=$_SESSION['inquiry']['insert_datetime'];
						$update_datetime=$_SESSION['inquiry']['update_datetime'];
						$user_id=$_SESSION['inquiry']['user_id'];
						$facility_code=$_SESSION['inquiry']['facility_code'];
						$facility_name=$_SESSION['inquiry']['facility_name'];
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

					echo '<tr><td>緊急度</td><td>';
					echo '<div class="col-4 col-12-small">';
					echo '	<input type="radio" id="priority-normal" name="priority" checked>';
					echo '	<label for="priority-normal">通常</label>';
					echo '	<input type="radio" id="priority-high" name="priority">';
					echo '	<label for="priority-high">至急</label>';
					echo '</div>';
					echo '</td></tr>';

					echo '<tr><td>オーダ種</td><td>';
					echo '<input type="text" name="order_kind" value="', $order_kind, '">';
					echo '</td></tr>';
					echo '<tr><td>事象・内容</td><td>';
					// echo '<input type="text" name="contents" value="', $contents, '">';
					echo '<textarea name="contents" value="', $contents, '" placeholder="Enter your message" rows="6">', $contents, '</textarea>';
					// <textarea name="demo-message" id="demo-message" placeholder="Enter your message" rows="6"></textarea>

					echo '</td></tr>';
					echo '<tr><td>患者ID</td><td>';
					echo '<input type="text" name="kanja_id" value="', $kanja_id, '">';

					echo '<tr><td></td><td>';
					echo '　';
					echo '</td></tr>';

					echo '</td></tr>';
					echo '<tr><td>SBS回答</td><td>';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//修正できるのはSBS管理者のみ
						echo '<input type="text" name="sbs_comment" value="', $sbs_comment, '">';
					} else {
						echo '', $sbs_comment, '';
					}
					echo '</td></tr>';

					echo '</table>';
					if (isset($_SESSION['inquiry'])) {
						// お問合せセッション情報ある場合
						echo '<input type="submit" class="button big primary" value="問合せ情報更新">';
						echo '　';
						echo '<a class="button big" href="status-list.php">一覧に戻る</a>';
					}else {
						echo '<input type="submit" class="button big primary" value="問合せ情報登録">';
					}
					echo '</form>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
