<?php
// セッション変数クリア
$_SESSION = array();
// セッション破棄
session_destroy();
header('Location: http://codecamp4421.lesson5.codecamp.jp//study/controller.php');

?>