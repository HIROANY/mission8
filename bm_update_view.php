<?php

//1. detail.phpから送られてきたデータを変数で受け取る
$bookname = $_POST["bookname"];
$bookurl = $_POST["bookurl"];
$bookcomment = $_POST["bookcomment"];
$age = $_POST["age"];
$id = $_POST["id"];

//2. DB接続します
try{
    $pdo = new PDO('mysql:dbname=gs_db_test;charset=utf8;host=localhost','root','');
} catch (PDOException $e){
    exit('データベースに接続できませんでした！'.$e->getMessage());
}

//３．データ更新SQL作成
$sql = "UPDATE gs_test_table SET bookname=:bookname, bookurl=:bookurl, bookcomment=:bookcomment, age=:age WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':bookname', $bookname, PDO::PARAM_STR);
$stmt->bindValue(':bookurl', $bookurl, PDO::PARAM_STR);
$stmt->bindValue(':bookcomment', $bookcomment, PDO::PARAM_STR);
$stmt->bindValue(':age', $age, PDO::PARAM_INT);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sqlError($stmt);
} else {
    //５．index.phpへリダイレクト
    header("Location: select.php");
    exit;
    //redirect("select.php");
}

?>
