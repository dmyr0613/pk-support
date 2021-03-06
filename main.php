<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

			<!-- Header -->
			<?php require 'header-sub.php'; ?>

			<!-- Banner -->
				<section id="banner">
					<div class="content">
						<header>
							<h1>PK-Support</h1>
							<p>PrimeKarte Support Center</p>
						</header>
						<p>PrimeKarteサポートセンターサイトです。<br>
							ご質問や不具合等の調査依頼について、お問合せフォームより記入をお願いいたします。<br>
							フォームの回答欄およびメールにて、ご回答させていただきます。</p>
							<!-- <br>通知情報（ぷらさぽ通信）も随時発信しています。</p> -->
						<ul class="actions">
							<?php
							//各種セッションをクリア
							unset($_SESSION['inquiry_list']);
							unset($_SESSION['searchpara']);


							if (isset($_SESSION['userinfo'])) {
								//ログイン時は「ログアウト」ボタン
								echo '<li><a href="logout.php" class="button big">ログアウト</a></li>';
							} else {
								//ログアウト時は「ログイン」ボタン
								echo '<li><a href="login-input.php" class="button big">ログイン</a></li>';
							}
							?>
						</ul>
					</div>
					<span class="image object">
						<!-- <img src="images/171024_5.jpg" alt="" /> -->
						<!-- <img src="images/100127_2.jpg" alt="" /> -->
						<img src="images/101208_1.jpg" alt="" />
					</span>
				</section>

				<?php
				if (isset($_SESSION['userinfo'])) {
					if ($_SESSION['userinfo']['kind']==2) {
						echo '<h3>PrimeKarte通知情報</h3>';
					} else {
						echo '<h3>PrimeKarte通知情報（ぷらさぽ通信）</h3>';
					}
						//ログイン時は、PK通知情報を画面下部に表示
					require 'pkinfo-list-main.php';
				}
				?>

			<!-- Section -->
			<!--
				<section>
					<header class="major">
						<h2>MARCSでできること</h2>
					</header>
					<div class="posts">
						<article>
							<a href="#" class="image"><img src="images/pic01.jpg" alt="" /></a>
							<h3>診察予約 Reserve</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li><a href="#" class="button">More</a></li>
							</ul>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic02.jpg" alt="" /></a>
							<h3>問診情報 Symptoms</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li><a href="#" class="button">More</a></li>
							</ul>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic03.jpg" alt="" /></a>
							<h3>ユーザ情報 UserInfo</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li><a href="#" class="button">More</a></li>
							</ul>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic04.jpg" alt="" /></a>
							<h3>Sed etiam facilis</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li><a href="#" class="button">More</a></li>
							</ul>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic05.jpg" alt="" /></a>
							<h3>Feugiat lorem aenean</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li><a href="#" class="button">More</a></li>
							</ul>
						</article>
						<article>
							<a href="#" class="image"><img src="images/pic06.jpg" alt="" /></a>
							<h3>Amet varius aliquam</h3>
							<p>Aenean ornare velit lacus, ac varius enim lorem ullamcorper dolore. Proin aliquam facilisis ante interdum. Sed nulla amet lorem feugiat tempus aliquam.</p>
							<ul class="actions">
								<li><a href="#" class="button">More</a></li>
							</ul>
						</article>
					</div>
				</section>
			-->

		</div>
	</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
