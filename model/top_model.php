<?php
/**
* 単元の一覧を取得する
*
* @param obj $link DBハンドル
* @return array 単元一覧配列データ
*/
function get_unit_table_list($link) {
    $id = $_SESSION['subject_id'] . "%";
    // SQL生成
    $sql = 'SELECT unit_name FROM unit_table where id like \'' . $id . '\'';
    // クエリ実行
    return get_as_array($link, $sql);
 
}

/**
* 進捗実績情報を登録する
*
* @param obj $link DBハンドル
* @param $user_id ユーザーID
* @param $unit_id 単元ID
* @param $study_date 学習実施日
* @return boolean 結果情報
*/
function insert_jisseki_table($link, $user_id, $unit_id, $study_date) {

    $array = array(
            $user_id,
            $unit_id,
            $study_date
    );

    $values = null;
    $values .= $user_id . ",";
    $values .= "\"". $unit_id . "\"" . ",";
    $values .= "'" . $study_date . "'";

    // SQL生成
    $sql = 'INSERT INTO `jisseki_table`(`user_id`, `unit_id`, `study_date`) VALUES ('
                . $values . ")";
    // クエリ実行
    if (mysqli_query($link, $sql) === FALSE) {
        return false;
    }
    
    return true;
}

/**
* 進捗実績情報を登録する
*
* @param obj $link DBハンドル
* @param $user_id ユーザーID
* @param $unit_id 単元ID
* @param $study_date 学習実施日
* @return boolean 結果情報
*/
function delete_jisseki_table($link, $user_id, $unit_id, $study_date) {
    // SQL生成
    $sql = 'DELETE FROM `jisseki_table` WHERE user_id = ' . $user_id
        . " AND unit_id = " . $unit_id . " AND study_date = '" . $study_date . "'";
    // クエリ実行
    if (mysqli_query($link, $sql) === FALSE) {
        return false;
    }
    
    return true;
}

/**
* 前回実施日を取得する
*
* @param obj $link DBハンドル
* @return array 実施日配列データ
*/
function get_preStudy_date_list($link) {
    $user_id = $_SESSION['user_id'];
    $id = $_SESSION['subject_id'] . "%";
    // SQL生成
    $sql = 'SELECT unit_id, max(study_date) as study_date FROM jisseki_table where unit_id like \''
            . $id . '\'' . ' group by unit_id';
    // クエリ実行
    return get_as_array($link, $sql);
}

/**
* 実施回数を取) || ")"得する
*
* @param obj $link DBハンドル
* @return array 実施日配列データ
*/
function get_study_count_list($link) {
    $user_id = $_SESSION['user_id'];
    $id = $_SESSION['subject_id'] . "%";
    // SQL生成
    $sql = 'SELECT unit_id, count(*) as study_cnt FROM jisseki_table where unit_id like \''
            . $id . '\'' . ' group by unit_id';
    // クエリ実行
    return get_as_array($link, $sql);
}

/**
* 配列をVIEW表示用に変換する（配列['unit_id']['$array_name']であること)
*
* @param obj $array_studyDate DBから取得した配列データ
* @param obj $array_name DBから取得した配列データの連想配列名
* @param obj $length unit_data(単元)の要素数
* @return $arrPreStudy VIEW表示用配列データ
*/
function get_disp_array($input_array, $array_name, $length) {
    $output_array = array();
    //配列はlength+1作成する（要素[0]はヘッダの為、またunit_idが**01から開始する為、要素[1]から格納する）
    for($cnt=0; $cnt <= $length; $cnt++){
        $output_array[$cnt] = "";
    }
    //DBから取得した配列データの単元IDとVIEW表示用配列の要素番号を紐づけて格納する
    foreach ($input_array as $key => $value) {
        $unit_id = ltrim(substr($value['unit_id'],-2), '0'); //unit_id 末尾2桁取得
        $hoge = $value[$array_name];
        // VIEW表示用変数を作成
        $output_array[$unit_id] = $hoge;
    }
    return $output_array;
}


/**
* 当日の実施日を取得する
*
* @param obj $link DBハンドル
* @param obj $length unit_data(単元)の要素数
* @return array 前回チェックボックス配列データ
*/
function get_current_study_date_list($link) {
    $user_id = $_SESSION['user_id'];
    $id = $_SESSION['subject_id'] . "%";
    // SQL生成
    $sql = 'SELECT unit_id, study_date as study_date FROM jisseki_table where unit_id like \''
            . $id . '\'' . ' AND study_date = current_date';
    // クエリ実行
    return get_as_array($link, $sql);
}
/**
* プレチェックボックス情報を取得する
*
* @param obj $link DBハンドル
* 
* @return $arrPreCheck プレチェックボックス配列データ
*/
function get_preCheckBox($link, $length) {
    // システム日付の実績テーブルのレコードを取得
    $array_curStudyDate = get_current_study_date_list($link);
    // プレチェックボックスを表示用配列に置き換え
    $arrPreCheck = get_disp_array($array_curStudyDate, 'study_date', $length);
    // 値があったら1、無ければ0
    for($cnt=0; $cnt < count($arrPreCheck); $cnt++){
        if($arrPreCheck[$cnt] !== ""){
            $arrPreCheck[$cnt] = 1;
        } else {
            $arrPreCheck[$cnt] = 0;
        }
    }
    return $arrPreCheck;
}