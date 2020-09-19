<?php


  // DB接続

  $dsn = 'mysql:dbname=tb220145db;host=localhost';
  $user = 'tb-220145';
  $password = 'YXAzZ7AChH';

  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


  // テーブルの削除

  $table = 'cost';
  $sql ="DROP TABLE $table";
  $result = $pdo -> query($sql);


  // テーブル作成

  $table = 'cost_calendar (
    cost_calendar_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    calendar_id INT UNSIGNED NOT NULL,
    total INT UNSIGNED NOT NULL,
    hotel INT UNSIGNED NOT NULL,
    food INT UNSIGNED NOT NULL,
    tour INT UNSIGNED NOT NULL,
    others INT UNSIGNED NOT NULL
  )';

  $sql = "CREATE TABLE IF NOT EXISTS $table";
  $stmt = $pdo -> query($sql);


  // テーブルを表示

  $sql = 'SHOW TABLES';
  $result = $pdo -> query($sql);
  
	foreach ($result as $row){
		echo $row[0], '<br>';
  }


?>
