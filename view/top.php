<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学習内容一覧</title>
    <link rel="stylesheet" href="./conf/study.css">
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="./conf/study.js"></script>
</head>
<body>
    <div class="sotowaku">
    <header><!-- ヘッダー -->
        <div class="personal">
            <span class="usr_name"><?php print $last_name . " " . $first_name;  ?></span>
            <?php if ($year_code == "0"){ ?>
                <span class="usr_year"><?php print "学年：なし";?></span> 
            <?php } else { ?>
                <span class="usr_year"><?php print $year_code . "学年";?></span>
            <?php } ?>
            <span class="system_date"><?php print date("Y/m/d"); ?></span>

        <form  action="./top.php" method="post">
                <button type="submit" name="logout" id="logout" class="button_logout">ログアウト</button>
        </form>
        </div>
        <form action="#" name="display" method="post">
        <ul class= "header_ul">
            <li class="header_li"><a href="#" class="header_a" id="itiran" onClick="changedisp('0');">
                <?php if($display === "0") print "<b>";?>一覧表示<?php if($display === "0") print "</b>";?></a></li>
            <li class="header_li header_li_last"><a href="#" class="header_a" id="jisseki" onClick="changedisp('1');">
                <?php if($display === "1") print "<b>";?>実績入力<?php if($display === "1") print "</b>";?></a></li>
          <!--
            <li class="header_li"><a href="#" class="header_a">学期別表示</a></li>
            <li class="header_li"><a href="#" class="header_a">月別表示</a></li>
            <li class="header_li"><a href="#" class="header_a">目標入力</a></li>
            <li class="header_li header_li_last"><a href="#" class="header_a">設定</a></li>
            -->
        </ul>
        <input type="hidden" name="display" id="display" value="<?php print $display; ?>">
        </form>
    </header>

    <nav><!-- ナビゲーション -->
        <form name="subject" method="post">
           <ul class= "nav_ul">
                <li class="nav_top_li"><h1>数学</h1></li>
                <li class="nav_li"><a href="javascript:submit('01')" class="nav_a" id="subject01">１学年</a></li>
                <li class="nav_li"><a href="javascript:submit('02')" class="nav_a" id="subject02">２学年</a></li>
                <li class="nav_li"><a href="javascript:submit('03')" class="nav_a" id="subject03">３学年</a></li>
                <li class="nav_top_li"><h1>社会</h1></li>
                <li class="nav_li"><a href="javascript:submit('11')" class="nav_a" id="subject11">地理</a></li>
                <li class="nav_li"><a href="javascript:submit('12')" class="nav_a" id="subject12">歴史</a></li>
                <li class="nav_li"><a href="javascript:submit('13')" class="nav_a" id="subject13">公民</a></a></li>
                <li class="nav_top_li"><h1>理科</h1></li>
                <li class="nav_li"><a href="javascript:submit('21')" class="nav_a" id="subject21">１学年</a></li>
                <li class="nav_li"><a href="javascript:submit('22')" class="nav_a" id="subject22">２学年</a></li>
                <li class="nav_li"><a href="javascript:submit('23')" class="nav_a" id="subject23">３学年</a></a></li>
                <li class="nav_top_li"><h1>英語</h1></li>
                <li class="nav_li"><a href="javascript:submit('31')" class="nav_a" id="subject31">１学年</a></li>
                <li class="nav_li"><a href="javascript:submit('32')" class="nav_a" id="subject32">２学年</a></li>
                <li class="nav_li"><a href="javascript:submit('33')" class="nav_a" id="subject33">３学年</a></a></li>
            </ul>
            <input type="hidden" name="subject_id" id="subject_id" value="<?php print $subject_id; ?>">
        </form>
    </nav>
    <article><!-- 記事 -->
    <form name="ins_jisseki" method="post">
    <?php if (strlen($subject_id) != 0) { ?>
      <div class="div_table">
        <table class="table_unit" id="table_unit">
            <thead class="scrollHead">
                <tr class="table_unit_thead_tr">
                    <th class="table_unit_thead_no">No</th>
                    <th class="table_unit_thead_unitName">単元名</th>
                    <?php if($display === "0"){?>
                        <th class="table_unit_thead_preStudy">前回実施日</th>
                        <th class="table_unit_thead_cntStudy">実施回数</th>
                    <?php }else if($display === "1"){ ?>
                        <th class="table_unit_thead_check"><?php print date("m/d"); ?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody class="scrollBody">
             <?php $cnt=0; ?>
             <?php foreach ($unit_data as $unit) { ?>
                <tr class="table_unit_tr">
                    <td class="table_unit_no"><?php print ++$cnt; ?></td>
                    <td class="table_unit_unitName"><?php print $unit['unit_name']; ?></td>
                    <?php if($display === "0"){?>
                        <td class="table_unit_preStudy">
                            <input type="text" class="text_preStudy" name="preStudy_<?php print $cnt; ?>" id="preStudy_<?php print $cnt; ?>"
                                value="<?php print str_replace('-', '/', $arrPreStudy[$cnt]); ?>" readOnly="true">
                        </td>
                        <td class="table_unit_cntStudy">
                            <input type="text" class="text_cntStudy" name="cntStudy_<?php print $cnt; ?>" id="cntStudy_<?php print $cnt; ?>"
                                value="<?php print $arrStudyCnt[$cnt] . " 回 "; ?>" readOnly="true">
                        </td>
                    <?php }else if($display === "1"){ ?>
                        <td class="table_unit_check"><input type="checkbox" id="check_<?php print $cnt; ?>" name="check_<?php print $cnt; ?>" ></td>
                    <?php } ?>
                </tr>
                <input type="hidden" id="unit_id_<?php print $cnt; ?>" name="unit_id_<?php print $cnt; ?>" value="">
                <input type="hidden" id="study_date_<?php print $cnt; ?>" name="study_date_<?php print $cnt; ?>" value="<?php print date("Y/m/d"); ?>">
                <input type="hidden" id="pre_check_<?php print $cnt; ?>" name="pre_check_<?php print $cnt; ?>" value="<?php print $arrPreCheck[$cnt]; ?>">
                <input type="hidden" id="ins_kbn_<?php print $cnt; ?>" name="ins_kbn_<?php print $cnt; ?>" value="">
          <?php } ?>
            </tbody>
        </table>
        </div><!-- div_table -->
        <div class="div_button">
            <?php if($display === "1"){?>    
                <p><div align="right"><input type="button" name="btn_submit" onClick="insert_Jisseki()" value="登録"></div></p>
            <?php } ?>
        </div><!-- div_button -->

    <?php } ?>
    <input type="hidden" name="user_id" value="<?php print $user_id; ?>">
    <input type="hidden" name="table_row" id="table_row" value="">
    <input type="hidden" name="ins_flag" id="ins_flag" value="">
    </form>
    </article>
        
    <footer><!-- フッター -->
     <!--
        <ul class="footer_ul">
            <li class="footer_li"><a href="#" class="footer_a">サイトマップ</a></li>
            <li class="footer_li"><a href="#" class="footer_a">プライバシーポリシー</a></li>
            <li class="footer_li"><a href="#" class="footer_a">お問い合わせ</a></li>
            <li class="footer_li footer_li_last"><a href="#" class="footer_a">ご利用ガイド</a></li>
        </ul>
            -->
        <small class="cpr">Copyright &copy; Study Management System All Rights Reserved.</small>

    </footer>
    </div><!-- sotowaku -->
</body>
</html>  