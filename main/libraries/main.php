<?php


  // インクルード

  include 'database.php';
  include 'users.php';
  include 'plans.php';
  include 'calendars.php';


  // セッション管理

  function redirect(string $location, /*bool*/ $condition=TRUE) {

    if ($condition) {
      header("Location: $location");
      exit;
    }

  }


  // 自動実行
  session_start();


?>
