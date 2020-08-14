<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/assets/stylesheets.php' ?>
    <title>Edit</title>
  </head>
  <body class="bg-light">
    <header>
    </header>

    <?php


      //インクルード
      
      include __DIR__ . '/assets/header.php';
      $users = new Users();
      $plans = new Plans();


      // リダイレクト
      redirect('timeline.php', empty($_SESSION['user'] || $_GET['id']));


      $user = $_SESSION['user'];
      $id = $_GET['id'];
      $plan = $plans -> get_plan($id);
      $title = $plan['title'];
      $schedule = $plan['schedule'];
      $comment = $plan['comment'];
      $image = $plan['image'];
      $date = $plan['created_at'];
      $name_id = $plan['user_id'];
      $name = $users -> get_user($name_id);
      $file = $user == $name_id ? 'edit' : 'make';

      // sheduleを配列に分割
      $split = $users -> escape(' > ');
      $schedule = explode($split, $schedule);

    ?>

    <main class="card bg-light border-0 p-3">
      <div class="row no-gutters">

        <?php if(!empty($image)): ?>
          <img class="card-img-top col-md-6" src="backend/image.php?id=<?= $id ?>" alt="image">
        <?php endif ?>

        <form class="col-md-6" action="<?= $file ?>" method="POST" enctype="multipart/form-data">
          <div class="card-body">
            <h5>タイトル</h5>
            <div class="input-group mb-3">
              <input class="form-control" type="text" name="title" placeholder="タイトル" value="<?= $title ?>" required>
              <div class="input-group-append">
                <span class="input-group-text">への旅行</span>
              </div>
            </div>
            <h5>スケジュール</h5>

            <?php foreach ($schedule as $index => $place): ?>
              <?php if ($index == 0): ?>
                <input class="form-control mb-2" type="text" name="origin" placeholder="出発地を入力" value="<?= $place ?>" required></input>
              <?php elseif ($index < count($schedule) - 1): ?>
                <input class="waypoint form-control mb-2" type="text" name="waypoints[]" placeholder="経由地を入力" value="<?= $place ?>" required></input>
              <?php else: ?>
                <input class="form-control mb-2" type="text" name="destination" placeholder="帰着地を入力" value="<?= $place ?>" required></input>
              <?php endif ?>
            <?php endforeach ?>
            
            <button type="button" class="btn-clone btn btn-info btn-lg btn-block mb-2">+</button>
            <button type="button" class="btn-remove btn btn-info btn-lg btn-block mb-3" style="display: none;">-</button>
            <h5>コメント</h5>
            <textarea class="form-control mb-3" name="comment" cols="30" rows="10" placeholder="コメント"><?= $comment ?></textarea>
            <h5 class="mb-2">画像</h5>
            <div class="custom-file mb-2">
              <input class="custom-file-input" id="customFile" type="file" name="image" accept="image/*">
              <label class="custom-file-label" for="customFile">画像を選択</label>
            </div>
            <input class="mb-2 mr-2" type="checkbox" name="img_del" value="TRUE">画像を削除
            <p class="alert alert-warning mb-3">画像は3MBまでアップロードできます。</p>
            <input class="btn btn-info btn-lg btn-block" type="submit" value="編集！">
          </div>
        </form>
      </div>
    </main>
    <footer>
    </footer>
    <?php include __DIR__ . '/assets/scripts.php' ?>
    <script src="assets/scripts/backkey.js"></script>
    <script src="assets/scripts/clone_input.js"></script>
  </body>
</html>