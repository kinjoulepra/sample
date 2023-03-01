<?php
try{
    session_start();
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8;','training','root');
    $db->query('SET NAMES utf8;');
    
    
    if($_SESSION['add_user'] == "add_user" && isset($_POST{'add_ok'})){
        $db_data = $db->prepare('INSERT INTO account(id, user_name, pw, del, role) VALUES (:id,:user_name,:pw,:del,:role)');
        $db_data->bindValue(':id',"");
        $db_data->bindValue(':user_name', $_SESSION['add_user_name']);
        $db_data->bindValue(':pw', $_SESSION['add_user_pw']);
        $db_data->bindValue(':del',"0");
        $db_data->bindValue(':role', $_SESSION['add_user_role']);
        $db_data->execute();
        header('Location:/add_success.php');

    }
}catch(PDOException $e){
    echo 'DB接続エラー！: ' . $e->getMessage();
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>登録確認画面</title>
    </head>
    <body>
        <h1>登録確認画面</h1>
        <h3>下記の内容で登録します</h3>
        <form action="" method="post">
            <p>ユーザー名</p>
            <p><?php echo htmlspecialchars($_SESSION['add_user_name'],ENT_QUOTES,'UTF-8'); ?></p>
            <p>パスワード</p>
            <p><?php echo htmlspecialchars($_SESSION['add_user_pw'],ENT_QUOTES,'UTF-8'); ?></p>
            <p>権限</p>
            <p><?php echo htmlspecialchars($_SESSION['add_user_role'],ENT_QUOTES,'UTF-8'); ?></p>
            <br>
            <input type="submit" name="add_ok" value="OK">
        </form>
        <button type="button" onclick="location.href='/add_user.php'">戻る</button>
    </body>
</html>