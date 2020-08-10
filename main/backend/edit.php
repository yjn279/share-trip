<?php


  // インクルード

  include '../libraries/main.php';
  $plans = new Plans();


  // リダイレクト
  redirect('timeline.php', empty($_SESSION['user'] || $_GET['id'] ||$_POST['title'] || $_POST['schedule']));


  // データの取得
  
  $user = $_SESSION['user'];
  $id = $_GET['id'];
  $title = $_POST['title'];
  $schedule = $_POST['schedule'];
  $comment = $_POST['comment'];
  $file = $plans -> compress_img($_FILES['image']['tmp_name']);
  $image = file_get_contents($file);

  if (!empty($_POST['img_del'])) $img_del = $_POST['img_del'];
  
  $plan = $plans -> get_plan($id);
  $name_id = $plan['user_id'];

  if (!empty($img_del))  $image = NULL;
  elseif (empty($image)) $image = $plan['image'];


  // プランの編集
  if ($user == $name_id) $plans -> edit_plan($id, $title, $schedule, $comment, $image);


  //リダイレクト
  redirect("../plan.php?id=$id");


?>