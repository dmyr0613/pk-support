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
						<p><input type="submit" value="アイコン検索"></p>
					</form>

				</section>

				<body>
			    localStrageに保存する値を入力して下さい<br />
			    <input name="mydata_in" id="mydata_in" type="text" value="" />
			    <br />
			    <input type="button" value="読込" onclick="load();"/>
			    <input type="button" value="保存" onclick="save();"/>
			    <br /><br />
			    <div id="mydata_out"></div>
			  </body>

				<script language="javascript" type="text/javascript">
		      // 読込
		      function load() {
		        var mydata = "";
		        if(!localStorage.getItem('mydata')) {
		          mydata = "データがありません";
		        } else {
		          mydata = localStorage.getItem('mydata');
		        }
		        console.log(`mydata= ${mydata}`);
		        document.getElementById("mydata_out").innerHTML = mydata;
		      }
		      // 保存
		      function save() {
		        var mydata = document.getElementById("mydata_in").value;
		        console.log(`mydata_in = ${mydata_in}`);
		        localStorage.setItem('mydata', mydata);
		      }
		    </script>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
