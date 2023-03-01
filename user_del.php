<?php
try{
    session_start();
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8;','training','root');
    $db->query('SET NAMES utf8;');
    
    
    if($_SESSION['del_type'] == "user_del"){
        $db_account = $db->prepare('SELECT * FROM account WHERE id = :id');
        $db_account->bindValue(':id', $_SESSION['del_user_id']);
        $db_account->execute();

        foreach($db_account as $user){
            $account = $user;
        }
        if(isset($_POST['del_ok'])){
            $db_account = $db->prepare('UPDATE account SET del = :del WHERE id = :id');
            $db_account->bindValue(':id', $_SESSION['del_user_id']);
            $db_account->bindValue(':del', "1");
            $db_account->execute();
            header('Location:/del_success.php');
        }
    }
}catch(PDOException $e){
    echo 'DB接続エラー！: ' . $e->getMessage();
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー削除確認画面</title>
    </head>
    <body>
        <h1>ユーザー削除確認画面</h1>
        <h3>下記の内容のユーザーを削除します</h3>
        <form action="" method="post">
            <p>ユーザー名</p>
            <p><?php echo htmlspecialchars($account['user_name'],ENT_QUOTES,'UTF-8'); ?></p>
            <p>パスワード</p>
            <p><?php echo htmlspecialchars($account['pw'],ENT_QUOTES,'UTF-8'); ?></p>
            <br>
            <input type="submit" name="del_ok" value="OK">
        </form>
        <button type="button" onclick="location.href='/admin.php'">戻る</button>
    </body>
</html>