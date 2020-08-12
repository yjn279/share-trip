<?php


  // インクルード  

  include 'database.php';
  include 'users.php';
  include 'plans.php';


  // セッション管理

  function redirect(string $location, /*bool*/ $condition=TRUE) {
    
    if ($condition) {
      header("Location: $location");
      exit;
    }
    
  }


  // エラー表示

  function message() {
    if(isset($_SESSION['message'])) {

      echo "<p>{$_SESSION['message']}</p>";
      unset($_SESSION['message']);

    }
  }
  

  // 自動実行
  session_start();


?>