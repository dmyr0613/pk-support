<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- inquiryMain -->
				<section id="inquiryMain">

					<!-- 処理中アニメーション（最初は非表示） -->
					<div id="loading"><img src="images/loading2.gif"></div>

					<?php
					//ログイン情報がなければ、トップページに遷移
					if (isset($_SESSION['userinfo']) == false){
						header("location: main.php");
					}

					$index = -1;
					if (isset($_REQUEST['index'])) {
						$index = $_REQUEST['index'];
					}

					//変数初期化
					$inquiry_no=$condition_flg=$insert_datetime=$update_datetime=$step_flg=$user_id=$facility_code=$facility_name=
					$email=$department=$person=$facility_code_02=$facility_name_02=$priority_flg=$inquiry_title=$inquiry_kind=
					$order_kind=$contents=$kanja_id=$file_name=$hakkou_datetime=$order_no=$rep_flg=$rep_process=
					$hassei_datetime=$pc_name=$end_user_id=$log_file_name=$contents_02=$contents_03=$sbs_comment=
					$doc_file_name=$asana_gid='';

					// 日付タイムゾーン宣言
					date_default_timezone_set('Asia/Tokyo');
					// $hakkou_datetime = date("Y-m-d");
					// $hassei_datetime = date("Y-m-d");

					if ($index>=0){
						//インデックス番号が渡された場合は、inquiry_list配列よりデータを取得（インデックス番号がない場合は新規登録）
						if (isset($_SESSION['inquiry_list'])) {
							$inquiry_no=$_SESSION['inquiry_list'][$index]['inquiry_no'];
							// $condition_flg=$_SESSION['inquiry_list'][$index]['condition_flg'];
							$insert_datetime=$_SESSION['inquiry_list'][$index]['insert_datetime'];
							$update_datetime=$_SESSION['inquiry_list'][$index]['update_datetime'];
							$step_flg=$_SESSION['inquiry_list'][$index]['step_flg'];
							$user_id=$_SESSION['inquiry_list'][$index]['user_id'];
							$facility_code=$_SESSION['inquiry_list'][$index]['facility_code'];
							$facility_name=$_SESSION['inquiry_list'][$index]['facility_name'];
							$email=$_SESSION['inquiry_list'][$index]['email'];
							$department=$_SESSION['inquiry_list'][$index]['department'];
							$person=$_SESSION['inquiry_list'][$index]['person'];
							$facility_code_02=$_SESSION['inquiry_list'][$index]['facility_code_02'];
							$facility_name_02=$_SESSION['inquiry_list'][$index]['facility_name_02'];
							$priority_flg=$_SESSION['inquiry_list'][$index]['priority_flg'];
							$inquiry_title=$_SESSION['inquiry_list'][$index]['inquiry_title'];
							$inquiry_kind=$_SESSION['inquiry_list'][$index]['inquiry_kind'];
							$order_kind=$_SESSION['inquiry_list'][$index]['order_kind'];
							$contents=$_SESSION['inquiry_list'][$index]['contents'];
							$kanja_id=$_SESSION['inquiry_list'][$index]['kanja_id'];
							$file_name=$_SESSION['inquiry_list'][$index]['file_name'];
							$hakkou_datetime=date("Y-m-d",strtotime($_SESSION['inquiry_list'][$index]['hakkou_datetime']));
							$order_no=$_SESSION['inquiry_list'][$index]['order_no'];
							$rep_flg=$_SESSION['inquiry_list'][$index]['rep_flg'];
							$rep_process=$_SESSION['inquiry_list'][$index]['rep_process'];
							$hassei_datetime=date("Y-m-d",strtotime($_SESSION['inquiry_list'][$index]['hassei_datetime']));
							$pc_name=$_SESSION['inquiry_list'][$index]['pc_name'];
							$end_user_id=$_SESSION['inquiry_list'][$index]['end_user_id'];
							$log_file_name=$_SESSION['inquiry_list'][$index]['log_file_name'];
							$contents_02=$_SESSION['inquiry_list'][$index]['contents_02'];
							$contents_03=$_SESSION['inquiry_list'][$index]['contents_03'];
							$sbs_comment=$_SESSION['inquiry_list'][$index]['sbs_comment'];
							$doc_file_name=$_SESSION['inquiry_list'][$index]['doc_file_name'];
							$asana_gid=$_SESSION['inquiry_list'][$index]['asana_gid'];
						}
					}

					$PRE_TXT = '';
					if ($_SESSION['userinfo']['kind'] == 0) {
						//SBS管理者は修正不可とするため
						$PRE_TXT = 'readonly="readonly"';
					}

					// 既存データの場合はindexを渡す。ファイル添付のため、enctype="multipart/form-data"を追加
					if ($index>=0) {
						echo '<form action="inquiry-form-output.php?index=',$index,'" method="post" enctype="multipart/form-data">';
					} else {
						echo '<form action="inquiry-form-output.php" method="post" enctype="multipart/form-data">';
					}
					echo '<table>';

					echo '<tr><td>問合せ番号</td><td>';
					echo $inquiry_no;
					echo '</td></tr>';

					if ($_SESSION['userinfo']['kind'] == 0) {
						//SBS管理者の場合は施設名を表示
						echo '<tr><td>施設名</td><td>';
						echo $facility_name;
						echo '</td></tr>';
					}

					if ($index>=0) {
						echo '<tr><td>登録日／更新日</td><td>';
						echo $insert_datetime;
						if ($update_datetime != "") { echo '／'. $update_datetime; }
						echo '</td></tr>';
					}

					if ($_SESSION['userinfo']['kind'] == 0) {
						//SBS管理者は検索条件に施設名を表示
						echo '<tr><td>病院名</td><td>';
						echo '<div class="col-12">';
						echo '	<select name="facility_code_02" id="facility_code_02">';
						echo '		<option value="">全て</option>';
						echo '		<option value="H301@@AA病院">AA病院</option>';
						echo '		<option value="H302@@BB病院">BB病院</option>';
						echo '		<option value="H303@@CC病院">CC病院</option>';
						echo '	</select>';
						echo '</td></tr>';
					} else {
						//facility_code_02をPOSTする必要があるため、hidden表示
						echo '<input type="hidden" id="facility_code_02" name="facility_code_02" value="">';
					}

					echo '<tr><td>緊急度</td><td>';
					echo '<div class="col-4 col-12-small">';
					echo '	<input type="radio" id="priority_flg0" name="priority_flg" value="0" ';
					if ($priority_flg==0) { echo 'checked>'; } else { echo '>'; };
					echo '	<label for="priority_flg0">通常</label>';
					echo '	<input type="radio" id="priority_flg1" name="priority_flg" value="1" ';
					if ($priority_flg==1) { echo 'checked>'; } else { echo '>'; };
					echo '	<label for="priority_flg1">至急</label>';
					echo '</div>';
					echo '</td></tr>';

					echo '<tr><td>タイトル</td><td>';
					echo '<input type="text" name="inquiry_title" value="', $inquiry_title, '" ' . $PRE_TXT . ' >';
					echo '</td></tr>';


					echo '<tr><td>オーダ種</td><td>';
					echo '<input type="text" name="order_kind" value="', $order_kind, '" ' . $PRE_TXT . '>';
					echo '</td></tr>';

					echo '<tr><td>事象・内容</td><td>';
					echo '<textarea name="contents" placeholder="Enter your message" rows="10" ' . $PRE_TXT . '>', $contents, '</textarea>';
					echo '</td></tr>';

					if ($_SESSION['userinfo']['kind'] == 0 && $kanja_id=="") {
						echo '<input type="hidden" name="kanja_id" value="" >';	//SBS管理者でデータがない場合は非表示
					} else {
						echo '<tr><td>患者ID</td><td>';
						echo '<input type="text" name="kanja_id" value="', $kanja_id, '" ' . $PRE_TXT . '>';
						echo '</td></tr>';
					}

					// if ($_SESSION['userinfo']['kind'] == 0 && $file_name=="") {
					// 	echo '<input type="hidden" name="input_file" value="" >';	//SBS管理者でデータがない場合は非表示
					// } else {
						echo '<tr><td>添付資料・ハードコピー</td><td>';
						echo '<input type="file" name="input_file" value=""><br>';
						if (!empty($file_name)) {
							//まずファイルの存在を確認し、その後画像形式を確認する
							if(file_exists('./attachment/' . $file_name) && exif_imagetype('./attachment/' . $file_name)){
								echo '<br><img src="./attachment/' . $file_name. '" alt="./attachment/'. $file_name . '" width ="300">';
							}
							echo '<br><a href="./attachment/' . $file_name . '" target="_blank">' . $file_name . '</a>';
						}
					// }

					echo '<tr><td>オーダ日付</td><td>';
					echo '<input type="date" name="hakkou_datetime" value="', $hakkou_datetime ,'">';
					echo '</td></tr>';

					echo '<tr><td>オーダNo</td><td>';
					echo '<input type="number" name="order_no" value="', $order_no, '" ' . $PRE_TXT . '>';
					echo '</td></tr>';

					echo '<tr><td>再現性</td><td>';
					echo '<div class="col-4 col-12-small">';
					echo '	<input type="radio" id="rep_flg0" name="rep_flg" value="0" ';
					if ($rep_flg==0) { echo 'checked>'; } else { echo '>'; };
					echo '	<label for="rep_flg0">なし</label>';
					echo '	<input type="radio" id="rep_flg1" name="rep_flg" value="1" ';
					if ($rep_flg==1) { echo 'checked>'; } else { echo '>'; };
					echo '	<label for="rep_flg1">あり</label>';
					echo '</div>';
					echo '</td></tr>';

					echo '<tr><td>操作手順</td><td>';
					echo '<textarea name="rep_process" placeholder="Enter your message" rows="5" ' . $PRE_TXT . '>', $rep_process, '</textarea>';
					echo '</td></tr>';

					echo '<tr><td>発生日付</td><td>';
					echo '<input type="date" name="hassei_datetime" value="', $hassei_datetime ,'">';
					echo '</td></tr>';

					echo '<tr><td>端末名</td><td>';
					echo '<input type="text" name="pc_name" value="', $pc_name, '" ' . $PRE_TXT . '>';
					echo '</td></tr>';

					echo '<tr><td>利用者ID</td><td>';
					echo '<input type="text" name="end_user_id" value="', $end_user_id, '" ' . $PRE_TXT . '>';
					echo '</td></tr>';

					echo '<tr><td>ログファイル</td><td>';
					echo '<input type="file" name="log_file_name" value=""><br>';
					if (!empty($log_file_name)) {
						//まずファイルの存在を確認し、その後画像形式を確認する
						if(file_exists('./attachment/' . $log_file_name) && exif_imagetype('./attachment/' . $log_file_name)){
							echo '<br><img src="./attachment/' . $log_file_name. '" alt="./attachment/'. $log_file_name . '" width ="300">';
						}
						echo '<br><a href="./attachment/' . $log_file_name . '" target="_blank">' . $log_file_name . '</a>';
					}

					echo '<tr><td>影響範囲</td><td>';
					echo '<textarea name="contents_02" placeholder="Enter your message" rows="5" ' . $PRE_TXT . '>', $contents_02, '</textarea>';
					echo '</td></tr>';

					echo '<tr><td>その他</td><td>';
					echo '<textarea name="contents_03" placeholder="Enter your message" rows="5" ' . $PRE_TXT . '>', $contents_03, '</textarea>';
					echo '</td></tr>';

					//新規問合せではない場合
					if ($index>=0) {
						echo '<tr><td>SBS回答</td><td>';
						if ($_SESSION['userinfo']['kind'] != 0) {
							echo '<textarea name="sbs_comment" placeholder="Reply message" rows="10" readonly="readonly">', $sbs_comment, '</textarea>';
						} else {
							echo '<textarea name="sbs_comment" placeholder="Reply message" rows="10">', $sbs_comment, '</textarea>';
						}
						echo '</td></tr>';

						echo '<tr><td>添付資料</td><td>';
						echo '<input type="file" name="doc_file_name" value=""><br>';
						if (!empty($doc_file_name)) {
							//まずファイルの存在を確認し、その後画像形式を確認する
							if(file_exists('./attachment/' . $doc_file_name) && exif_imagetype('./attachment/' . $doc_file_name)){
								echo '<br><img src="./attachment/' . $doc_file_name. '" alt="./attachment/'. $doc_file_name . '" width ="300">';
							}
							echo '<br><a href="./attachment/' . $doc_file_name . '" target="_blank">' . $doc_file_name . '</a>';
						}
					}

					if ($_SESSION['userinfo']['kind'] != 0 ) {
						echo '<input type="hidden" name="asana_gid" value="', $asana_gid, '" >';	//SBS管理者でデータがない場合は非表示
					} else {
						echo '<tr><td>Asana</td><td>';
						echo '<a href="https://app.asana.com/0/1172128163255929/' . $asana_gid . '" target="_blank">Asanaリンク</a>';
						echo '<input type="hidden" name="asana_gid" value="', $asana_gid, '" >';	//SBS管理者でデータがない場合は非表示
						// echo '<input type="text" name="asana_gid" value="', $asana_gid, '" ' . $PRE_TXT . '>';
						echo '</td></tr>';
					}

					echo '</table>';

					// 画面下部のボタン表示
					echo '<input type="submit" class="button big primary" value="問合せ情報更新" onclick="buttonClick()" >';

					if (isset($_SESSION['inquiry_list'])) {
						// お問合せセッション情報ある場合は一覧から遷移したため、戻るボタン表示
						echo '　';
						//戻るボタン
						if ($index<=0) {
							echo '<span class="button disabled">Prev</span>　';
					  } else {
							echo '<a class="button big" href="inquiry-form.php?index=',$index-1,'" class="button disabled">Prev</a>　';
						}
						//一覧に戻る
						echo '<a class="button big" href="inquiry-list.php?index=',$index,'"">一覧に戻る</a>　';
						//次へボタン
						if ($index==count($_SESSION['inquiry_list'])-1 or $index==-1) {
							echo '<span class="button disabled">Next</span>　';
					  } else {
							echo '<a class="button big" href="inquiry-form.php?index=',$index+1,'" class="button disabled">Next</a>　';
						}
					}

					echo '</form>';
					?>
				</section>

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
