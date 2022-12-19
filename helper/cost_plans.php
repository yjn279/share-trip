<?php


  // DB接続

  $dsn = '******';
  $user = '******';
  $password = '******';

  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


  // テーブルの削除

  $table = 'cost_plans';
  $sql ="DROP TABLE $table";
  $result = $pdo -> query($sql);


  // テーブル作成

  $table = 'cost_plans (
    cost_plan_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    plan_id INT UNSIGNED NOT NULL,
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
