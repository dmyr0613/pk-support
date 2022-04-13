<?php session_start(); ?>

			<!-- Header -->
				<header id="header">
					<a href="main.php" class="logo"><strong>PK-Support</strong>　PrimeKarte Support Center</a>
					<!--
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
					</ul>
					-->

					<!-- ログイン中はユーザ名を表示 -->
					<?php
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
							echo '<tr><td><span style="color:#4A92FF; text-align: right">ようこそ、', $facility_name, '様</span></td><td>';
						}
					?>
				</header>
