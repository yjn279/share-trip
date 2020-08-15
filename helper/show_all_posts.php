<?php

  // DB接続

  $dsn = 'dsn';
  $user = 'user';
  $password = 'password';
  
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