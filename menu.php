<!DOCTYPE HTML>

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">

							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>Menu</h2>
									</header>
									<ul>
										<li><a href="main.php">メイン TopPage</a></li>
										<li><a href="login-input.php">ログイン Login</a></li>
										<?php
										if (isset($_SESSION['userinfo'])) {
											echo '<li><a href="#">新規問合せ Inquiry</a></li>';
											echo '<li><a href="#">問合せ状況一覧 Status List</a></li>';
											echo '<li><a href="#">事例検索 Search</a></li>';
											echo '<li><a href="#">PK通知情報 Information</a></li>';
											echo '<li><a href="userinfo.php">ユーザ情報 User Info</a></li>';
										}
										?>
										<li><a href="#">アイコンダウンロード Download</a></li>
										<li><a href="elements.html">Elements</a></li>
									</ul>
								</nav>

						</div>
					</div>


</html>
