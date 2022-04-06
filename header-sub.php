<?php session_start(); ?>

			<!-- Header -->
				<header id="header">
					<a href="index.php" class="logo"><strong>PK-Support</strong>　PrimeKarte Support Center</a>
					<!--
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
					</ul>
					-->

					<!-- ログイン中はユーザ名を表示 -->
					<?php
						$user_id=$name=$password=$email=$department=$person='';
						if (isset($_SESSION['userinfo'])) {
							$user_id=$_SESSION['userinfo']['user_id'];
							$name=$_SESSION['userinfo']['name'];
							$password=$_SESSION['userinfo']['password'];
							$email=$_SESSION['userinfo']['email'];
							$department=$_SESSION['userinfo']['department'];
							$person=$_SESSION['userinfo']['person'];
							echo '<tr><td>ようこそ、', $name, 'æ§˜</td><td>';
						}
					?>
				</header>
