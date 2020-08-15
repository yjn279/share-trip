<?php


  // インクルード
  include __DIR__ . '/../libraries/main.php';
  include __DIR__ . '/../libraries/maps.php';
  

  // リダイレクト
  redirect('timeline.php', empty($_SESSION['user'] || $_POST['waypoints']));


  // データの取得
  $waypoints = $_POST['waypoints'];
  echo json_encode($waypoints); 

  
?>