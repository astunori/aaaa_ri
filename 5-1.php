<?php
           ///DB接続設定///
            $dsn="********";
            $user="*******";
            $password="*******";
            $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
           ///テーブル作成///
            $sql="CREATE TABLE IF NOT EXISTS board"
	        ." ("
	        . "id INT AUTO_INCREMENT PRIMARY KEY,"
	        . "name char(32),"
	        . "comment TEXT,"
	        . "pass TEXT,"
	        . "time TEXT"
	        .");";
	        $stmt=$pdo->query($sql);
	    
	        ///データ入力///
	        if(isset($_POST["submit"])&&empty($_POST["point"])){
	            $pass=$_POST["pass"];
	        if(empty($_POST["pass"])){
	            }elseif($pass==0000){
	            $sql=$pdo->prepare("INSERT INTO board (name,comment,pass,time) VALUES (:name,:comment,:pass,:time)");
              	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	            $sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	            $sql->bindParam(':pass',$pass,PDO::PARAM_STR);
	            $sql->bindParam(':time',$tim,PDO::PARAM_STR);
	            $name=$_POST["name"];
	            $comment=$_POST["comment"];
	            $tim=date("Y/m/d H:i:s");
	            $sql->execute();
	            }}
	           ///編集モード/// 
	           elseif(!empty($_POST["point"])){
	               $sql='UPDATE board SET name=:name,comment=:comment WHERE id=:id';
                   $stmt=$pdo->prepare($sql);
                   $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                   $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                   $stmt->bindParam(':id', $_POST["point"], PDO::PARAM_INT);
                   $name=$_POST["name"];
	               $comment=$_POST["comment"];
                   $stmt->execute();
	           }
	        
	       ///削除機能///
	          if(isset($_POST["delete"])){
	          $dpass=$_POST["dpass"];
	           if(empty($_POST["dnumber"])){
	            
	            }elseif($dpass==0000){
	                $id=$_POST["dnumber"];
	                $sql = 'delete from board where id=:id';
	                $stmt = $pdo->prepare($sql);
	                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	                $stmt->execute();
                }}
            
            ///編集機能/// 
              if(isset($_POST["edit"])){
             $epass=$_POST["epass"];
            if(empty($_POST["enumber"])){
                 
            }elseif($epass==0000){
                
            $id=$_POST["enumber"];
            $sql = 'SELECT * FROM board WHERE id=:id ';
            $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
            $stmt->execute();                             // ←SQLを実行する。
            $results = $stmt->fetchAll();
            foreach ($results as $row){
            $newnum=$row["id"];
            $newnam=$row["name"];
            $newcom=$row["comment"];
		    }
		    }}
		    
		    
            
	       
?>

<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>web掲示板</title>
    </head>
    <body>
        <form action="" method="post">
            【投稿フォーム】<br>
            <input type="text" name="name" placeholder="名前" value=<?php echo $newnam?>><br>
            <input type="text" name="comment" placeholder="コメント" value=<?php echo $newcom?>><br>
            <input type="hidden" name="point" value=<?php echo $newnum?>>
            <input type="text" name="pass" placeholder="パスワード"><br>
            <input type="submit" name="submit" value="送信"><br>
            【削除フォーム】<br>
            <input type="number" name="dnumber" placeholder="削除対象番号">
            <input type="submit" name="delete" value="削除"><br>
            <input type="text" name="dpass" placeholder="パスワード"><br>
            【編集フォーム】<br>
            <input type="number" name="enumber" placeholder="編集対象番号">
            <input type="submit" name="edit" value="編集"><br>
            <input type="text" name="epass" placeholder="パスワード"><br>
        </form>
    </body>
</html>    
        【投稿表示】<br>
        <?php
            ///ブラウザに表示する///
            $sql = 'SELECT * FROM board';
	        $stmt = $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
	     	echo $row['id'].',';
		    echo $row['name'].',';
		    echo $row['comment'].',';
		    echo $row['time'].",";
		    echo "<hr>";
	        }
	    ?>