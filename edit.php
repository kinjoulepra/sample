<?php
try{
    session_start();
    $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8;','training','root');
    $db->query('SET NAMES utf8;');

    $db_account = $db->prepare('SELECT * FROM account WHERE id = :id');
    $db_account->bindValue(':id', $_SESSION['edit_user_id']);
    $db_account->execute();

    foreach($db_account as $user){
        $account = $user;
    }
    if(isset($_POST['edit_pw'])&&isset($_POST['now_pw'])){
        if($_POST['edit_pw'] != "" && $_POST['now_pw'] != ""){
            if($account['pw'] == $_POST['now_pw']){
                $_SESSION['edit_user_name'] = $_POST['edit_user_name'];
                $_SESSION['edit_pw'] = $_POST['edit_pw'];
                $_SESSION['id'] =$account['id'];
                $_SESSION['edit_type'] = 'user';
                header('Location:/edit_confirm.php');
            }else{
                echo "パスワードが違います";
            }
         }else{
            echo "入力してください。";
         }
    }
}catch(PDOException $e){
    echo 'DB接続エラー！: ' . $e->getMessage();
}
?>

<html>
    <head>
        <meta charset ="UTF-8">
        <title>アカウント編集</title>
    </head>
    <body>
        <h1>アカウント編集</h1>
        <button type="button" onclick="location.href='/admin.php'">戻る</button>
        <form action="" method="post">
            <p>ユーザー名</p>
            <input type="text" name="edit_user_name" value=<?php echo htmlspecialchars($account['user_name'],ENT_QUOTES,'UTF-8'); ?>>
            <p>現在のパスワード</p>
            <input type="text" name="now_pw">
            <p>新しいパスワード</p>
            <input type="text" name="edit_pw">
            <br>
            <input type="submit" value="確認">
        </form>
    </body>
</html>