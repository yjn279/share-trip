


<?php


  // インクルード
  include '../libraries/main.php';
  $calendars = new Calendars();


  // リダイレクト
  redirect('timeline.php', empty($_SESSION['user'] || $_GET['id'] || $_POST['from'] || $_POST['to']));


  // データの取得
  $user = $_SESSION['user'];
  $plan = $_GET['plan'];
  $from = $_POST['from'];
  $to = $_POST['to'];



  $id = $calendars -> add($user, $plan, $from, $to);



  // リダイレクト
  redirect('../mycalendar.php');


?>