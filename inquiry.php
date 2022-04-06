<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				inquiry_no int not null unique,
			  user_id varchar(15),
			  facility_code varchar(15),
			  priority_flg int,
				order_kind varchar(100),
				contents varchar(1000),
			  kanja_id varchar(15),
			  sbs_comment varchar(1000)

				<!-- inquiryMain -->
				<section id="inquiryMain">
					<?php
					$inquiry_no=$user_id=$facility_code=$facility_name=$priority_flg=$order_kind=$contents=$kanja_id=$sbs_comment='';
					if (isset($_SESSION['inquiry'])) {
						$inquiry_no=$_SESSION['inquiry']['inquiry_no'];
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
					echo '<input type="text" name="contents" value="', $contents, '">';
					echo '</td></tr>';
					echo '<tr><td>患者ID</td><td>';
					echo '<input type="text" name="kanja_id" value="', $kanja_id, '">';

					echo '<tr><td></td><td>';
					echo '　';
					echo '</td></tr>';

					echo '</td></tr>';
					echo '<tr><td>SBS回答</td><td>';
					echo '<input type="text" name="sbs_comment" value="', $sbs_comment, '">';
					echo '</td></tr>';
					echo '</table>';
					echo '<input type="submit" class="button big primary" value="問合せ情報登録">';
					echo '</form>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
