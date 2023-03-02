<?php
require_once "init.php";
?>

<html>
    <head>
        <meta charset ="UTF-8">
        <title>ユーザー登録</title>
    </head>
    <body>
        <h1>ユーザー登録</h1>
        <button type="button" onclick="location.href='/schedule/admin.php'">戻る</button>
        <form action="add_confirm.php" method="post">
            <p>ユーザー名</p>
            <input type="text" name="add_user_name">
            <p>パスワード</p>
            <input type="password" name="add_user_pw">
            <p>権限</p>
            <select name="role">
                <?php foreach(ROLES as $key => $role){ ?>
                    <option value=<?php echo $key; ?> > <?php echo $role['role']; ?></option>
                <?php } ?>
            </select>
            <br>
            <input type="submit" value="確認">
        </form>
        <?php
            if(isset($_SESSION['errors'])){
                foreach($_SESSION['errors'] as $error){
        ?>
                    <p><?php echo $error . PHP_EOL ?></p>
                <?php } ?>
        <?php } ?>
    </body>
</html>

<?php
    if(isset($_SESSION['errors'])){
        unset($_SESSION['errors']);
    }
?>