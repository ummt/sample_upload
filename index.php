<?php
$message = '';

if (isset($_POST['upload'])) {
  try {
    switch ($_FILES['uploadfile']['error']) {
    case UPLOAD_ERR_OK: // エラー無
      break;
    case UPLOAD_ERR_NO_FILE:
      throw new RuntimeException('ファイルが選択されていません');
      break;
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
      throw new RuntimeException('ファイルが大きすぎます');
      break;
    default:
      throw new RuntimeException('予期しないエラー');
    }

    $tmpName = $_FILES['uploadfile']['tmp_name'];  // 一時ファイル
    $uploadFileName = $_FILES['uploadfile']['name']; // 元ファイル

    // アップロードディレクトリの確認
    $pathUpload = $_SERVER['DOCUMENT_ROOT'].'/sample_upload_files';
    if (!is_dir($pathUpload)){
      mkdir($pathUpload);
    }

    if (!is_uploaded_file($tmpName)) {
      throw new RuntimeException('HTTP POST でアップロードされたファイルではありません');
    } else {
      $saveFilePath = tempnam($pathUpload, 'up_'); // 保存ファイル
      if (!move_uploaded_file($tmpName, $saveFilePath)) {
        throw new RuntimeException('ファイル移動失敗');
      } else {
        $message = 'アップロードしました：'.$saveFilePath;
      }
    }
  } catch (RuntimeException $e) {
    $message = $e->getMessage();
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
