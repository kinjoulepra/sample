<?php
try{
        session_start();
        session_destroy();
    }catch(PDOException $e){
    echo 'DB接続エラー！: ' . $e->getMessage();
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>削除完了画面</title>
    </head>
    <body>
        <h1>削除完了</h1>
        <button type="button" onclick="location.href='/admin.php'">ユーザー名簿一覧</button>
    </body>
</html>