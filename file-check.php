<?php require 'header.php'; ?>

<!-- Main -->
	<div id="main">
		<div class="inner">

				<!-- Header -->
				<?php require 'header-sub.php'; ?>

				<!-- defaultpage -->
				<section id="defaultpage">

					<?php
					 //添付ファイルバリデーション
					 function fileValidatorSize($data) {
					  //ファイルサイズの上限をMB単位で指定
					  $allowMaxSize = 2;
					  if($data['size'] < $allowMaxSize * 1000000) {
					   return false;
					  } else {
					   return true;
					  }
					 }
					 function fileValidatorType($data) {
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
					 $isErrorFileSize = fileValidatorSize($_FILES['input_file']);
					 $isErrorFileType = fileValidatorType($_FILES['input_file']);

					 //添付ファイルアップロード
					 $fileTempName = $_FILES['input_file']['tmp_name'];
					 $fileName = $_FILES['input_file']['name'];
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
					  $_SESSION['input_file'] = $attachedFile;
					 }
					?>

					<!-- 画像を確認 -->
					<form method="post" action="./thanks.php">
					 <?php if(!$uploadError && $fileType === 'image'): ?>
					  <img src="./attachment/<?php echo $attachedFile; ?>" alt="<?php echo $attachedFile; ?>">
					  <span><?php echo $attachedFile; ?></span>
					 <?php else: ?>
					  <span><?php echo $attachedFile; ?></span>
					 <?php endif; ?>
					 <input type="submit" value="送信する">
					</form>

				</section>

			</div>
		</div>

<?php require 'menu.php'; ?>
<?php require 'footer.php'; ?>
