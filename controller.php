<?php
// セッション開始
session_start();
// 設定ファイル読み込み
require_once './conf/const.php';
// 関数ファイル読み込み
require_once './model/model.php';
require_once './model/user_touroku_model.php';
//画面遷移
$current_page = null;
// ログインページ
$usr_data = null;
$error_message = "";
// ユーザー登録画面
$lastName = "";
$firstName = "";
$loginId = "";
$password  = "";
$passwordRe  = "";
$year = "";
$usrId = "";
$user_success = false;


//ログインページ
if (isset($_POST['login']) === TRUE) {

    $loginId = trim(htmlspecialchars($_POST['loginId'], ENT_QUOTES));
    $password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES));
    $usr_data_array = array();
    // DB接続
    $link = get_db_connect();
    // ログイン認証処理
    $usr_data_array = cert_Login($link);
    // DB切断
    close_db_connect($link);
    if(count($usr_data_array) === 0){
        $error_message = "ログインIDとパスワードが一致しません";
    } else {
        // 特殊文字をHTMLエンティティに変換
        $usr_data_array = entity_assoc_array($usr_data_array);
        $usr_data = $usr_data_array[0];
        //$current_page = TOP_PAGE;
        // セッションに設定
        $_SESSION['user_id'] = $usr_data['id'];
        $_SESSION['last_name'] = $usr_data['last_name'];
        $_SESSION['first_name'] = $usr_data['first_name'];
        $_SESSION['year_code'] = $usr_data['year_code'];
        $_SESSION['display'] = "0";
        $_SESSION['subject_id'] = "";
        // ログイン成功の場合、トップページへリダイレクト
        header('Location: http://codecamp4421.lesson5.codecamp.jp//study/top.php');
    }
        
}
if (isset($_POST['usr_touroku']) === TRUE) {
    $current_page = USER_TOUROKU_PAGE;
    
}
// ユーザー登録画面
if (isset($_POST['user_Insert']) === TRUE) {
    // 画面入力情報を保持
    $lastName = trim(htmlspecialchars($_POST['lastName'], ENT_QUOTES));
    $firstName = trim(htmlspecialchars($_POST['firstName'], ENT_QUOTES));
    $loginId = trim(htmlspecialchars($_POST['loginId'], ENT_QUOTES));
    $password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES));
    $passwordRe = trim(htmlspecialchars($_POST['passwordRe'], ENT_QUOTES));
    $year = trim(htmlspecialchars($_POST['year'], ENT_QUOTES));
    // エラーチェック
    $error_message = check_userInfo();
    if($error_message === ""){
        // DB接続
        $link = get_db_connect();
        // ログインIDチェック
        $error_message = check_LoginId($link);
        if($error_message === ""){
            // ユーザ情報を登録
            if(insert_user_table($link)){
                $user_success = true;
                $usrId = get_userId($link, $loginId);
                $error_message = '<p class="error">登録が完了しました</p>';
                //header('Location: http://codecamp4421.lesson5.codecamp.jp//study/view/user_touroku.php');
                // セッションに設定
                $_SESSION['user_id'] = $usrId;
                $_SESSION['last_name'] = $lastName;
                $_SESSION['first_name'] = $firstName;
                $_SESSION['year_code'] = $year;
                $_SESSION['display'] = "0";
                $_SESSION['subject_id'] = "";
            }
        }
 
        // DB切断
        close_db_connect($link);
    }
    $current_page = USER_TOUROKU_PAGE;
}
// ユーザー登録画面.ログインボタン押下
if (isset($_POST['user_login']) === TRUE) {
    //$current_page = TOP_PAGE;
    //トップページへリダイレクト
    header('Location: http://codecamp4421.lesson5.codecamp.jp//study/top.php');

}
// ユーザー登録画面．戻るボタン押下
if (isset($_POST['user_back']) === TRUE){
    $current_page = LOGIN_PAGE;
}

// 学習内容一覧テンプレートファイル読み込み
switch($current_page){
    case LOGIN_PAGE:
        include_once './view/login.php';
        break;
    case USER_TOUROKU_PAGE:
        include_once './view/user_touroku.php';
        break;
    case TOP_PAGE:
        include_once './top.php';
        break;
    default:
        include_once './view/login.php';
        break;
}


