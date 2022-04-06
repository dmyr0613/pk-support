<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- inquiryMain -->
				<section id="inquiryMain">
					<?php
					// $user_id=$name=$password=$email=$department=$person='';
					// if (isset($_SESSION['userinfo'])) {
					// 	$user_id=$_SESSION['userinfo']['user_id'];
					// 	$name=$_SESSION['userinfo']['name'];
					// 	$password=$_SESSION['userinfo']['password'];
					// 	$email=$_SESSION['userinfo']['email'];
					// 	$department=$_SESSION['userinfo']['department'];
					// 	$person=$_SESSION['userinfo']['person'];
					// }
					// else {
					// 	header("location: login-input.php");
					// }
					echo '<form action="inquiry-output.php" method="post">';
					echo '<table>';

					echo '<tr><td>緊急度</td><td>';
					echo '<div class="col-4 col-12-small">';
					echo '	<input type="radio" id="priority-normal" name="priority" checked>';
					echo '	<label for="priority-normal">通常</label>';
					echo '</div>';
					echo '<div class="col-4 col-12-small">';
					echo '	<input type="radio" id="demo-priority-high" name="priority">';
					echo '	<label for="priority-high">至急</label>';
					echo '</div>';
					echo '</td></tr>';

					echo '<tr><td>オーダ種</td><td>';
					echo '<input type="text" name="order_kind" value="', $order_kind, '">';
					echo '</td></tr>';
					echo '<tr><td>事象・内容</td><td>';
					echo '<input type="password" name="contents" value="', $contents, '">';
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
