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
										<?php
										if (isset($_SESSION['userinfo']) == false){
											//ログアウト状態時のメニュー
											echo '<li><a href="login-input.php">ログイン Login</a></li>';
										}else {
											// ログイン時のみ表示するメニュー
											if ($_SESSION['userinfo']['kind'] != 0) {
												//新規問合せフォームはユーザのみ表示
												echo '<li><a href="inquiry-form.php">新規問合せ Inquiry</a></li>';
											}
											echo '<li><a href="inquiry-list.php">問合せ状況一覧 Inquiry List</a></li>';
											echo '<li><a href="#">事例検索 Search</a></li>';
											echo '<li><a href="pkinfo-list.php">PK通知情報 Information</a></li>';
											echo '<li><a href="userinfo.php">ユーザ情報 User Info</a></li>';
										}
										?>
										<li><a href="iconsearch.php">アイコンダウンロード Download</a></li>
										<li><a href="elements.html" target="_blank">Elements</a></li>
									</ul>
								</nav>

								<!-- Footer -->
									<footer id="footer">
										<p class="copyright"><a href="https://www.sbs-infosys.co.jp/" target=”_blank”>&copy; SBS Information Systems Co.,Ltd.</a> All rights reserved. Design: <a href="https://html5up.net" target=”_blank”>HTML5 UP</a>.</p>
									</footer>

						</div>
					</div>

</html>
