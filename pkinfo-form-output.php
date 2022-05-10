<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- pkinfoRegMain -->
				<section id="pkinfoRegMain">
					<?php
					try{
						// ファイルアップロード処理
						require 'file-upload.php';

						//現在時刻を取得
						date_default_timezone_set('Asia/Tokyo');
						// $datetime = date("Y/m/d His");
						$datetime = date("Y-m-d H:i:s");	//mySQL時は時刻フォーマットを指定する

						//渡されたインデックス番号を取得
						$index = -1;
						if (isset($_REQUEST['index'])) {
							$index = $_REQUEST['index'];
						}

						if ($index>=0) {
							// インデックス番号が渡された場合は、pkinfoテーブルをUPDATE（修正）
							$sql=$pdo->prepare('update pkinfo set update_datetime=?, kind=?, info_title=?, contents=?, str_01=?, str_02=?, str_03=?, str_04=?, str_05=?, str_06=?, str_07=?, file_name=? where pkinfo_no=?');
							$sql->execute([
								$datetime,
								$_REQUEST['kind'],
								$_REQUEST['info_title'],
								$_REQUEST['contents'],
								$_REQUEST['str_01'],
								$_REQUEST['str_02'],
								$_REQUEST['str_03'],
								$_REQUEST['str_04'],
								$_REQUEST['str_05'],
								$_REQUEST['str_06'],
								$_REQUEST['str_07'],
								$fileName,
								$_SESSION['pkinfo_list'][$index]['pkinfo_no']]);

								// pkinfo_list配列を更新
								$_SESSION['pkinfo_list'][$index]=[
									'pkinfo_no'=>$_SESSION['pkinfo_list'][$index]['pkinfo_no'],
									'insert_datetime'=>$_SESSION['pkinfo_list'][$index]['insert_datetime'],
									'update_datetime'=>$datetime,
									'kind'=>$_REQUEST['kind'],
									//入力内容で更新
									'info_title'=>$_REQUEST['info_title'],
									'contents'=>$_REQUEST['contents'],
									'str_01'=>$_REQUEST['str_01'],
									'str_02'=>$_REQUEST['str_02'],
									'str_03'=>$_REQUEST['str_03'],
									'str_04'=>$_REQUEST['str_04'],
									'str_05'=>$_REQUEST['str_05'],
									'str_06'=>$_REQUEST['str_06'],
									'str_07'=>$_REQUEST['str_07'],
									'str_08'=>'',
									'str_09'=>'',
									'str_10'=>'',
									'file_name'=>$fileName];

						} else {
							// 新規登録（PostgreSQL）
							// $sql=$pdo->prepare('insert into pkinfo (pkinfo_no,condition_flg,insert_datetime,update_datetime,step_flg,user_id,facility_code,facility_name,priority_flg,order_kind,contents,kanja_id,sbs_comment) values(nextval(\'pkinfo_seq\'),?,?,?,?,?,?,?,?,?,?,?,?)');
							// 新規登録（mySQL）
							$sql=$pdo->prepare('insert into pkinfo (condition_flg,insert_datetime,update_datetime,kind,info_title,contents,str_01,str_02,str_03,str_04,str_05,str_06,str_07,file_name) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
							$sql->execute([
								0,
								$datetime,
								$datetime,
								$_REQUEST['kind'],
								$_REQUEST['info_title'],
								$_REQUEST['contents'],
								$_REQUEST['str_01'],
								$_REQUEST['str_02'],
								$_REQUEST['str_03'],
								$_REQUEST['str_04'],
								$_REQUEST['str_05'],
								$_REQUEST['str_06'],
								$_REQUEST['str_07'],
								$fileName
								]);

							$pkinfo_no=0;
							//今登録したpkinfo_noを取得（PostgreSQL）
							// $sql=$pdo->prepare('select currval(\'pkinfo_seq\')');
							// $sql->execute();
							// foreach ($sql as $row) {
							// 	$pkinfo_no=$row['currval'];
							// }

							//今登録したpkinfo_noを取得（mySQL）
							$sql=$pdo->prepare('select last_insert_id() FROM pkinfo');
							$sql->execute();
							foreach ($sql as $row) {
								$pkinfo_no=$row['last_insert_id()'];
							}

							// お問合せセッション情報を更新
							$_SESSION['pkinfo_list'][]=[
								'pkinfo_no'=>$pkinfo_no,
								'insert_datetime'=>$datetime,
								'update_datetime'=>$datetime,
								'kind'=>$_REQUEST['kind'],
								'info_title'=>$_REQUEST['info_title'],
								'contents'=>$_REQUEST['contents'],
								'str_01'=>$_REQUEST['str_01'],
								'str_02'=>$_REQUEST['str_02'],
								'str_03'=>$_REQUEST['str_03'],
								'str_04'=>$_REQUEST['str_04'],
								'str_05'=>$_REQUEST['str_05'],
								'str_06'=>$_REQUEST['str_06'],
								'str_07'=>$_REQUEST['str_07'],
								'str_08'=>'',
								'str_09'=>'',
								'str_10'=>'',
								'file_name'=>$fileName];

							// 追加したデータのindex番号を取得
							$index = count($_SESSION['pkinfo_list']) -1;
						}
						// 入力画面に戻る
						header("location: pkinfo-form.php?index=" . $index);
						// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
					 // pkinfoテーブル登録処理
					 // <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

					}catch (PDOException $e){
						print('Error:'.$e->getMessage());
						die();
					}

					?>
				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
