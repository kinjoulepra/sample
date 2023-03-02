<?php
    function DbConnect(){
        // DBРЏС±ПоХс
        $dsn = 'mysql:dbname=test;host=localhost;charset=utf8;';
        $user = 'training';
        $password = 'root';

        try{
            return new PDO($dsn, $user, $password);
        }catch (PDOException $e){
            var_dump($e);
            exit;
        }
    }
?>