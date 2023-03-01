<?php
try{
    session_start();
    if(isset($_POST['add_user_name']) && isset($_POST['add_user_pw'])){
        if($_POST['add_user_name'] !='' && !ctype_space($_POST['add_user_name'])){
            if($_POST['add_user_pw'] !='' && !ctype_space($_POST['add_user_pw'])){
                $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8;','training','root');
                $db->query('SET NAMES utf8;');

                $account_all = $db->prepare('SELECT * FROM account');
                $account_all->execute();
                foreach($account_all as $user){
                    if($_POST['add_user_name'] == $user['user_name']){
                        $add_user = $user['user_name'];
                        
                    }
                }
                if(is_null($add_user)){
                    $_SESSION['add_user_name'] = $_POST['add_user_name'];
                    $_SESSION['add_user_pw'] = $_POST['add_user_pw'];
                    $_SESSION['add_user_role'] = $_POST['add_user_role'];
                    $_SESSION['add_user'] = "add_user";
                    header('Location:/add_confirm.php');
                }else{
                    echo "ユーザー名を変更してください。";
                }
            }else{
                print ('テキストボックスに半角スペースのみ入力されてるか、何も入力されていません。');
            }
        }else{
                print ('テキストボックスに半角スペースのみ入力されてるか、何も入力されていません。');
        }
    }
}catch(PDOException $e){
echo 'DB接続エラー！: ' . $e->getMessage();
}

?>

<html>
    <head>
        <meta charset ="UTF-8">
        <title>ユーザー登録</title>
    </head>
    <body>
        <h1>ユーザー登録</h1>
        <button type="button" onclick="location.href='/admin.php'">戻る</button>
        <form action="" method="post">
            <p>ユーザー名</p>
            <input type="text" name="add_user_name">
            <p>パスワード</p>
            <input type="text" name="add_user_pw">
            <p>権限</p>
            <input type="number" min="1" max="2" name="add_user_role" value=2>
            <br>
            <input type="submit" value="確認">
        </form>
    </body>
</html>