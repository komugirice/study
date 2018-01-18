<?php
 
/**
* 特殊文字をHTMLエンティティに変換する
* @param str  $str 変換前文字
* @return str 変換後文字
*/
function entity_str($str) {
    return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}
 
/**
* 特殊文字をHTMLエンティティに変換する(2次元配列の値)
* @param array  $assoc_array 変換前配列
* @return array 変換後配列
*/
function entity_assoc_array($assoc_array) {
 
    foreach ($assoc_array as $key => $value) {
 
        foreach ($value as $keys => $values) {
            // 特殊文字をHTMLエンティティに変換
            $assoc_array[$key][$keys] = entity_str($values);
        }
 
    }
 
    return $assoc_array;
 
}
 
/**
* DBハンドルを取得
* @return obj $link DBハンドル
*/
function get_db_connect() {
 
    // コネクション取得
    if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
        die('error: ' . mysqli_connect_error());
    }
 
    // 文字コードセット
    mysqli_set_charset($link, DB_CHARACTER_SET);
 
    return $link;
}
 
/**
* DBとのコネクション切断
* @param obj $link DBハンドル
*/
function close_db_connect($link) {
    // 接続を閉じる
    mysqli_close($link);
}
 
/**
* クエリを実行しその結果を配列で取得する
*
* @param obj  $link DBハンドル
* @param str  $sql SQL文
* @return array 結果配列データ
*/
function get_as_array($link, $sql) {
 
    // 返却用配列
    $data = array();
 
    // クエリを実行する
    if ($result = mysqli_query($link, $sql)) {
 
        if (mysqli_num_rows($result) > 0) {
 
            // １件ずつ取り出す
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
 
        }
        // 結果セットを開放
        mysqli_free_result($result);
 
    }
 
    return $data;
 
}
/**
* ログイン認証を行う
*
* @param obj $link DBハンドル
* @return $error エラーメッセージ
*/
function cert_Login($link) {
    $loginId = trim(htmlspecialchars($_POST['loginId'], ENT_QUOTES));
    $password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES));
    // SQL生成
    $sql = 'SELECT id, last_name, first_name, year_code FROM user_table where login_id = '
            . $loginId . " AND password = " . $password;
    // クエリ実行
    return get_as_array($link, $sql);
}
