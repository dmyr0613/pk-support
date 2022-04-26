<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- userinfoMain -->
				<section id="userinfoMain">
					<?php
					//各種セッションをクリア
					unset($_SESSION['inquiry_list']);
					unset($_SESSION['searchpara']);

					$user_id=$kind=$facility_code=$facility_name=$password=$email=$department=$person='';
					if (isset($_SESSION['userinfo'])) {
						$user_id=$_SESSION['userinfo']['user_id'];
						$kind=$_SESSION['userinfo']['kind'];
						$facility_code=$_SESSION['userinfo']['facility_code'];
						$facility_name=$_SESSION['userinfo']['facility_name'];
						$password=$_SESSION['userinfo']['password'];
						$email=$_SESSION['userinfo']['email'];
						$department=$_SESSION['userinfo']['department'];
						$person=$_SESSION['userinfo']['person'];
					}
					else {
						// ログイン中でなければ、トップページへ戻る
						header("location: login-input.php");
					}
					echo '<form action="userinfo-output.php" method="post">';
					echo '<table>';
					echo '<tr><td>ユーザーID</td><td>';
					if (empty($user_id)) {
						//ReadOnly属性を外す
						echo '<input type="text" name="user_id" value="">';
					} else {
						// echo '<input type="text" name="user_id" value="', $user_id, '" readonly="readonly">';
						echo '', $user_id , '';
					}
					echo '</td></tr>';

					echo '<tr><td>施設区分</td><td>';
					// echo '<input type="hidden" name="kind" value="', $kind, '">';
					switch ($kind){
						case 1:
						  echo '医療機関様';
						  break;
						case 2:
							echo 'パートナー企業様';
						  break;
						default:
							echo 'SBS管理者';
					}
					echo '</td></tr>';

					echo '<tr><td>施設コード</td><td>';
					echo '', $facility_code , '';
					echo '</td></tr>';
					echo '<tr><td>施設名</td><td>';
					echo '<input type="text" name="facility_name" value="', $facility_name, '">';
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
					echo '　<a href="logout.php" class="button big">ログアウト</a>';
					echo '</form>';
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
