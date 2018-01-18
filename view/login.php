<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学習内容一覧</title>
    <link rel="stylesheet" href="./conf/login.css">
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="./conf/study.js"></script>
</head>
<body>

    <header>
        <h1>学習進捗管理システム</h1>
    </header>
   <form action="./controller.php" method="POST">
        <h2>
            ログイン画面
        </h2>
        <?php
            if ($error_message) {
                print '<font color="red">'.$error_message.'</font>';
        }?>
        <div class="div">
        <p>
            <label for="loginId">ログインID</label>
            <input type="text" name="loginId" id="loginId">
        </p>
        <p>
            <label for="password">パスワード</label>
            <input type="password" name="password" id="password">
        </p>
        <p>
            <button type="submit" class="login_btn" name="login">ログイン</button>
            <button type="submit" class="usr_touroku_btn" name="usr_touroku">ユーザー登録</button>
        </p>
        </div>
        <footer><!-- フッター -->
            <small class="cpr">Copyright &copy; Study Management System All Rights Reserved.</small>
    </footer>
</body>
</html>   