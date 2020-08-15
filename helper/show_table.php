<?php

  // DB接続

  $dsn = 'dsn';
  $user = 'user';
  $password = 'password';
  
  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


  // テーブル詳細表示

  $sql = 'SHOW CREATE TABLE users';
  $result = $pdo -> query($sql);
  
	foreach ($result as $row){
		echo $row[1], '<br>';
  }


?>