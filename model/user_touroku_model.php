<?php
 
/**
* 入力されたユーザ情報のエラーチェックを行う
*
* @param obj $link DBハンドル
* @return $error エラーメッセージ
*/
function check_userInfo() {
    $error = "";
    $lastName = trim(htmlspecialchars($_POST['lastName'], ENT_QUOTES));
    $firstName = trim(htmlspecialchars($_POST['firstName'], ENT_QUOTES));
    $loginId = trim(htmlspecialchars($_POST['loginId'], ENT_QUOTES));
    $password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES));
    $passwordRe = trim(htmlspecialchars($_POST['passwordRe'], ENT_QUOTES));
    $year = htmlspecialchars($_POST['year'], ENT_QUOTES);
    //--------------------------------------
    //入力確認
    //--------------------------------------
    if (empty($lastName)) { $error .= '<p class="error">姓を入力してください</p>'; }
    if (empty($firstName)){ $error .= '<p class="error">名を入力してください</p>'; }
    if (empty($loginId)){ $error .= '<p class="error">ログインIDを入力してください</p>'; }
    if (empty($password)){ $error .= '<p class="error">パスワードを入力してください</p>'; }
    if (empty($passwordRe)){ $error .= '<p class="error">パスワード（再入力）を入力してください</p>'; }
    if ($year === ""){ $error .= '<p class="error">学年を選択してください</p>'; }

    if(empty($error)){
        //-------------------------------------
        //全角チェック
        //-------------------------------------
        $len = strlen($lastName);
        // UTF-8の場合は全角を3文字カウントするので「* 3」にする
        $mblen = mb_strlen($lastName, HTML_CHARACTER_SET) * 3;
        if($len != $mblen){
            $error = '<p class="error">姓は全角で入力してください</p>'; 
        }
        $len = strlen($firstName);
        // UTF-8の場合は全角を3文字カウントするので「* 3」にする
        $mblen = mb_strlen($firstName, HTML_CHARACTER_SET) * 3;
        if($len != $mblen){
            $error = '<p class="error">名は全角で入力してください</p>'; 
        }
        //-------------------------------------
        //半角英数チェック
        //-------------------------------------
        if (preg_match("/^[a-zA-Z0-9]+$/", $password)) { $password = $password; }else{
        $error = '<p class="error">パスワードに半角英数字以外が入力されています</p>'; }
        if (preg_match("/^[a-zA-Z0-9]+$/", $passwordRe)) { $passwordRe = $passwordRe; }else{
        $error = '<p class="error">パスワード(再入力)に半角英数字以外が入力されています</p>'; }
        if (preg_match("/^[a-zA-Z0-9]+$/", $loginId)) { $loginId = $loginId; }else{
        $error = '<p class="error">ログインIDに半角英数字以外が入力されています</p>'; }
        //-------------------------------------
        //文字数チェック
        //-------------------------------------
        if(mb_strlen($password) < 4){ $error = '<p class="error">パスワードは半角英数字4文字以上で入力してください</p>';  }
        //-------------------------------------
        //パスワードチェック
        //-------------------------------------
        if(strcmp($password, $passwordRe) !== 0){ $error = '<p class="error">パスワードとパスワード(再入力)が異なります</p>';  }
    }
    
    return $error;
}

/**
* ログインIDの登録済チェックを行う
*
* @param obj $link DBハンドル
* @return $error エラーメッセージ
*/
function check_LoginId($link) {
    $error = "";
    $loginId = trim(htmlspecialchars($_POST['loginId'], ENT_QUOTES));
    // SQL生成
    $sql = 'SELECT login_id FROM user_table';
    // クエリ実行
    $loginId_array = array();
    $loginId_array = get_as_array($link, $sql);
    $loginId_array = entity_assoc_array($loginId_array);
    //ログインIDの登録済チェック
    foreach($loginId_array as $id){
        if(strcmp($id["login_id"], $loginId) === 0){ 
            $error = '<p class="error">指定されたログインIDは既に登録済みです。別のログインIDを指定してください</p>';
        }
    }
    return $error;
}


/**
* ユーザー情報を登録する
*
* @param obj $link DBハンドル
* @return boolean 結果情報
*/
function insert_user_table($link) {

    $array = array(
            $_POST['lastName'],
            $_POST['firstName'],
            $_POST['loginId'],
            $_POST['password'],
            $_POST['year']
    );

    $values = null;
    foreach($array as $column) {
        if($column !== end($array)) {
            $values .= "\"". $column . "\"" . ",";
        } else {
           $values .=  "\"". $column . "\""; 
        }
    }
    // SQL生成
    $sql = 'INSERT INTO `user_table`(`last_name`, `first_name`, `login_id`, `password`, `year_code`) VALUES ('
                . $values . ")";
                
    // クエリ実行
    if (mysqli_query($link, $sql) === FALSE) {
        return false;
    }

    return true;
}

/**
* ユーザーIDを取得する
*
* @param obj $link DBハンドル
* @param login_id ログインID
* @return boolean 結果情報
*/
function get_userId($link, $login_id) {
    //ユーザーID取得
    $sql = 'SELECT id FROM user_table WHERE login_id = ' . $login_id;
                   
    // クエリ実行
    $userId_array = array();
    $userId_array = get_as_array($link, $sql);
    $userId_array = entity_assoc_array($userId_array);
    return $userId_array[0]['id'];
}