<!--
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
 inquiry-form-output.php
 問合せ登録・更新処理、メール送信処理、Asana登録処理
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-->

<!-- 外部ファイルを読み込む -->
<?php require_once('const.php'); ?>
<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- inquiryRegMain -->
				<section id="inquiryRegMain">
					<?php
					try{

						// if(empty($_REQUEST['inquiry_title'])) {
						//
						// }

						$CONST_ZERO = 0;
						$CONST_BLANK = '';

						// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
						// inquiryテーブル登録処理
						// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
						//最初にユーザ情報を取得
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
						}

						//パートナー向けの病院コードを取得
						$facility_code_02=$facility_name_02='';
						if (isset($_REQUEST['facility_code_02'])) {
							$txtFacility = $_REQUEST['facility_code_02'];
							$DELIM_STR = "@@";
							$stPos1 = strpos($txtFacility, $DELIM_STR);
							$stPos2 = $stPos1 + strlen($DELIM_STR);

							$facility_code_02 = substr($txtFacility, 0, $stPos1);
							$facility_name_02 = substr($txtFacility, $stPos2, strlen($txtFacility) - $stPos2);
							print '<br>' . $facility_code_02;
							print '<br>' . $facility_name_02;
						}

						//現在時刻を取得
						date_default_timezone_set('Asia/Tokyo');
						// $datetime = date("Y/m/d His");
						$datetime = date("Y-m-d H:i:s");	//mySQL時は時刻フォーマットを指定する

						//渡されたインデックス番号を取得
						$index = -1;
						if (isset($_REQUEST['index'])) {
							$index = $_REQUEST['index'];
						}

						// ファイルアップロード処理
						$fileName = fileUpload('input_file');
						$log_file_name = fileUpload('log_file_name');
						if ($index>=0) { $doc_file_name = fileUpload('doc_file_name'); }

						//メール、Asana用に問合せメッセージ内容を作成
						$title = "";
						if (!empty($_REQUEST['inquiry_title'])) { $title= "【PK-supput】" . $_REQUEST['inquiry_title']; }
						$message = "";
						// $message .= "【質問者】" . "\n" . "施設名：" . $_REQUEST['facility_name'] . "\n部署名：" . $_REQUEST['department'] . "\n担当者：" . $_REQUEST['person'] . "様\n\n";
						if (!empty($_REQUEST['order_kind'])) { $message .= "【オーダ種】" . "\n" . $_REQUEST['order_kind'] . "\n\n"; }
						if (!empty($_REQUEST['contents'])) { $message .= "【事象・内容】" . "\n" . $_REQUEST['contents'] . "\n\n"; }
						if (!empty($_REQUEST['kanja_id'])) { $message .= "【患者ID】" . "\n" . $_REQUEST['kanja_id'] . "\n\n"; }
						if (!empty($_REQUEST['hakkou_datetime'])) { $message .= "【オーダ日付】" . "\n" . $_REQUEST['hakkou_datetime'] . "\n\n"; }
						if (!empty($_REQUEST['order_no'])) { $message .= "【オーダNo】" . "\n" . $_REQUEST['order_no'] . "\n\n"; }
						if (!empty($_REQUEST['rep_process'])) { $message .= "【操作手順】" . "\n" . $_REQUEST['rep_process'] . "\n\n"; }
						if (!empty($_REQUEST['hassei_datetime'])) { $message .= "【発生日付】" . "\n" . $_REQUEST['hassei_datetime'] . "\n\n"; }
						if (!empty($_REQUEST['pc_name'])) { $message .= "【端末名】" . "\n" . $_REQUEST['pc_name'] . "\n\n"; }
						if (!empty($_REQUEST['end_user_id'])) { $message .= "【利用者ID】" . "\n" . $_REQUEST['end_user_id'] . "\n\n"; }
						if (!empty($_REQUEST['contents_02'])) { $message .= "【影響範囲】" . "\n" . $_REQUEST['contents_02'] . "\n\n"; }
						if (!empty($_REQUEST['contents_03'])) { $message .= "【その他】" . "\n" . $_REQUEST['contents_03'] . "\n\n"; }
						$sbs_comment='';
			 			if ($kind==0 && !empty($_REQUEST['sbs_comment'])) {
			 				//SBS管理者の場合はSBS回答を追加
			 				$sbs_comment = "【SBS回答】" . "\n" . $_REQUEST['sbs_comment'] . "\n\n";
			 			}
						$userInfo='';
						if ($kind!=0){
							//ユーザ・パートナーの場合は、メールヘッダーに質問者情報
							$userInfo  = MAIL_HSIGN_USER;
							$userInfo .= "【質問者】" . "\n" . "施設名：" . $facility_name . "\n部署名：" . $department . "\n担当者：" . $person . "様\n\n";
						}

						if ($index>=0) {
							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
						  // inquiry新規登録処理 UPDATE
							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

							//ファイルが新規に渡されなかった場合は、修正前のファイル名を取得
							if (empty($fileName)) {
								$fileName=$_SESSION['inquiry_list'][$index]['file_name'];
							}
							if (empty($log_file_name)) {
								$log_file_name=$_SESSION['inquiry_list'][$index]['log_file_name'];
							}
							if (empty($doc_file_name)) {
								$doc_file_name=$_SESSION['inquiry_list'][$index]['doc_file_name'];
							}

							// UPDATE文作成
							$sqltxt  = 'update inquiry set    ';
							$sqltxt .= 'update_datetime  = :update_datetime , ';
							$sqltxt .= 'step_flg         = :step_flg        , ';
							$sqltxt .= 'facility_code_02 = :facility_code_02, ';
							$sqltxt .= 'facility_name_02 = :facility_name_02, ';
							$sqltxt .= 'priority_flg     = :priority_flg    , ';
							$sqltxt .= 'inquiry_title    = :inquiry_title   , ';
							$sqltxt .= 'inquiry_kind     = :inquiry_kind    , ';
							$sqltxt .= 'order_kind       = :order_kind      , ';
							$sqltxt .= 'contents         = :contents        , ';
							$sqltxt .= 'kanja_id         = :kanja_id        , ';
							$sqltxt .= 'file_name        = :file_name       , ';
							$sqltxt .= 'hakkou_datetime  = :hakkou_datetime , ';
							$sqltxt .= 'order_no         = :order_no        , ';
							$sqltxt .= 'rep_flg          = :rep_flg         , ';
							$sqltxt .= 'rep_process      = :rep_process     , ';
							$sqltxt .= 'hassei_datetime  = :hassei_datetime , ';
							$sqltxt .= 'pc_name          = :pc_name         , ';
							$sqltxt .= 'end_user_id      = :end_user_id     , ';
							$sqltxt .= 'log_file_name    = :log_file_name   , ';
							$sqltxt .= 'contents_02      = :contents_02     , ';
							$sqltxt .= 'contents_03      = :contents_03     , ';
							$sqltxt .= 'sbs_comment      = :sbs_comment     , ';
							$sqltxt .= 'doc_file_name    = :doc_file_name     ';
							$sqltxt .= 'where inquiry_no = :inquiry_no        ';

							$sql=$pdo->prepare($sqltxt);
							$sql->bindParam(':update_datetime', $datetime, PDO::PARAM_STR);
							$sql->bindParam(':step_flg', $CONST_ZERO, PDO::PARAM_INT);
							$sql->bindParam(':facility_code_02', $facility_code_02, PDO::PARAM_STR);
							$sql->bindParam(':facility_name_02', $facility_name_02, PDO::PARAM_STR);
							$sql->bindParam(':priority_flg', $_REQUEST['priority_flg'], PDO::PARAM_INT);
							$sql->bindParam(':inquiry_title', $_REQUEST['inquiry_title'], PDO::PARAM_STR);
							$sql->bindParam(':inquiry_kind', $CONST_ZERO, PDO::PARAM_INT);
							$sql->bindParam(':order_kind', $_REQUEST['order_kind'], PDO::PARAM_STR);
							$sql->bindParam(':contents', $_REQUEST['contents'], PDO::PARAM_STR);
							$sql->bindParam(':kanja_id', $_REQUEST['kanja_id'], PDO::PARAM_STR);
							$sql->bindParam(':file_name', $fileName, PDO::PARAM_STR);
							$sql->bindParam(':hakkou_datetime', $_REQUEST['hakkou_datetime'], PDO::PARAM_STR);
							$sql->bindParam(':order_no', $_REQUEST['order_no'], PDO::PARAM_INT);
							$sql->bindParam(':rep_flg', $_REQUEST['rep_flg'], PDO::PARAM_INT);
							$sql->bindParam(':rep_process', $_REQUEST['rep_process'], PDO::PARAM_STR);
							$sql->bindParam(':hassei_datetime', $_REQUEST['hassei_datetime'], PDO::PARAM_STR);
							$sql->bindParam(':pc_name', $_REQUEST['pc_name'], PDO::PARAM_STR);
							$sql->bindParam(':end_user_id', $_REQUEST['end_user_id'], PDO::PARAM_STR);
							$sql->bindParam(':log_file_name', $log_file_name, PDO::PARAM_STR);
							$sql->bindParam(':contents_02', $_REQUEST['contents_02'], PDO::PARAM_STR);
							$sql->bindParam(':contents_03', $_REQUEST['contents_03'], PDO::PARAM_STR);
							$sql->bindParam(':sbs_comment', $_REQUEST['sbs_comment'], PDO::PARAM_STR);
							$sql->bindParam(':doc_file_name', $doc_file_name, PDO::PARAM_STR);
							$sql->bindParam(':inquiry_no', $_SESSION['inquiry_list'][$index]['inquiry_no'], PDO::PARAM_INT);

							$sql->execute();
							// 実行SQL表示
							// $sql->debugDumpParams();

							// inquiry_list配列を更新
							$_SESSION['inquiry_list'][$index]=[
								'inquiry_no'=>$_SESSION['inquiry_list'][$index]['inquiry_no'],
								'insert_datetime'=>$_SESSION['inquiry_list'][$index]['insert_datetime'],
								'update_datetime'=>$datetime,
								'step_flg'=>0,
								'user_id'=>$_SESSION['inquiry_list'][$index]['user_id'],
								'facility_code'=>$_SESSION['inquiry_list'][$index]['facility_code'],
								'facility_name'=>$_SESSION['inquiry_list'][$index]['facility_name'],
								'email'=>$_SESSION['inquiry_list'][$index]['email'],
								'department'=>$_SESSION['inquiry_list'][$index]['department'],
								'person'=>$_SESSION['inquiry_list'][$index]['person'],
								//入力内容で更新
								'facility_code_02'=>$facility_code_02,
								'facility_name_02'=>$facility_name_02,
								'priority_flg'=>$_REQUEST['priority_flg'],
								'inquiry_title'=>$_REQUEST['inquiry_title'],
								'inquiry_kind'=>0,
								'order_kind'=>$_REQUEST['order_kind'],
								'contents'=>$_REQUEST['contents'],
								'kanja_id'=>$_REQUEST['kanja_id'],
								'file_name'=>$fileName,
								'hakkou_datetime'=>$_REQUEST['hakkou_datetime'],
								'order_no'=>$_REQUEST['order_no'],
								'rep_flg'=>$_REQUEST['rep_flg'],
								'rep_process'=>$_REQUEST['rep_process'],
								'hassei_datetime'=>$_REQUEST['hassei_datetime'],
								'pc_name'=>$_REQUEST['pc_name'],
								'end_user_id'=>$_REQUEST['end_user_id'],
								'log_file_name'=>$log_file_name,
								'contents_02'=>$_REQUEST['contents_02'],
								'contents_03'=>$_REQUEST['contents_03'],
								'sbs_comment'=>$_REQUEST['sbs_comment'],
								'doc_file_name'=>$doc_file_name,
								'asana_gid'=>$_REQUEST['asana_gid']];

								//Asanaタスク更新
								if (!empty($_REQUEST['asana_gid'])) {
									// Asana側は改行コードが異なるため、複数の改行コードを変換
									$AsanaMsg = preg_replace("/\r\n|\r|\n/",'\\n', $message);
									updateAsanaTask($_REQUEST['asana_gid'], $_SESSION['inquiry_list'][$index]['inquiry_no'], $AsanaMsg, preg_replace("/\r\n|\r|\n/",'\\n', $sbs_comment));
									// echo "asana_gid:" .$_REQUEST['asana_gid'];
								}

							if ($_SESSION['userinfo']['kind'] == 0) {
								//SBS管理者
								echo '<p>SBS回答情報を更新しました。<br>';
								echo 'サポートセンターよりメールにて回答をお送りしました。</p>';
							} else {
								//ユーザ
								echo '<p>お問合せ情報を更新しました。<br>';
								echo 'サポートセンターからの回答をお待ちください。</p>';
							}
							// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
						 	// inquiry新規登録処理 UPDATE
						 	// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

						} else {
							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
						  // inquiry新規登録処理 INSERT
							// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

							// Asana側は改行コードが異なるため、複数の改行コードを変換
							$AsanaMsg = preg_replace("/\r\n|\r|\n/",'\\n', $message);
							// Asanaタスク作成
							$asana_gid = createAsanaTask($facility_name, $department, $person, $datetime, $title, $AsanaMsg);

							//INSERT文作成
							$sqltxt  = 'insert into inquiry ( ';
							$sqltxt .= 'condition_flg    , ';
							$sqltxt .= 'insert_datetime  , ';
							$sqltxt .= 'update_datetime  , ';
							$sqltxt .= 'step_flg         , ';
							$sqltxt .= 'user_id          , ';
							$sqltxt .= 'facility_code    , ';
							$sqltxt .= 'facility_name    , ';
							$sqltxt .= 'email            , ';
							$sqltxt .= 'department       , ';
							$sqltxt .= 'person           , ';
							$sqltxt .= 'facility_code_02 , ';
							$sqltxt .= 'facility_name_02 , ';
							$sqltxt .= 'priority_flg     , ';
							$sqltxt .= 'inquiry_title    , ';
							$sqltxt .= 'inquiry_kind     , ';
							$sqltxt .= 'order_kind       , ';
							$sqltxt .= 'contents         , ';
							$sqltxt .= 'kanja_id         , ';
							$sqltxt .= 'file_name        , ';
							$sqltxt .= 'hakkou_datetime  , ';
							$sqltxt .= 'order_no         , ';
							$sqltxt .= 'rep_flg          , ';
							$sqltxt .= 'rep_process      , ';
							$sqltxt .= 'hassei_datetime  , ';
							$sqltxt .= 'pc_name          , ';
							$sqltxt .= 'end_user_id      , ';
							$sqltxt .= 'log_file_name    , ';
							$sqltxt .= 'contents_02      , ';
							$sqltxt .= 'contents_03      , ';
							$sqltxt .= 'sbs_comment      , ';
							$sqltxt .= 'doc_file_name    , ';
							$sqltxt .= 'asana_gid          ';
							$sqltxt .= ' ) values ( ';
							$sqltxt .= ':condition_flg   , ';
							$sqltxt .= ':insert_datetime , ';
							$sqltxt .= ':update_datetime , ';
							$sqltxt .= ':step_flg        , ';
							$sqltxt .= ':user_id         , ';
							$sqltxt .= ':facility_code   , ';
							$sqltxt .= ':facility_name   , ';
							$sqltxt .= ':email           , ';
							$sqltxt .= ':department      , ';
							$sqltxt .= ':person          , ';
							$sqltxt .= ':facility_code_02, ';
							$sqltxt .= ':facility_name_02, ';
							$sqltxt .= ':priority_flg    , ';
							$sqltxt .= ':inquiry_title   , ';
							$sqltxt .= ':inquiry_kind    , ';
							$sqltxt .= ':order_kind      , ';
							$sqltxt .= ':contents        , ';
							$sqltxt .= ':kanja_id        , ';
							$sqltxt .= ':file_name       , ';
							$sqltxt .= ':hakkou_datetime , ';
							$sqltxt .= ':order_no        , ';
							$sqltxt .= ':rep_flg         , ';
							$sqltxt .= ':rep_process     , ';
							$sqltxt .= ':hassei_datetime , ';
							$sqltxt .= ':pc_name         , ';
							$sqltxt .= ':end_user_id     , ';
							$sqltxt .= ':log_file_name   , ';
							$sqltxt .= ':contents_02     , ';
							$sqltxt .= ':contents_03     , ';
							$sqltxt .= ':sbs_comment     , ';
							$sqltxt .= ':doc_file_name   , ';
							$sqltxt .= ':asana_gid       ) ';

							$sql=$pdo->prepare($sqltxt);
							$sql->bindParam(':condition_flg', $CONST_ZERO, PDO::PARAM_INT);
							$sql->bindParam(':insert_datetime', $datetime, PDO::PARAM_STR);
							$sql->bindParam(':update_datetime', $datetime, PDO::PARAM_STR);
							$sql->bindParam(':step_flg', $CONST_ZERO, PDO::PARAM_INT);
							$sql->bindParam(':user_id', $user_id, PDO::PARAM_STR);
							$sql->bindParam(':facility_code', $facility_code, PDO::PARAM_STR);
							$sql->bindParam(':facility_name', $facility_name, PDO::PARAM_STR);
							$sql->bindParam(':email', $email, PDO::PARAM_STR);
							$sql->bindParam(':department', $department, PDO::PARAM_STR);
							$sql->bindParam(':person', $person, PDO::PARAM_STR);
							$sql->bindParam(':facility_code_02', $facility_code_02, PDO::PARAM_STR);
							$sql->bindParam(':facility_name_02', $facility_name_02, PDO::PARAM_STR);
							$sql->bindParam(':priority_flg', $_REQUEST['priority_flg'], PDO::PARAM_INT);
							$sql->bindParam(':inquiry_title', $_REQUEST['inquiry_title'], PDO::PARAM_STR);
							$sql->bindParam(':inquiry_kind', $CONST_ZERO, PDO::PARAM_INT);
							$sql->bindParam(':order_kind', $_REQUEST['order_kind'], PDO::PARAM_STR);
							$sql->bindParam(':contents', $_REQUEST['contents'], PDO::PARAM_STR);
							$sql->bindParam(':kanja_id', $_REQUEST['kanja_id'], PDO::PARAM_STR);
							$sql->bindParam(':file_name', $fileName, PDO::PARAM_STR);
							$sql->bindParam(':hakkou_datetime', $_REQUEST['hakkou_datetime'], PDO::PARAM_STR);
							$sql->bindParam(':order_no', $_REQUEST['order_no'], PDO::PARAM_INT);
							$sql->bindParam(':rep_flg', $_REQUEST['rep_flg'], PDO::PARAM_INT);
							$sql->bindParam(':rep_process', $_REQUEST['rep_process'], PDO::PARAM_STR);
							$sql->bindParam(':hassei_datetime', $_REQUEST['hassei_datetime'], PDO::PARAM_STR);
							$sql->bindParam(':pc_name', $_REQUEST['pc_name'], PDO::PARAM_STR);
							$sql->bindParam(':end_user_id', $_REQUEST['end_user_id'], PDO::PARAM_STR);
							$sql->bindParam(':log_file_name', $log_file_name, PDO::PARAM_STR);
							$sql->bindParam(':contents_02', $_REQUEST['contents_02'], PDO::PARAM_STR);
							$sql->bindParam(':contents_03', $_REQUEST['contents_03'], PDO::PARAM_STR);
							$sql->bindParam(':sbs_comment', $CONST_BLANK, PDO::PARAM_STR);
							$sql->bindParam(':doc_file_name', $doc_file_name, PDO::PARAM_STR);
							$sql->bindParam(':asana_gid', $asana_gid, PDO::PARAM_STR);

							$sql->execute();
							// 実行SQL表示
							// $sql->debugDumpParams();

							$inquiry_no=0;
							//今登録したinquiry_noを取得（PostgreSQL）
							// $sql=$pdo->prepare('select currval(\'inquiry_seq\')');
							// $sql->execute();
							// foreach ($sql as $row) {
							// 	$inquiry_no=$row['currval'];
							// }

							//今登録したinquiry_noを取得（mySQL）
							$sql=$pdo->prepare('select last_insert_id() FROM inquiry');
							$sql->execute();
							foreach ($sql as $row) {
								$inquiry_no=$row['last_insert_id()'];
							}

							// inquiry_list配列を更新
							$_SESSION['inquiry_list'][]=[
								'inquiry_no'=>$inquiry_no,
								'insert_datetime'=>$datetime,
								'update_datetime'=>$datetime,
								'step_flg'=>0,
								'user_id'=>$user_id,
								'facility_code'=>$facility_code,
								'facility_name'=>$facility_name,
								'email'=>$email,
								'department'=>$department,
								'person'=>$person,
								//入力内容で更新
								'facility_code_02'=>$facility_code_02,
								'facility_name_02'=>$facility_name_02,
								'priority_flg'=>$_REQUEST['priority_flg'],
								'inquiry_title'=>$_REQUEST['inquiry_title'],
								'inquiry_kind'=>0,
								'order_kind'=>$_REQUEST['order_kind'],
								'contents'=>$_REQUEST['contents'],
								'kanja_id'=>$_REQUEST['kanja_id'],
								'sbs_comment'=>"",
								'file_name'=>$fileName,
								'hakkou_datetime'=>$_REQUEST['hakkou_datetime'],
								'order_no'=>$_REQUEST['order_no'],
								'rep_flg'=>$_REQUEST['rep_flg'],
								'rep_process'=>$_REQUEST['rep_process'],
								'hassei_datetime'=>$_REQUEST['hassei_datetime'],
								'pc_name'=>$_REQUEST['pc_name'],
								'end_user_id'=>$_REQUEST['end_user_id'],
								'log_file_name'=>$log_file_name,
								'contents_02'=>$_REQUEST['contents_02'],
								'contents_03'=>$_REQUEST['contents_03'],
								'sbs_comment'=>'',
								'doc_file_name'=>$doc_file_name,
								'asana_gid'=>$asana_gid];

							// 追加したデータのindex番号を取得
							$index = count($_SESSION['inquiry_list']) -1;


							// // UPDATE文
							// $sqltxt  = 'update inquiry set            ';
							// $sqltxt .= 'asana_gid        = :asana_gid ';
							// $sqltxt .= 'where inquiry_no = :inquiry_no';
							//
							// $sql=$pdo->prepare($sqltxt);
							// $sql->bindParam(':asana_gid', $asana_gid, PDO::PARAM_STR);
							// $sql->bindParam(':inquiry_no', $_SESSION['inquiry_list'][$index]['inquiry_no'], PDO::PARAM_INT);
							// $sql->execute();


							echo '<p>お問合せ情報を登録しました。<br>';
							echo 'サポートセンターからの回答をお待ちください。</p>';
							// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
						 	// inquiry新規登録処理 INSERT
						 	// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
						}
						echo '<ul class="actions">';
						echo '<li><a href="inquiry-form.php?index=',$index,'" class="button big">お問合せフォームに戻る</a></li>';
						echo '<li><a href="inquiry-list.php" class="button big">問合せ状況一覧</a></li>';
						echo '<li><a href="main.php" class="button big">ホーム</a></li>';
						echo '</ul>';
						// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
					 	// inquiryテーブル登録処理
					 	// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

					 // メール送信
					 // sendSupportMail($kind, $title, $message, $sbs_comment, $_SESSION['inquiry_list'][$index]['email'], $email, $userInfo);

					}catch (PDOException $e){
						print('Error:'.$e->getMessage());
						die();
					}

					?>
				</section>

			</div>
		</div>

		<?php
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//  メール送信
		//  @param:なし
		//  @return:なし
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function sendSupportMail($kind, $title, $message, $sbs_comment, $toMail, $fromMail, $userInfo){

			mb_language("Japanese");
			mb_internal_encoding("UTF-8");

			// KIND:0=SBS管理者、1=病院、2=パートナー企業
			if ($kind==0) {
				//管理者の場合はユーザへメールを返す
				$to = $toMail;
			} else {
				//ユーザの場合はPKSupportセンターへメール
				$to = SUPPORT_MAIL_ADDRESS;
			}

			if ($kind==0) {
				if (!empty($sbs_comment)){
					//SBS回答時は、メッセージ最後に追加
					$message .= $sbs_comment;
				}
				//SBSからユーザにメールを返す場合は、署名と結合する
				$message = MAIL_HSIGN . $message . MAIL_FSIGN;
			} else {
				//ユーザからのメールは問合せ者情報を付加
				$message = $userInfo . $message;
			}


			$headers = "From: " . $fromMail;
			// $headers = "From: PrimeKarte Supput Center";

			if(mb_send_mail($to, $title, $message, $headers))
			{
			  // echo "メール送信成功です";
			}

		}

		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//  Asanaタスク作成
		//  @param:なし
		//  @return:作成したコピータスクのgid
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function createAsanaTask($facility_name, $department, $person, $datetime, $title, $message){

			//調査依頼テンプレートのコピー
			$options = '{';
			$options .= '  "data": {';
			$options .= '    "include": [';
			$options .= '	   "projects",';
			$options .= '	   "notes",';
			$options .= '	   "assignee",';
			$options .= '	   "subtasks"';
			$options .= '    ],';
			$options .= '    "name": "' . $title . '",';
			$options .= '   "projects": [';
			$options .= '     "' . ASANA_PROJECTS_ID . '"';
			$options .= '   ],';
			$options .= '    "workspace": "' . ASANA_WORKSPACE_ID . '"';
			$options .= '  }';
			$options .= '}';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/tasks/' . ASANA_BASE_TASK . '/duplicate');
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer '. ASANA_ACCESS_TOKEN));
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $options);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);
			curl_close($ch);
			// echo print_r($response, true);

			// 作成したコピータスクのgidを取得
			$obj = json_decode($response, true);
			$new_task = $obj["data"]["new_task"]["gid"];
			// echo "<br>作成したコピータスクのgid：";
			// echo $new_task;

			// 作成したコピータスクを更新
			$options = '{';
			$options .= '  "data": {';
			$options .= '    "completed": false,';

			// カスタムフィールドのgidと、内容のgidを指定する
			$options .= '    "custom_fields": {';
			$options .= '    "1200003556141768": "1200003556141770",';			//SAS種別（医療）：調査依頼
			$options .= '    "1177655538501270": "' . $facility_name . ' ' . $department . '",';				//顧客【共通】
			$options .= '    "1175982341573097": "' . $person . '",';					//顧客担当【共通】
			$options .= '    "1179917567411173": "' . date("Y/m/d",strtotime($datetime)) . '",';	//受付日【共通】
			$options .= '    "1180045885986936": "' . date("H:i",strtotime($datetime)) . '",';				//受付時刻【共通】
			$options .= '    "1174635159480751": "1181789297671269",';			//顧客（医療）：1181789297671269
			$options .= '    "1174635022826716": "1174635022826717",';			//システム：PrimeKarte
			$options .= '    "1167053831024971": "1167053831024972",';			//タスクの進捗：開始前
			$options .= '    "1175960914725681": "' . $message . '" ';		//用件【共通】
			$options .= '    }';

			// $options .= '   "notes": "PKサポートサイトによってタスク自動作成"';
			$options .= '  }';
			$options .= '}';

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/tasks/' . $new_task);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer '. ASANA_ACCESS_TOKEN));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');		//UPDATEはPUT
			curl_setopt($ch, CURLOPT_POSTFIELDS, $options);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);
			curl_close($ch);
			// echo "<br>";
			// echo print_r($response, true);

			return $new_task;
		}
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//  Asanaタスク更新
		//  @param:なし
		//  @return:作成したコピータスクのgid
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function updateAsanaTask($asana_gid, $inquiry_no, $message, $sbs_comment){

			// 作成したコピータスクを更新
			$options = '{';
			$options .= '  "data": {';
			$options .= '    "completed": false,';

			// カスタムフィールドのgidと、内容のgidを指定する
			$options .= '    "custom_fields": {';
			$options .= '    "1175960914725681": "' . $message . '",';		//用件【共通】
			$options .= '    "1175983117605610": "' . $sbs_comment . '"';		//作業報告【共通】
			$options .= '    },';

			$options .= '   "notes": "PKサポートサイトNo.'. $inquiry_no . '"';
			$options .= '  }';
			$options .= '}';

			// echo "<br>";
			// echo print_r($options, true);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://app.asana.com/api/1.0/tasks/' . $asana_gid);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json', 'Authorization: Bearer '. ASANA_ACCESS_TOKEN));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');		//UPDATEはPUT
			curl_setopt($ch, CURLOPT_POSTFIELDS, $options);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

			$response = curl_exec($ch);
			curl_close($ch);

			// echo "<br>";
			// echo print_r($response, true);

		}

		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//  添付ファイルバリデーション
		//  @param:$data
		//  @return:Ture/False
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function fileValidatorSize2($data) {
			//ファイルサイズの上限をMB単位で指定
			$allowMaxSize = 2;
			if($data['size'] < $allowMaxSize * 1000000) {
			 return false;
			} else {
			 return true;
			}
		}

		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//  許可するファイルのMIMEタイプを指定
		//  @param:$data
		//  @return:Ture/False
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		function fileValidatorType2($data) {
			//許可するファイルのMIMEタイプを指定
			$allowFileType = array(
			 'image/jpeg',
			 'image/png',
			 'image/gif',
			 'text/plain',
			 'text/csv',
			 'application/pdf',
			 'application/zip'
			);
			if(in_array($data['type'], $allowFileType)) {
			 return false;
			} else {
			 return true;
			}
		}

		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		//  ファイルアップロード処理
		//  @param:$inputTagName inputタグの名称
		//  @return:$fileName 添付ファイル名称
		// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		 function fileUpload($inputTagName) {
			 $isErrorFileSize = fileValidatorSize2($_FILES[$inputTagName]);
			 $isErrorFileType = fileValidatorType2($_FILES[$inputTagName]);
			 // echo print_r($_FILES['input_file'], true);

			 //添付ファイルアップロード
			 $fileTempName = $_FILES[$inputTagName]['tmp_name'];
			 $fileName = $_FILES[$inputTagName]['name'];
			 $attachedFile = "";
			 $fileType = "";
			 if(!$isErrorFileSize && !$isErrorFileType) {
				if(!empty($fileTempName)) {
				 $isUploaded = move_uploaded_file($fileTempName, 'attachment/'.$fileName);
				 if($isUploaded) {
					$attachedFile = $fileName;
					if(strpos($_FILES['input_file']['type'], 'image') !== false) {
					 $fileType = 'image';
					} else {
					 $fileType = 'other';
				 }
					$uploadError = false;
				 } else {
					$uploadError = true;
				 }
				}
			 } else {
				$uploadError = true;
			 }

			 //SESSIONへ受け渡し
			 if(!$uploadError) {
				$_SESSION[$inputTagName] = $attachedFile;
			 }

			 return $fileName;
		 }
		?>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
