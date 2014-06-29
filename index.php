<?php
$message = '';

if (isset($_POST['upload'])) {
  $tmpName = $_FILES['uploadfile']['tmp_name'];  // 一時ファイル
  $uploadFileName = $_FILES['uploadfile']['name']; // 元ファイル

  // アップロードディレクトリの確認
  $pathUpload = $_SERVER['DOCUMENT_ROOT'].'/sample_upload_files';
  if (!is_dir($pathUpload)){
    mkdir($pathUpload);
  }

  if (!is_uploaded_file($tmpName)) {
    $message = 'アップロード失敗';
  } else {
    $saveFilePath = tempnam($pathUpload, 'up_'); // 保存ファイル
    if (!move_uploaded_file($tmpName, $saveFilePath)) {
      $message = 'ファイル移動失敗';
    } else {
      $message = 'アップロードしました：'.$saveFilePath;
    }
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>sample upload</title>
</head>
<body>
<form method="post" action="index.php" enctype="multipart/form-data">
  <input type="file" name="uploadfile">
  <input type="submit" name="upload" value="アップロード">
</form>
<?php echo $message; ?>
</body>
</html>
