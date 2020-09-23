<?php


  // DB接続

  $dsn = 'mysql:dbname=tb220145db;host=localhost';
  $user = 'tb-220145';
  $password = 'YXAzZ7AChH';

  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


  $sql = 'ALTER TABLE plans ADD profit INT UNSIGNED NOT NULL';
  $stmt = $pdo -> query($sql);

?>