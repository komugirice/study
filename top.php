<?php
// セッション開始
session_start();
// 設定ファイル読み込み
require_once './conf/const.php';
// 関数ファイル読み込み
require_once './model/model.php';
require_once './model/top_model.php';

$user_id = "";
$last_name = "";
$first_name = "";
$year_code = "";
$display = "";
$subject_id = "";
// セッション変数から個人情報を取得
$user_id = $_SESSION['user_id'];
$last_name = $_SESSION['last_name'];
$first_name = $_SESSION['first_name'];
$year_code = $_SESSION['year_code'];
// SQLテーブル取得変数
$unit_data = array();       // 単元名
$array_studyDate = null;// 前回実施日
$arrPreStudy = null;
$array_studyCnt = null;  // 実施回数
$arrStudyCnt = null;
$arrPreCheck = null; // プレチェックボックス

//ユニットID設定
if (isset($_POST['subject_id']) === TRUE){
    if ($_POST['subject_id'] !== $_SESSION['subject_id']){
        $_SESSION['subject_id'] = $_POST['subject_id'];
    }
}
//科目リンク押下
if(strlen($_SESSION['subject_id']) != 0){
    // DB接続
    $link = get_db_connect();
 
    // 学習内容の一覧を取得
    $unit_data = get_unit_table_list($link);
    // 特殊文字をHTMLエンティティに変換
    $unit_data = entity_assoc_array($unit_data);
    
    // 前回実施日を取得
    $array_studyDate = get_preStudy_date_list($link);
    // 特殊文字をHTMLエンティティに変換
    $array_studyDate = entity_assoc_array($array_studyDate);
    // 前回実施日を表示用配列に置き換え
    $arrPreStudy = get_disp_array($array_studyDate, 'study_date', count($unit_data));
    
    // 実施回数を取得
    $array_studyCnt = get_study_count_list($link);
    // 前回実施日を表示用配列に置き換え
    $arrStudyCnt = get_disp_array($array_studyCnt, 'study_cnt', count($unit_data));
    
    // プレチェックボックスを取得（システム日付の実績テーブルのレコード）
    $arrPreCheck = get_preCheckBox($link, count($unit_data));
    
    // DB切断
    close_db_connect($link);

    
}
//view呼び出し時に必ず渡す情報（科目ID）
$subject_id = $_SESSION['subject_id'];

//表示リンク押下
if (isset($_POST['display']) === TRUE){
    if ($_POST['display'] !== $_SESSION['display']){
        $_SESSION['display'] = $_POST['display'];

    }

}
//view呼び出し時に必ず渡す情報（表示種別）
$display = $_SESSION['display'];

//登録ボタン押下
if (isset($_POST['ins_flag']) === TRUE){
    // DB接続
    $link = get_db_connect();
    //テーブルの行数分ループ
    $table_row = $_POST['table_row'];
    for($cnt = 1; $cnt < $table_row; $cnt++){
        $ins_kbn = $_POST['ins_kbn_' . $cnt];
        $unit_id = $_POST['unit_id_' . $cnt];
        // DATE型は"y-m-d"へフォーマットを変換する必要がある
        $study_date = date('Y-m-d', strtotime($_POST['study_date_' . $cnt]));
        // 登録区分判定
        if($ins_kbn === JISSEKI_INSERT){
            //登録クエリ
            $jisseki_success = insert_jisseki_table($link
                                , $_SESSION['user_id'],  $unit_id, $study_date);
            if(!$jisseki_success){
                print "失敗";
            }
        } else if($ins_kbn === JISSEKI_DELETE){
            //削除クエリ
            $jisseki_success = delete_jisseki_table($link
                , $_SESSION['user_id'],  $unit_id, $study_date);
            if(!$jisseki_success){
                print "失敗";
            }
        }
    }
    // プレチェックボックスを更新
    $arrPreCheck = get_preCheckBox($link, count($unit_data));
    // DB切断
    close_db_connect($link);
}
// ログアウトボタン押下
if (isset($_POST['logout']) === TRUE){
        header('Location: http://codecamp4421.lesson5.codecamp.jp//study/logout.php');
}

// 学習内容一覧テンプレートファイル読み込み
include_once './view/top.php';




