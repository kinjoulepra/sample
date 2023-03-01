<html>
    <head>
        <meta charset ="UTF-8">
    </head>
    <body>
        <form action="./schedule.php" method="post" name="myform">
            <input type="text" name="day" value=15>
            <input type="text" name="text" value="乗っ取り">
            <input type="submit" value="登録">
            <br>
        </form>
    </body>
    <script>
          alert('送信完了');
      
          //submit()でフォームの内容を送信
          document.myform.submit();
    </script>
</html>