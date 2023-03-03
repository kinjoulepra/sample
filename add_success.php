<?php
    require_once "init.php";
    $db = DbConnect();
    $db->query('SET NAMES utf8;');
    
    if(isset($_POST{'add_ok'})){
        $db_data = $db->prepare('INSERT INTO account(id, user_name, pw, role) VALUES (null,:user_name,:pw,:role)');
        $db_data->bindValue(':user_name', $_POST['add_user_name']);
        $db_data->bindValue(':pw', $_POST['add_user_pw']);
        $db_data->bindValue(':role', $_POST['add_user_role']);
        $db_data->execute();

    }
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>登録完了画面</title>
    </head>
    <body>
        <h1>登録完了</h1>
        <button type="button" onclick="location.href='/schedule/admin.php'">ユーザー名簿一覧</button>
    </body>
</html>