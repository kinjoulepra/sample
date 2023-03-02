<?php
    require_once "init.php";
    
    $db = DbConnect();
    $db->query('SET NAMES utf8;');
    
    if(isset($_POST['add_user_name']) && isset($_POST['add_user_pw'])){
        if($_POST['add_user_name'] !='' && !ctype_space($_POST['add_user_name'])){
            if($_POST['add_user_pw'] !='' && !ctype_space($_POST['add_user_pw'])){

                $account_all = $db->prepare('SELECT * FROM account where user_name = :user_name');
                $account_all->bindValue(':user_name', $_POST['add_user_name']);
                $account_all->execute();
                $result = $account_all->fetchAll(PDO::FETCH_ASSOC);

                if(!empty($result)){
                    $_SESSION['errors']['duplicate'] = "既に登録されている名前です";
                    header("location: add_user.php");
                    exit;
                }

            }else{
                $_SESSION['errors']['empty'] = "テキストボックスに半角スペースのみ入力されてるか、何も入力されていません。";
                header("location: add_user.php");
                exit;
            }
        }else{
            $_SESSION['errors']['empty'] = "テキストボックスに半角スペースのみ入力されてるか、何も入力されていません。";
            header("location: add_user.php");
            exit;
        }
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
        <form action="add_success.php" method="post">
            <p>ユーザー名</p>
            <p><?php echo htmlspecialchars($_POST['add_user_name'],ENT_QUOTES,'UTF-8'); ?></p>
            <p>パスワード</p>
            <p><?php echo htmlspecialchars($_POST['add_user_pw'],ENT_QUOTES,'UTF-8'); ?></p>
            <p>権限</p>
            <p><?php echo htmlspecialchars($_POST['add_user_role'],ENT_QUOTES,'UTF-8'); ?></p>
            <br>
            <input type="hidden" name="add_user_name" value=<?php echo $_POST['add_user_name']; ?>>
            <input type="hidden" name="add_user_pw" value=<?php echo $_POST['add_user_pw']; ?>>
            <input type="hidden" name="add_user_role" value=<?php echo $_POST['add_user_role']; ?>>
            <input type="submit" name="add_ok" value="OK">
        </form>
        <button type="button" onclick="location.href='/schedule/add_user.php'">戻る</button>
    </body>
</html>