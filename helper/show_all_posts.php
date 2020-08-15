<?php

  // DB接続

  $dsn = 'mysql:dbname=tb220145db;host=localhost';
  $user = 'tb-220145';
  $password = 'YXAzZ7AChH';
  
  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


  // 投稿表示

  $sql = 'SELECT * FROM users';

  $stmt = $pdo -> query($sql);
  $results = $stmt -> fetchAll();

  var_dump($results);

  foreach ($results as $result) {
    foreach ($result as $r) {
      echo $r, ',';
    }
    echo '<br>';
  }


?>