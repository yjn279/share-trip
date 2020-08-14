<?php


  function routes(array $waypoints) {


    // Google Places APIからplace idを取得

    // $origin = 'ChIJUYpGCSCoAWARh1AwQZSfJH0';
    // $destination = 'ChIJUYpGCSCoAWARh1AwQZSfJH0';
    // $origin = escape($origin);  // databaseクラスをインスタンス化しないと使えない
    // $destination = escape($destination);
    
    $url_dir = 'https://maps.googleapis.com/maps/api/directions/json?';
    $key_place = 'AIzaSyBNU1cg0kV0Xh28O4ph5lDaq4sCJeK3Riw';  // 環境変数やアプリケーションのソースツリー外部に保存
    $key_dir = 'AIzaSyAGdOE2XBCbd3HLJwjTspxkMWT5AFQ1vYM';

    $url_dir .= "key=$key_dir";

    foreach ($waypoints as $index => $waypoint) {

      // $waypoint = escape($waypoint);

      $url_place = "https://maps.googleapis.com/maps/api/place/findplacefromtext/json?key=$key_place&input=$waypoint&inputtype=textquery&fields=name,place_id";
      
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
      $data = json_decode($json, true);

      if (!empty($data['candidates'])) {

        $waypoints[$index] = $data['candidates'][0]['name'];  // nameを取得
        $place = $data['candidates'][0]['place_id'];  // place idを取得

        if ($index == 0) {
          $url_dir .= "&origin=place_id:$place&waypoints=optimize:true|";
        } elseif ($index == count($waypoints)-1) {
          $url_dir = substr($url_dir, 0, -1);  // 末尾の'|'を削除
          $url_dir .= "&destination=place_id:$place";
        } else {
          $url_dir .= "place_id:$place|";
        }

      } else {
        return ['status' => -1, 'log' => $json];
      }
    }


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
    $data = json_decode($json, true);

    if (!empty($data['routes'])) {

      $copyrights = $data['routes'][0]['copyrights'];
      // $routes = $data['routes'][0]['legs'];
      $orders = $data['routes'][0]['waypoint_order'];

      $route = [];

      // ordersに従ってwaypointsをソート
      foreach ($orders as $order) {
        array_push($route, $waypoints[$order+1]);  // $waypointsにはorderとdestinationが含まれる
      }

      return ['status' => 1, 'route' => $route, 'copyrights' => $copyrights, ];

    } else {
      return ['status' => -2, 'log' => $json];
    }
  
  
  }

  
?>