<?php

//1. select.phpから送られてきたidを変数で受け取る
$id = $_GET["id"];

//2. DB接続します
try{
    $pdo = new PDO('mysql:dbname=gs_db_test;charset=utf8;host=localhost','root','');
} catch (PDOException $e){
    exit('データベースに接続できませんでした！'.$e->getMessage());
}

//3．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM gs_test_table WHERE id=:id");//$idではなく、バインド変数:idを使う
$stmt->bindValue(":id", $id, PDO::PARAM_INT);//DBにとって危ない文字をbindValueで排除
$status = $stmt->execute();

//4．データ削除
if ($status == false) {
    sqlError($stmt);
} else {
    //５．index.phpへリダイレクト　この処理がないと画面が切り替わらない
    header("Location: select.php");
}

?>