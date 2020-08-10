<?php


  // インクルード
  include '../libraries/main.php';
  
  
  // Google Places APIからplace idを取得

  $origin = 'ChIJUYpGCSCoAWARh1AwQZSfJH0';
  $destination = 'ChIJUYpGCSCoAWARh1AwQZSfJH0';
  $waypoints = ['清水寺', '金閣寺', '嵐山'];
  
  $url_dir = 'https://maps.googleapis.com/maps/api/directions/json?';
  $key_place = 'AIzaSyBNU1cg0kV0Xh28O4ph5lDaq4sCJeK3Riw';  // 環境変数やアプリケーションのソースツリー外部に保存
  $key_dir = 'AIzaSyAGdOE2XBCbd3HLJwjTspxkMWT5AFQ1vYM';

  $url_dir .= "key=$key_dir&origin=place_id:$origin&destination=place_id:$destination&waypoints=optimize:true|";

  foreach ($waypoints as $waypoint) {

    $url_place = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?input=$waypoint&inputtype=textquery&key=$key_place";
    
    // $json = file_get_contents($url);

    // サーバー上で file_get_contents の allow_url_fopen が0になっているため、cURLで代替
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url_place);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $json = curl_exec($ch);
    curl_close($ch);

    // $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');  // 文字化け防止
    $json = json_decode($json, true);

    if (!empty($json['candidates'])) {

      $place = $json['candidates'][0]['place_id'];  // place idを取得
      $url_dir .= "place_id:$place|";

    } else {
      echo 'error';
    break;
    }
  }

  $url_dir = substr($url_dir, 0, -1);  // 末尾の'|'を削除
  // redirect($url_dir);


  // Google Directions APIから経路を取得

  // $json = file_get_contents($url);

  // サーバー上で file_get_contents の allow_url_fopen が0になっているため、cURLで代替
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url_dir);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  $json = curl_exec($ch);
  curl_close($ch);

  // $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');  // 文字化け防止
  $json = json_decode($json, true);

  if (!empty($json['routes'])) {

    $copyrights = $json['routes'][0]['copyrights'];
    // $routes = $json['routes'][0]['legs'];
    $orders = $json['routes'][0]['waypoint_order'];

    echo $copyrights, '<br>';

    $route = [];

    // ordersに従ってwaypointsをソート
    foreach ($orders as $order) {
      array_push($route, $waypoints[$order]);
    }

    var_dump($route);

  } else {
    echo 'error';
  }


?>