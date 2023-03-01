<?php
try{
    session_start();
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8;','training','root');
    $db->query('SET NAMES utf8;');
    $db_account = $db->prepare('SELECT * FROM account');
    $db_account->execute();
    foreach($db_account as $user){
        if($_SESSION['edit_user_name'] == $user['user_name']){
            $account = $user['user_name'];
        }
    }

    
    if($_SESSION['edit_type'] == 'user'){
        if($_SESSION['edit_user_name'] != $account){
           if(isset($_POST['edit_ok'])){
                    $db_account = $db->prepare('UPDATE account SET user_name = :user_name , pw = :pw WHERE id = :id');
                    $db_account->bindValue(':id', $_SESSION['id']);
                    $db_account->bindValue(':user_name', $_SESSION['edit_user_name']);
                    $db_account->bindValue(':pw', $_SESSION['edit_pw']);
                    $db_account->execute();
                    header('Location:/edit_success.php');
            }
        }
    }
}catch(PDOException $e){
    echo 'DB接続エラー！: ' . $e->getMessage();
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>編集確認画面</title>
    </head>
    <body>
        <?php if($_SESSION['edit_user_name'] != $account){?>
            <h1>編集確認画面</h1>
            <h3>下記の内容で編集します</h3>
        <?php }else{ ?>
            <h1>編集確認画面</h1>
            <h3>既に使用されてるユーザー名です。</h3>
        <?php } ?>
        <form action="" method="post">
            <p>ユーザー名</p>
            <p><?php echo htmlspecialchars($_SESSION['edit_user_name'],ENT_QUOTES,'UTF-8'); ?></p>
            <p>パスワード</p>
            <p><?php echo htmlspecialchars($_SESSION['edit_pw'],ENT_QUOTES,'UTF-8'); ?></p>
            <br>
            <?php if($_SESSION['edit_user_name'] != $account){?>
                <input type="submit" name="edit_ok" value="OK">
            <?php } ?>
        </form>
        <button type="button" onclick="location.href='/edit.php'">戻る</button>
    </body>
</html>