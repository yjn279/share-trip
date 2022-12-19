<?php


  // DB接続

  $dsn = '******';
  $user = '******';
  $password = '******';

  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


  // テーブルの削除

  $table = 'bookmark';
  $sql ="DROP TABLE $table";
  $result = $pdo -> query($sql);


  // テーブル作成

  $table = 'good (
    good_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    plan_id INT UNSIGNED NOT NULL
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
