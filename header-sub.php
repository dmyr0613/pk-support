<?php session_start(); ?>

			<!-- Header -->
				<header id="header">
					<a href="index.php" class="logo"><strong>PK Support</strong> Prime Karte Support Center</a>
					<ul class="icons">
						<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
						<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
						<li><a href="#" class="icon fa-snapchat-ghost"><span class="label">Snapchat</span></a></li>
						<li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
						<li><a href="#" class="icon fa-medium"><span class="label">Medium</span></a></li>
					</ul>

					<?php
						$kanja_id=$name=$password=$line_id=$phone_no='';
						if (isset($_SESSION['kanja'])) {
							$kanja_id=$_SESSION['kanja']['kanja_id'];
							$name=$_SESSION['kanja']['name'];
							$password=$_SESSION['kanja']['password'];
							$line_id=$_SESSION['kanja']['line_id'];
							$phone_no=$_SESSION['kanja']['phone_no'];
						}
						echo '<tr><td>ユーザ名:', $name, '</td><td>';
					?>
				</header>
