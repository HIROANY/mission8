<?php

$dateGraph = [];//日付グラフ
$bookCount = [];//冊数カウント

$php_json ="";//jsonエンコード

?>

<?php

//1.  DB接続します
try{
    $pdo = new PDO('mysql:dbname=gs_db_test;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした！'.$e->getMessage());
}

//２．データ表示SQL作成
$stmt = $pdo->prepare("SELECT * FROM gs_test_table");

$status = $stmt->execute();

//３．データ表示
$view="";
if($status==false){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("ErrorQuery".$error[2]);
}else{
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        //$resultにデータが入ってくるのでそれを活用して[html]に表示させる為の変数を作成して代入する
        $view .= "<p>---------------------------------</p>";
        $view .= "<table>";
        $view .= 
            "<tr><td>id</td><td>".$result["id"]."</td></tr>".
            "<tr><td>日付</td><td>".$result["indate"]."</td></tr>".
            "<tr><td>書籍名</td><td>".$result["bookname"]."</td></tr>".
            "<tr><td>書籍URL</td><td>".$result["bookurl"]."</td></tr>".
            "<tr><td>書籍コメント</td><td>".$result["bookcomment"]."</td></tr>".
            "<tr><td>年齢</td><td>".$result["age"]."歳"."</td></tr><br>";
        $view .= "</table>";

        //GETデータ送信リンク（更新）
        $view .= '<p>';
        $view .= '<a href = "detail.php?id='.$result["id"].'">';
        $view .= '[更新]';
        $view .= '</a>';
        $view .= ' ';

        //GETデータ送信リンク（削除）
        $view .= '<a href = "delete.php?id='.$result["id"].'">';
        $view .= '[削除]';
        $view .= '</a>';
        $view .= '</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>フリーアンケート表示</title>
<link rel="stylesheet" href="css/range.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.anychart.com/js/latest/anychart-bundle.min.js"></script>
<style>div{font-size:16px;}</style>
</head>
<body id="main">

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">データ登録に戻る</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div align="center">
    <h2>データ一覧（全データ表示）</h2>
    
    <table>
        <tr>
        <td>
        <form method="post" action="sort_desc.php">
        <input type="submit" name="descending" value="登録日付昇順に並び替え">
        </form>
        </td>

        <td>
        <form method="post" action="sort_asc.php">
        <input type="submit" name="ascending" value="登録日付降順に並び替え">
        </form>
        </td>
        </tr>
    </table>
</div>
    <div class="container jumbotron" id="container"></div>
    <div class="container jumbotron"><?=$view?></div>
<!-- Main[End] -->

<?php

//1.  DB接続します
try{
    $pdo = new PDO('mysql:dbname=gs_db_test;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
    exit('データベースに接続できませんでした！'.$e->getMessage());
}

//２．データ表示SQL作成
$stmt = $pdo->prepare("SELECT * , count(*) from gs_test_table GROUP by sdate;");

$status = $stmt->execute();

//３．データ表示
if($status==false){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt2->errorInfo();
    exit("ErrorQuery".$error[2]);
}else{
    //Selectデータの数だけ自動でループしてくれる
    //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
    while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
        $dateGraph[] = $result["sdate"];
        $bookCount[] = $result["count(*)"];
    }
        //PHPからJavascriptにデータを渡すためにjsonエンコード
        $php_json1 = json_encode($dateGraph);
        $php_json2 = json_encode($bookCount);
}
?>

<script>

let chart_array = [];

//jsonにエンコードした配列をjsの配列に代入
let js_array1 = <?php echo $php_json1; ?>;
let js_array2 = <?php echo $php_json2; ?>;

//上記2つの配列を1つにまとめる
for(i=0;i<=js_array1.length-1;i++){

chart_array[i] = [js_array1[i], js_array2[i]];

}

//日付ごとの登録冊数を棒グラフ化する
anychart.onDocumentLoad(function() {
  // create a chart and set the data
  let chart = anychart.column(chart_array);
  // set chart title
  chart.title("登録日付・登録冊数グラフ");
  // set chart container and draw
  chart.container("container").draw();
});

</script>

</body>
</html>