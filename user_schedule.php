<?php
    try {
        session_start();
        $db = new PDO('mysql:dbname=test;host=localhost;charset=utf8;','training','root');
        $db->query('SET NAMES utf8;');
        //日付使用する変数
        if(isset($_GET['year']) && isset($_GET['month'])){
            $get_date = $_GET['year'] . "-" . $_GET['month'] . "-01";
            $date_loopday = date('t',strtotime($get_date));
        }elseif(isset($_POST['year']) && isset($_POST['month'])){
            $post_date = $_POST['year'] . "-" . $_POST['month'] . "-01";
            $date_loopday = date('t',strtotime($post_date));
        }else{
            $date_loopday = date('t',strtotime(date("Y-m-d")));
        }

        $year = '';
        if (isset($_GET['year'])) {
            $year = $_GET['year'];
        } elseif (isset($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = date('Y');
        }
        
        $month = '';
        if (isset($_GET['month'])) {
            $month = $_GET['month'];
        } elseif (isset($_POST['month'])) {
            $month = $_POST['month'];
        } else {
            $month = date('m');
        }
        
        $day = '';
        if (isset($_GET['day'])) {
            $day = $_GET['day'];
        } elseif (isset($_POST['day'])) {
            $day = $_POST['day'];
        } else {
            $day = date('d');
        }

        //表示テーブル
        $db_data = $db->prepare('SELECT * FROM schedule WHERE id = :id and year = :year and month = :month');
        $db_data->bindValue(':id', $_SESSION['id']);
        $db_data->bindValue(':year', $year);
        $db_data->bindValue(':month', $month);
        $db_data->execute();
        $db_data = $db_data->fetchALL(PDO::FETCH_ASSOC);
        
        foreach($db_data as $record){
            $all_record[$record['day']] = $record['text'];
        }
        
        if(isset($_POST['day']) && isset($_POST['text'])){
            if($_POST['text'] != "" && !ctype_space($_POST['text'])){
                if($_SESSION['$token'] == $_POST['token']){
                    if(isset($all_record[$_POST['day']])){
                        $update_text = $all_record[$_POST['day']] . "." . $_POST['text'];
                        $db_data = $db->prepare('UPDATE schedule SET text = :text WHERE id = :id and year = :year and month = :month and day = :day');
                        $db_data->bindValue(':id', $_SESSION['id']);
                        $db_data->bindValue(':text', $update_text);
                        $db_data->bindValue(':year', $_POST['year']);
                        $db_data->bindValue(':month', $_POST['month']);
                        $db_data->bindValue(':day', $_POST['day']);
                        $db_data->execute();
                        $all_record[$_POST['day']] = $update_text;
                        
                    }else{
                        $db_data = $db->prepare('INSERT INTO schedule(id, year, month, day, text) VALUES (:id,:year,:month,:day,:text)');
                        $db_data->bindValue(':id', $_SESSION['id']);
                        $db_data->bindValue(':year', $_POST['year']);
                        $db_data->bindValue(':month', $_POST['month']);
                        $db_data->bindValue(':day', $_POST['day']);
                        $db_data->bindValue(':text', $_POST['text']);
                        $db_data->execute();
                        $all_record[$_POST['day']] = $_POST['text'];
                    }
                }
            }else{
                print ('テキストボックスに半角スペースのみ入力されてるか、何も入力されていません。');
            }
        }
        $token_byte = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token_byte);
        $_SESSION['$token'] = $token;
    
    }catch(PDOException $e){
        echo 'DB接続エラー！: ' . $e->getMessage();
    }
?>

<html>
    <head>
        <meta charset ="UTF-8">
    </head>
    <body>
        <form action="/user_schedule.php" method="GET">
            <select name="year">
                <?php for($i = 2000; $i <= 2100; $i++){
                        $select = "";
                        if($i == $year){
                            $select = 'selected';
                        }?>
                    <option value=<?php echo $i; ?> <?php echo $select; ?> ><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <select name="month">
                <?php for($i = 1; $i <= 12; $i++){
                        $select = "";
                        if ($i == $month) {
                            $select = 'selected';
                        } ?>
                    <option value=<?php echo $i; ?> <?php echo $select; ?> ><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <input type="submit" value="表示">
        </form>
        <form action="/user_schedule.php" method="POST">
            <select name="day">
                <?php for($i = 1; $i <= $date_loopday; $i++){
                        $select = "";
                        if ($i == $day) {
                            $select = 'selected';
                        } ?>
                    <option value=<?php echo $i; ?> <?php echo $select; ?> ><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <input type="text" name="text">
            <input type="hidden" name="year" value=<?php echo $year; ?>>
            <input type="hidden" name="month" value=<?php echo $month; ?>>
            <input type="hidden" name="token" value=<?php echo $token; ?>>
            <input type="submit" value="登録">
        </form>
        <table border="1">
            <tr>
                <th>日付</th>
                <th>テキスト</th>
            </tr>
            <?php for($i = 1; $i <= $date_loopday; $i++){ ?>
                <tr>
                    <th><?php echo $i ?></th>
                    <?php if(isset($all_record[$i])){ ?>
                        <th><?php echo htmlspecialchars($all_record[$i],ENT_QUOTES,'UTF-8'); ?></th>
                    <?php }else{ ?>
                        <th></th>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
    </body>
<html>