<?php
    require_once "init.php";


    $db = DbConnect();
    $db->query('SET NAMES utf8;');

    if(isset($_SESSION['loggin_id'])){
        $db_account = $db->prepare('SELECT * FROM account WHERE id = :id');
        $db_account->bindValue(':id', $_SESSION['loggin_id']);
        $db_account->execute();
        foreach($db_account as $user){
            if($user['del'] == 0){
                $account = $user;
            }
        }
        if(isset($account)){
            $_SESSION['loggin_id'] = $account['id'];
            if($account['role'] == 1){
                header('Location:/schedule/admin.php');
                exit;
            }elseif($account['role'] == 2){
                header('Location:/schedule/user_schedule.php');
                exit;
            }
        }
    }else{
        if(isset($_POST['user_name']) && isset($_POST['pw'])){
            if($_POST['pw'] !='' && !ctype_space($_POST['pw'])){
                $db_account = $db->prepare('SELECT * FROM account WHERE user_name = :user_name and pw = :pw');
                $db_account->bindValue(':user_name', $_POST['user_name']);
                $db_account->bindValue(':pw', $_POST['pw']);
                $db_account->execute();

                foreach($db_account as $user){
                    if($user['del'] == 0){
                        $account = $user;
                    }
                }
                if(isset($account)){
                    $_SESSION['loggin_id'] = $account['id'];
                    if($account['role'] == 1){
                        header('Location:/schedule/admin.php');
                        exit;
                    }elseif($account['role'] == 2){
                        header('Location:/schedule/user_schedule.php');
                        exit;
                    }else{
                        echo "「ユーザー名」もしくは「パスワード」が間違っています。";
                    }
                }else{
                    echo "「ユーザー名」もしくは「パスワード」が間違っています。";
                }
            }else{
                echo "「ユーザー名」もしくは「パスワード」に半角スペースのみ入力されてるか、何も入力されていません。";
            }
        }
    }
?>


<HTML>
    <head>
        <meta charset="UTF-8">
        <title>ログイン画面</title>
    </head>
    <body>
        <h1>ログイン画面</h1>
        <form action="" method="post">
            <a>ユーザー名：</a>
            <input type="text" name="user_name">
            <br>
            <a>パスワード：</a>
            <input type="text" name="pw">
            <br>
            <input type="submit" value="ログイン">
        </form>
    </body>
</HTML>