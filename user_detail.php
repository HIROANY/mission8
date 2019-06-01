<?php

//1. id受け取り
$id = $_GET["id"];

//2. DB接続
include "funcs.php";
$pdo = db_con();

//3．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id");//$idではなく、バインド変数:idを使う
$stmt->bindValue(":id", $id, PDO::PARAM_INT);//DBにとって危ない文字をbindValueで排除
$status = $stmt->execute();

//4．データ表示
$view = "";
if ($status == false) {
    sqlError($stmt);
}
$row = $stmt->fetch();//一番上のレコードを取得する

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー情報更新</title>
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
<form method="post" action="user_update.php">
  <div class="jumbotron">
   <fieldset>
    <legend>【ユーザー情報更新】</legend>
     <label>🔸名前：<input type="text" name="name" value="<?=$row["name"]?>"></label><br>
     <label>🔸ID　：<input type="text" name="lid" value="<?=$row["lid"]?>"></label><br>
     <label>🔸PS　：<input type="text" name="lpw" value="<?=$row["lpw"]?>"></label><br>
     <label>🔸管理権限フラグ　：<input type="text" name="kanri_flg" value="<?=$row["kanri_flg"]?>"></label><br>
     <label>🔸アクティブフラグ：<input type="text" name="life_flg" value="<?=$row["life_flg"]?>"></label><br>
     <input type="submit" value="更新">
     <input type="hidden" name="id" value="<?=$row["id"]?>">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

</body>
</html>
