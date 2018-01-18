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
        <h1>
            ユーザー登録画面
        </h1>
    <?php
        if ($error_message) {
            print '<font color="red">'.$error_message.'</font>';
        }
        if($user_success === FALSE){
    ?>
            <form action="./controller.php" name="user_Insert" method="POST">
            <p>
                <legend><strong>名前（全角）</strong></legend>
                <input  type="text" value="<?php print $lastName;?>" name="lastName" id="lastName" placeholder="姓" maxlength="50">
                <input  type="text" value="<?php print $firstName;?>" name="firstName" id="firstName" value="" placeholder="名" maxlength="50">
            </p>
            <p>
                <legend><strong>ログインID（半角英数字）</strong></legend>
                <input type="text" value="<?php print $loginId;?>" name="loginId" id="loginId" maxlength="16">
            </p>
            <p>
                <legend><strong>パスワード（半角英数字4文字）</strong></legend>
                <input type="password" value="<?php print $password;?>" name="password" id="password" maxlength="16">
            </p>
            <p>
                <legend><strong>パスワードを再入力</strong></legend>
                <input type="password" value="<?php print $passwordRe;?>" name="passwordRe" id="passwordRe" maxlength="16">
            </p>
            <p>
                <legend><strong>学年</strong></legend>
                <select name="year">
                    <option value="" selected="selected">選択してください</option>
                    <option value="0">なし</option>
                    <option value="1">１学年</option>
                    <option value="2">２学年</option>
                    <option value="3">３学年</option>
                </select>
            </p>
            <p>
                <button type="submit" name="user_Insert" class="btn_user_Insert" >登録</button>
                <button type="submit" name="user_back" class="btn_user_back" >戻る</button>
            </p>
        </form>
    <?php }else{ ?>
        <form action="./controller.php" name="user_Login" method="POST">
            <p>
                <legend><strong>名前（全角）</strong></legend>
                <?php print $lastName;?>　<?php print $firstName;?>
            </p>
            <p>
                <legend><strong>ログインID（半角英数字）</strong></legend>
                <?php print $loginId;?>
            </p>
                <legend><strong>学年</strong></legend>
                <?php switch($year){
                    case "0": print "なし"; break;
                    case "1": print "１学年"; break;
                    case "2": print "２学年"; break;
                    case "3": print "３学年"; break;
                } ?>
            <p>
                <button type="submit" name="user_login" class="login_btn">ログイン</button>
            </p>
        </form>
    <?php } ?>
    <footer><!-- フッター -->
        <small class="cpr">Copyright &copy; Study Management System All Rights Reserved.</small>
    </footer>
</body>
</html>   