<?php session_start(); ?>
<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- loginpage -->
				<section id="loginpage">
					<?php
					unset($_SESSION['kanja']);

					//localhost mySql
				  // $pdo=new PDO('mysql:host=localhost;dbname=marcs;charset=utf8', 'sbs', 'sbs_toro');

				  //Heroku PostgresSQL
				  // $dsn = 'pgsql:dbname=d13p6kmhdcirvm host=ec2-174-129-208-118.compute-1.amazonaws.com port=5432';
				  // $user = 'gkijtxlavebgol';
				  // $password = 'ecff643bfa3612a94627c9d668f867a06ce4b86e4a69f8a42d981af26c50a505';
				  // $pdo = new PDO($dsn, $user, $password);

					$sql=$pdo->prepare('select * from userinfo where user_id=? and password=?');
					$sql->execute([$_REQUEST['user_id'], $_REQUEST['password']]);
					foreach ($sql as $row) {
						$_SESSION['userinfo']=[
							'no'=>$row['no'],
							'user_id'=>$row['user_id'],
							'name'=>$row['name'],
							'password'=>$row['password'],
							'email'=>$row['email'],
							'department'=>$row['department'],
							'person'=>$row['person']];
					}
					if (isset($_SESSION['userinfo'])) {
						echo '<p>ようこそ、', $_SESSION['userinfo']['name'], '様</p>';
						echo '<ul class="actions">';
						echo '<li><a href="main.php" class="button big">TOPPAGE</a></li>';
						echo '</ul>';
					} else {
						echo '<p>ログイン名またはパスワードが違います。</p>';
						echo '<ul class="actions">';
						echo '<li><a href="login-input.php" class="button big">戻る</a></li>';
						echo '</ul>';
					}
					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
