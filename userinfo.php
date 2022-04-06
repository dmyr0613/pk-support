<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- userinfoMain -->
				<section id="userinfoMain">
					<?php
					$user_id=$name=$password=$email=$department=$person='';
					if (isset($_SESSION['userinfo'])) {
						$user_id=$_SESSION['userinfo']['user_id'];
						$name=$_SESSION['userinfo']['name'];
						$password=$_SESSION['userinfo']['password'];
						$email=$_SESSION['userinfo']['email'];
						$department=$_SESSION['userinfo']['department'];
						$person=$_SESSION['userinfo']['person'];
					}
					else {
						header("location: login-input.php");
					}
					echo '<form action="userinfo-output.php" method="post">';
					echo '<table>';
					echo '<tr><td>ユーザーID</td><td>';
					if (empty($user_id)) {
						//ReadOnly属性を外す
						echo '<input type="text" name="user_id" value="">';
					} else {
						echo '<input type="text" name="user_id" value="', $user_id, '" readonly="readonly">';
					}
					echo '</td></tr>';
					echo '<tr><td>施設名</td><td>';
					echo '<input type="text" name="name" value="', $name, '">';
					echo '</td></tr>';
					echo '<tr><td>パスワード</td><td>';
					echo '<input type="password" name="password" value="', $password, '">';
					echo '</td></tr>';
					echo '</td></tr>';
					echo '<tr><td>メールアドレス</td><td>';
					echo '<input type="text" name="email" value="', $email, '">';
					echo '</td></tr>';
					echo '<tr><td>部署</td><td>';
					echo '<input type="text" name="department" value="', $department, '">';
					echo '</td></tr>';
					echo '<tr><td>担当者名</td><td>';
					echo '<input type="text" name="person" value="', $person, '">';
					echo '</td></tr>';
					echo '</table>';
					echo '<input type="submit" class="button big primary" value="ユーザ情報更新">';
					echo '　<a href="main.php" class="button big">ホーム</a>';
					echo '</form>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
