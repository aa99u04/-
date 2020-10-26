<!DOCTYPE html>
<html lang ="ja">
    <head>
        <meta http-equiv="Content-Type"content="text/html; charset=utf-8">
    </head>
    <body>
        【投稿フォーム】
         <form method="post" action="misson_5-1-4.php">
          ユーザー名：  <input type="text" name="name" placeholder="" ><br>
          コメント　：  <input type="text" name="comment" placeholder="" value=""><br>    
          パスワード：  <input type="password" name="pass" id="password" pattern="^[a-zA-Z0-9]{4,}$"required
                        placeholder=""><br>
                        <input type="hidden" name="toukou" placeholder="" >
                        <input type="submit" name="submit" value="投稿">
        </form><br>
        
        【削除フォーム】
        <form method="post" action="misson_5-1-4.php">
          削除　　　：  <input type="number" name="delnum"   placeholder=""><br>
                        <input type="hidden" name="delname" placeholder="" >
                        <input type="submit" name="delete" value="削除">
        </form><br>
        
        【編集フォーム】
        <form method="post" action="misson_5-1-4.php">
          編集対象　：  <input type="number" name="editnum" placeholder=""><br>
          ユーザー名：  <input type="text" name="editname" placeholder="" ><br>
          コメント　：  <input type="text" name="editcomment" placeholder="" value=""><br>   
                        <input type="submit" name="edit" value="編集">
        </form><br>
        
</body>
</html>
<?php

//ブラウザにエラー表示
ini_set('display_errors',1);
error_reporting(E_ALL);

    //DB接続設定
    $dsn='mysql:dbname=tb220698db;host=localhost';
    $user = 'tb-220698';
    $password = 'LUPthhNfjJ';
    //エラーのお知らせ
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
     //テーブルの作成
    $sql = "CREATE TABLE IF NOT EXISTS toukou"
    //カラム（項目）の登録
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"//自動で登録されているナンバリング
	. "name char(32),"//半角英数32文字
	. "comment TEXT"//コメントを入れる
	.");";
	//queryに$sqlを渡す*queryで取得した値は配列で返ってくる
	$stmt = $pdo->query($sql);
	//$sql="DROP TABLE toukou";
	//$delete=$pdo->query($sql);
	
	/*$sql='SHOW TABLES';
	$results=$pdo->query($sql);
	foreach($results as $row){
	    echo $row[0];
	    echo '<br>';
	}
	echo "<hr>";*/
	
	//投稿
	if(isset($_POST['submit'])){
	    if(isset($_POST['name']) && $_POST['comment']!=null){
	     //データを渡す
	$sql=$pdo->prepare("INSERT INTO toukou(name ,comment) VALUES(:name,:comment)");
	//変数をbindparamに渡す
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$name=$_POST['name'];
	$comment=$_POST['comment'];
    $sql->execute();
	    }
	}
    //編集
    if(isset($_POST['edit'])){
        if(isset($_POST['editname']) && isset($_POST['editcomment'])!=null){
            $eid=$_POST['editnum'];
            $ename=$_POST['editname'];
            $ecomment=$_POST['editcomment'];
            
    $sql = 'UPDATE toukou SET name=:name,comment=:comment WHERE id=:id';
	//データをを渡す
	$stmt = $pdo->prepare($sql);
	
	$stmt->bindParam(':name', $ename, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $ecomment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $eid, PDO::PARAM_INT);
	//クエリを実行する
	$stmt->execute();
	
        }
    }
    //削除
    if(isset($_POST['delete'])){
        if(isset($_POST['delnum'])!=null){
    $did=$_POST['delnum'];
    $sql = 'delete from toukou where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $did, PDO::PARAM_INT);
	$stmt->execute();
        }
    }
    //テーブルのデータ抽出
    $sql="SELECT * FROM toukou";
    //テーブル全行取得
    $results=$pdo->query($sql);
    
    //全データ取得
    foreach($results as $row){
        echo "ID:".$row['id']. ' '."<br>";
        echo "ユーザー名:". $row['name'].  ' ' ;
        echo "コメント:". $row['comment'].  ' ' ."<br>";
        echo "<hr>";
    }
        ?>
<a href="misson_5-1-2.php">一覧へ</a>