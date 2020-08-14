<?php


  // インクルード

  include '../libraries/main.php';
  $plans = new Plans();


  // リダイレクト
  redirect('timeline.php', empty($_SESSION['user'] || $_GET['id'] ||$_POST['title'] || $_POST['origin'] || $_POST['destination'] || $_POST['waypoints']));


  // データの取得
  
  $user = $_SESSION['user'];
  $id = $_GET['id'];
  $title = $_POST['title'];
  $origin = $_POST['origin'];
  $destination = $_POST['destination'];
  $waypoints = $_POST['waypoints'];
  $comment = $_POST['comment'];
  $file = $plans -> compress_img($_FILES['image']['tmp_name']);
  $image = file_get_contents($file);


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

    if (!empty($_POST['img_del'])) $img_del = $_POST['img_del'];
    
    $plan = $plans -> get_plan($id);
    $name_id = $plan['user_id'];

    if (!empty($img_del))  $image = NULL;
    elseif (empty($image)) $image = $plan['image'];


  } else {

    echo 'status: ', $routes['status'], '<br>';
    echo '<pre>' . $routes['log'] . '</pre>';
    exit;

  }


  // プランの編集
  if ($user == $name_id) $plans -> edit_plan($id, $title, $schedule, $comment, $image);


  //リダイレクト
  redirect("../plan.php?id=$id");


?>