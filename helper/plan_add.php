<?php


  // DB接続

  $dsn = '******';
  $user = '******';
  $password = '******';

  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


  $sql = 'ALTER TABLE plans ADD profit INT UNSIGNED NOT NULL';
  $stmt = $pdo -> query($sql);

?>
