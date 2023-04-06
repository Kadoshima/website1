<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <title>スーイ 免許証アップロード</title>
  </head>

  <body>

  <?php
  
    $token = $_GET['token'];

    if(empty($token)){
      echo 'アプリから実行してください';
      exit();
    }
  
  ?>

    <form action="license_save.php" method="post" enctype="multipart/form-data">
      <input type="text" name="ok" >
      <input type="file" name="upload" accept='image/*' onchange="previewImage(this);">
      <input type="submit" value="送信">
      <input type="hidden" name='token' value=<?php echo $token ?>>
    </form>

    <p>
      Preview:<br>
      <img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:60%;">
    </p>


    <script>
    function previewImage(obj)
    {
      var fileReader = new FileReader();
      fileReader.onload = (function() {
        document.getElementById('preview').src = fileReader.result;
      });
      fileReader.readAsDataURL(obj.files[0]);
    }
    </script>

  </body>
</html>