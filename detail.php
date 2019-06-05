<?php

//1. id受け取り
$id = $_GET["id"];

//2. DB接続
try{
    $pdo = new PDO('mysql:dbname=gs_db_test;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした！'.$e->getMessage());
}

//3．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_test_table WHERE id=:id");//$idではなく、バインド変数:idを使う
$stmt->bindValue(":id", $id, PDO::PARAM_INT);//DBにとって危ない文字をbindValueで排除
$status = $stmt->execute();

//4．データ表示
if ($status == false) {
    sqlError($stmt);
}
$row = $stmt->fetch();//一番上のレコードを取得する

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧に進む</a></div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="bm_update_view.php">
  <div class="jumbotron">
   <fieldset>
    <legend>書籍ブックマーク更新</legend>
        <label>書籍名　：<input type="text" name="bookname" value='<?=$row["bookname"]?>'></label><br>
        <label>書籍URL：<input type="text" name="bookurl" value='<?=$row["bookurl"]?>'></label><br>
        <label>書籍コメント:<br>
        <textArea name="bookcomment" rows="4" cols="40"><?=$row["bookcomment"]?></textArea></label><br>
        <label>年齢：<input type="text" name="age" value='<?=$row["age"]?>'></label><br>
        <input type="submit" value="更新">
        <input type="hidden" name="id" value="<?=$row["id"]?>">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->

</body>
</html>