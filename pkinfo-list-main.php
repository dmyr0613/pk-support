<!-- pkinfo-list-page -->
<section id="pkinfo-list-page">

	<?php

		$index = -1;
		if (isset($_REQUEST['index'])) {
			$index = $_REQUEST['index'];
		}

		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// PK通知情報一覧テーブル
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		echo '<form>';
		echo '<table class="alt" id="table">';
			//ヘッダー部
			echo '<thead>';
			echo '	<tr>';
			echo '		<th>通知番号</th>';
			echo '		<th>通知日</th>';
			if ($_SESSION['userinfo']['kind'] == 0) {
				//SBS管理者は施設名を表示
				echo '		<th>区分</th>';
			}
			echo '		<th>タイトル</th>';
			echo '	</tr>';
			echo '</thead>';
			echo '<tbody>';

			if ($index<0) {
				//新規検索時
				$sqltxt ="";
				$sqltxt = 'select * from pkinfo where condition_flg = 0 ';

				if ($_SESSION['userinfo']['kind'] != 0) {
					//SBS以外はログイン者と同じ病院コードの問合せを検索（SBS管理者は有効データ全て検索）
					$sqltxt .= ' and kind = ' . $_SESSION['userinfo']['kind'];
				}
				$sqltxt .= ' order by pkinfo_no desc';


				//pkinfo_listセッションをクリア
				unset($_SESSION['pkinfo_list']);
				$cnt=0;

				//検索SQL実行
				// echo $sqltxt;
				$sql=$pdo->prepare($sqltxt);
				$sql->execute();
				foreach ($sql as $row) {
					//pkinfo_list配列に全て設定する
					$_SESSION['pkinfo_list'][$cnt]=[
						'pkinfo_no'=>$row['pkinfo_no'],
						'insert_datetime'=>$row['insert_datetime'],
						'update_datetime'=>$row['update_datetime'],
						'kind'=>$row['kind'],
						'info_title'=>$row['info_title'],
						'contents'=>$row['contents'],
						'str_01'=>$row['str_01'],
						'str_02'=>$row['str_02'],
						'str_03'=>$row['str_03'],
						'str_04'=>$row['str_04'],
						'str_05'=>$row['str_05'],
						'str_06'=>$row['str_06'],
						'str_07'=>$row['str_07'],
						'str_08'=>$row['str_08'],
						'str_09'=>$row['str_09'],
						'str_10'=>$row['str_10'],
						'file_name'=>$row['file_name']];
						$cnt++;
				}
				$maxcnt=$cnt;
			} else {
				//入力画面から戻ってきた場合（index指定時）は、SQLを実行せずpkinfo_listセッションの内容を表示する
				$maxcnt=count($_SESSION['pkinfo_list']);
				// echo "入力画面から戻ってきた";
			}

			// PK通知情報一覧の表示行数
			$DISP_LINE_NUM=10;
			// 全体のページ数を計算
			$maxPageNum=1;
			if ($maxcnt>$DISP_LINE_NUM) {
				$maxPageNum=ceil($maxcnt/$DISP_LINE_NUM);	//切り上げ
			}

			//表示するページ番号を計算する
			if ($index<0) { $index=0; }								//index未指定時は最初から
			$dispPageNum=floor($index/$DISP_LINE_NUM);			//切り捨て
			$dispStartIndexCnt=$dispPageNum*$DISP_LINE_NUM;	//表示するページ番号の最初のindex
			$dispPageNum++;														//表示するページ番号
			// echo '　表示ページ番号:' . $dispPageNum;
			// echo '　最大ページ番号' . $maxPageNum;
			// echo '　表示開始Index番号' . $dispStartIndexCnt;

			//ページ遷移ボタンの制御フラグ
			$prevFlg=true;
			$nextFlg=true;
			if ($dispPageNum==1) { $prevFlg=false; }						//1ページ目は戻るボタン非表示
			if ($dispPageNum==$maxPageNum) { $nextFlg=false; }	//最終ページは次へボタン非表示

			$pageCnt=0;
			//PK通知情報一覧テーブル描画
			for ($cnt=0; $cnt<$maxcnt; $cnt++) {

				$dispFlg=false;
				if ($cnt>=$dispStartIndexCnt && $pageCnt<$DISP_LINE_NUM) {
					//indexが表示開始Index番号よりも大きく、表示ページ範囲内であれば、行表示
					$dispFlg=True;
					$pageCnt++;
				}

				if ($dispFlg) {
					// 行クリックで詳細表示
					echo '<tr data-href="pkinfo-form.php?index=',$cnt,'">';
					echo '	<td width="100">', $_SESSION['pkinfo_list'][$cnt]['pkinfo_no'];
					if ($_SESSION['pkinfo_list'][$cnt]['update_datetime'] >= date('Y-m-d', strtotime("-1 day"))) {
						//更新日が3日前であれば、NEWアイコンを表示
						echo ' <img src="images/new.gif" height="20">';
					}
					echo '</td>';
					echo '	<td width="150">', date('Y年m月d日', strtotime($_SESSION['pkinfo_list'][$cnt]['update_datetime'])), '</td>';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//SBS管理者は区分を表示
						$kind_name = "PrimeKarte通知情報";
						if ($_SESSION['pkinfo_list'][$cnt]['kind'] == 1) {
							$kind_name = "ぷらさぽ通信";
						}
						echo '	<td>', $kind_name, '</td>';
					}
					echo '	<td>', $_SESSION['pkinfo_list'][$cnt]['info_title'], '</td>';
					echo '</tr>';
				}
			}

			echo '</tbody>';
		echo '</table>';

		//ページ切り替えボタン表示制御
		echo '<div align="right">';
		if ($_SESSION['userinfo']['kind'] == 0) {
			//SBS管理者は新規登録ボタンを表示
			echo '<a class="button big primary" href="pkinfo-form.php" class="button disabled">PK通知情報 新規登録</a>　';
		}
		//戻るボタン
		if ($prevFlg) {
			echo '<a class="button big" href="pkinfo-list.php?index=',$dispStartIndexCnt-$DISP_LINE_NUM,'" class="button disabled">Prev</a>　';
		} else {
			echo '<span class="button disabled">Prev</span>　';
		}
		//次へボタン
		if ($nextFlg) {
			echo '<a class="button big" href="pkinfo-list.php?index=',$dispStartIndexCnt+$DISP_LINE_NUM,'" class="button disabled">Next</a>　';
		} else {
			echo '<span class="button disabled">Next</span>　';
		}
		echo '</div>';

		echo '</form>';
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
		// PK通知情報一覧テーブル
		// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	?>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
 //行クリックでページ遷移できるスクリプト
	jQuery(function($) {
	  //data-hrefの属性を持つtrを選択しclassにclickableを付加
	  $('tr[data-href]').addClass('clickable')

	    //クリックイベント
	    .click(function(e) {
	      //e.targetはクリックした要素自体、それがa要素以外であれば
	      if(!$(e.target).is('a')){

	        //その要素の先祖要素で一番近いtrの
	        //data-href属性の値に書かれているURLに遷移する
	        window.location = $(e.target).closest('tr').data('href');}
	  });
	});
</script>
