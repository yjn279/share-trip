<?php


  // インクルード

  include '../libraries/main.php';
  include '../libraries/maps.php';
  $plans = new Plans();


  // リダイレクト

  redirect('timeline.php', empty($_SESSION['user'] || $_POST['title'] || $_POST['origin'] || $_POST['destination'] || $_POST['waypoints']));


  // データの取得

  $user = $_SESSION['user'];
  $title = $_POST['title'];
  $origin = $_POST['origin'];
  $destination = $_POST['destination'];
  $waypoints = $_POST['waypoints'];
  $comment = $_POST['comment'];


  // ルートの取得

  $routes = routes($origin, $destination, $waypoints);

  if ($routes['status'] > 0) {

    $route = $routes['route'];
    $copyrights = $routes['copyrights'];  // 表示させる
    $schedule = '';
  
    foreach ($route as $place) {
      $schedule .= $place . ' > ';
    }
  
    $schedule = substr($schedule, 0, -3);  // 最後の > を削除



    if (!empty($_GET['id'])) {

      $id = $_GET['id'];

      $plan = $plans -> get_plan($id);
      $image = $plan['image'];


    } elseif (!empty($_FILES['image']['tmp_name'])) {

      $file = $plans -> compress_img($_FILES['image']['tmp_name']);
      $image = file_get_contents($file);

    }

    if (!empty($img_del))  $image = NULL;


  } else {

    echo 'status: ', $routes['status'], '<br>';
    echo '<pre>' . $routes['log'] . '</pre>';
    exit;

  }



  // プランの登録
  $id = $plans -> make_plan($user, $title, $schedule, $comment, $image);

  
  // リダイレクト
  redirect("../plan.php?id=$id");


?>