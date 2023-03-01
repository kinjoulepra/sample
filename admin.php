<?php
    session_start();
    try{
        $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8;','training','root');
        $db->query('SET NAMES utf8;');

        $account_all = $db->prepare('SELECT * FROM account');
        $account_all->execute();
        foreach($account_all as $user){
            if($user['del'] == 0){
                $users[$user['id']] = $user;
            }
        }
        if(isset($_POST['edit_user_id'])){
            $_SESSION['edit_user_id'] = $_POST['edit_user_id'];
            header('Location:/edit.php');
        }elseif(isset($_POST['del_user_id'])){
            $_SESSION['del_user_id'] = $_POST['del_user_id'];
            $_SESSION['del_type'] = "user_del";
            header('Location:/user_del.php');
        }

        
    }catch(PDOException $e){
            echo 'DB接続エラー！: ' . $e->getMessage();
    }
?>


<HTML>
    <head>
        <meta charset="UTF-8">
        <title>ユーザー名簿</title>
    </head>
    <body>
        <h1>ユーザー名簿一覧</h1>
        <form action="/add_user.php" method="post">
            <input type="submit" value="登録">
        </form>
        <button type="button" onclick="location.href='/login.php'">戻る</button>
        <table border =10;>
            <tr>
                <th>ＩＤ</th>
                <th>ユーザー名</th>
                <th>削除</th>
            </tr>
            <?php foreach($users as $user){ ?>
                <tr>
                    <th><?php echo htmlspecialchars($user['id'],ENT_QUOTES,'UTF-8'); ?></th>
                    <th><?php echo htmlspecialchars($user['user_name'],ENT_QUOTES,'UTF-8'); ?></th>
                    <th><?php echo htmlspecialchars($user['del'],ENT_QUOTES,'UTF-8'); ?></th>
                    <th>
                        <form  action="/admin_schedule.php" method="post">
                        <input type="submit" value="スケジュール閲覧">
                        <input type="hidden" name="user_id" value=<?php echo htmlspecialchars($user['id'],ENT_QUOTES,'UTF-8'); ?>>
                        <input type="hidden" name="user_name" value=<?php echo htmlspecialchars($user['user_name'],ENT_QUOTES,'UTF-8'); ?>>
                        </form>
                    </th>
                    <th>
                        <form action="" method="post">
                        <input type="hidden" name="edit_user_id" value=<?php echo htmlspecialchars($user['id'],ENT_QUOTES,'UTF-8'); ?>>
                        <input type="submit" value="編集">
                        </form>
                    </th>
                    <th>
                        <form action="" method="post">
                        <input type="hidden" name="del_user_id" value=<?php echo htmlspecialchars($user['id'],ENT_QUOTES,'UTF-8'); ?>>
                        <input type="submit" value="削除">
                        </form>
                    </th>
                </tr>
            <?php } ?>
            </table>
    </body>
</HTML>