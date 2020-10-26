<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type"content="text/html; charset=utf-8">
    <title>投稿データ</title>   
</head>
<body>
<?php
//ブラウザにエラー表示
ini_set('display_errors',1);
error_reporting(E_ALL);

    //データベース名、ユーザー名、パスワード
    $dsn='データ';
    $user = 'ユーザー';
    $password = 'パスワード';
    
    //データベース接続
    $pdo= new PDO($dsn, $user, $password);
    
    //テーブルのデータ抽出
    $sql="SELECT * FROM toukou";
    //テーブル全行取得
    $results=$pdo->query($sql);
    
    //全データ取得
    foreach($results as $row){
        echo "ID:".$row['id']. ' '."<br>";
        echo "ユーザー名:". $row['name'].  ' ' ;
        echo "コメント:". $row['comment'].  ' ' ."<br>";
    
        echo "<form action=misson_5-1-2.php method=post>"
             ."<input type='hidden' name='id' value=".$row['id'].">"
             ."<input type='submit' name='delete' value='削除'>"
             ."</form>";
    
        echo "<form action=misson_5-1-3.php method=post>"
             ."<input type='hidden' name='id' value=".$row['id'].">"
             ."<input type='submit' name='edit' value='編集'>"
             ."</form>";
    echo "<hr>";    
    }
    
    
    if(isset($_POST['delete'])){
        
        $row['id']=$_POST['id'];
	    $sql = 'delete from toukou where id=:id';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
	    $stmt->execute();
    }
    
    
?>
<a href="misson_5-1-4.php">フォームへ</a>
</body>
</html>