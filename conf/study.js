var array = ["#itiran", "#jisseki"]; //一覧表示内容

// 科目リンク押下
function submit(id){
    document.forms['subject'].subject_id.value = id;
    document.forms['subject'].submit();
}
// 一覧リンク押下
function changedisp(id){
    document.forms['display'].display.value = id;
    document.forms['display'].submit();
}
// 一覧の背景色を変える
function changeBackGroundColor_disp(id){
    for(var i=0; i < array.length; i++){
        if(id === array[i]){
            //背景色を変更する
            $(array[i]).addClass("header_a_active");
        } else {
            $(array[i]).removeClass("header_a_active");
        }
    }
}
// 登録ボタン押下
function insert_Jisseki(){
    var subject_id = document.getElementById('subject_id').value; // 学年コード + 科目コード
    var table = document.getElementById('table_unit');
    // テーブル行が一覧のNo + 1で取得された為、初期値を1にしている
    for(var i=1; i < table.rows.length; i++){
        // unit_idの設定
        var unit_id_name = "unit_id_" + i;
        var unit_cnt = ('0' + i ).slice( -2 );
        var unit_id = "" + subject_id + unit_cnt;
        document.getElementById(unit_id_name).value = unit_id;
        //登録区分の設定("":変更なし　"i"：新規登録 "d"：削除)
        var check_name = "check_" + i;
        var pre_check_name = "pre_check_" + i;
        var ins_kbn_name = "ins_kbn_" + i;

        //新規登録（前：チェックなし　現：チェックあり）
        if(document.getElementById(pre_check_name).value === "0"
                && document.getElementById(check_name).checked === true){
            // 登録区分に"i"（新規登録）を設定
            document.getElementById(ins_kbn_name).value = "i";
        //削除（前：チェックあり　現：チェックなし）
        } else if(document.getElementById(pre_check_name).value === "1"
                && document.getElementById(check_name).checked === false){
            // 登録区分に"d"（削除）を設定
            document.getElementById(ins_kbn_name).value = "d";
        }
   }
   document.getElementById('table_row').value = table.rows.length;
   document.getElementById('ins_flag').value = '1';
   document.forms['ins_jisseki'].submit();
    
}
window.onload = function(){
    // 表示タブの色を変更
    if(document.forms['display'].display.value === '0'){
        changeBackGroundColor_disp('#itiran');
    }else if(document.forms['display'].display.value === '1'){
        changeBackGroundColor_disp('#jisseki');
    }
    // 科目リンクの色を変更
    if(document.forms['subject'].subject_id.value){
        var subject_name = '#subject' + document.forms['subject'].subject_id.value;
        $(subject_name).addClass("nav_a_active");
    }
    // 科目リンク押下後かチェック
    if(document.forms['display'].display.value){
        // プレチェックボックスの値をチェックボックスに反映する
        var table = document.getElementById('table_unit');
        for(var i=1; i < table.rows.length; i++){
            var element_check = document.getElementById("check_" + i);
            var element_pre_check = document.getElementById("pre_check_" + i)
            if(element_pre_check.value === "1"){
                element_check.checked = true;
            }
        }
    }
}

