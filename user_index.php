<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー登録</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="user_select.php">ユーザー情報一覧はこちら</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="user_insert.php">
  <div class="jumbotron">
   <fieldset>
    <legend>【ユーザー情報登録】</legend>
     <label>🔸名前：<input type="text" name="name"></label><br>
     <label>🔸ID　：<input type="text" name="lid"></label><br>
     <label>🔸PS　：<input type="text" name="lpw"></label><br>
     <label>🔸管理権限フラグ　　：<input type="text" name="kanri_flg">※0:admin 1:super admin</label><br>
     <label>🔸アクティブフラグ　：<input type="text" name="life_flg">※0:active 1:inactive</label><br>
     <br>
     <input type="submit" value="送信">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

</body>
</html>