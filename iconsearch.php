<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<?php
					//各種セッションをクリア
					unset($_SESSION['inquiry_list']);
					unset($_SESSION['searchpara']);
				?>

				<!-- iconsearch -->
				<section id="iconsearch">

					<form action="iconsearch-output.php" method="post">

						<div class="col-4 col-12-small">
							アイコンサイズ　
							<input type="radio" id="priority-normal" name="priority" checked>
							<label for="priority-normal">256px</label>
							<input type="radio" id="priority-high" name="priority">
							<label for="priority-high">512px</label>
						</div>

						検索ワード<input type="text" name="search"><br>
						<p><input type="submit" value="アイコン検索" onclick="buttonClick()"></p>

						<!-- 処理中アニメーション（最初は非表示） -->
						<div id="loading"><img src="images/loading2.gif"></div>

					</form>
				</section>

				<?php

				// $txtFacility = "H001@@AA病院";
				// $DELIM_STR = "@@";
				// $stPos1 = strpos($txtFacility, $DELIM_STR);
				// $stPos2 = $stPos1 + strlen($DELIM_STR);
				// print '<br>' . substr($txtFacility, 0, $stPos1);
				// print '<br>' . substr($txtFacility, $stPos2, strlen($txtFacility) - $stPos2);
				?>

			</div>
		</div>

		<style>
			/* 処理中アニメーションの表示位置など */
			#loading{
			position:fixed;
			left:50%;
			top:30%;
			margin-left:-30px;
			}
		</style>
		<script>
		function buttonClick(){
			// 登録ボタンクリック時、処理中アニメーションを表示する
			document.getElementById('loading').style.display ="block";
		}
		window.onload = function() {
			// 画面描画時に、処理中アニメーションを非表示
			document.getElementById('loading').style.display ="none";
		}
		</script>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
