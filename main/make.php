<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/assets/stylesheets.php' ?>
    <title>Make a New Plan!</title>
  </head>
  <body class="bg-light">
    <header>
    </header>

    <?php include __DIR__ . '/assets/header.php' ?>
    <?php redirect('login.php', empty($_SESSION['user'])) ?>

    <main class="col-md-6 mx-md-auto py-5">
      <form class="bg-light" action="backend/make.php" method="POST" enctype="multipart/form-data">
        <h5>タイトル</h5>
        <div class="input-group mb-3">
          <input class="form-control" type="text" name="title" placeholder="タイトル" required>
          <div class="input-group-append">
            <span class="input-group-text">への旅行</span>
          </div>
        </div>
        <h5>スケジュール</h5>
        <input class="form-control mb-2" type="text" name="origin" placeholder="出発地を入力" required></input>
        <input class="waypoint form-control mb-2" type="text" name="waypoints[]" placeholder="経由地を入力" required></input>
        <input class="form-control mb-2" type="text" name="destination" placeholder="帰着地を入力" required></input>
        <button type="button" class="btn-clone btn btn-info btn-lg btn-block mb-2">+</button>
        <button type="button" class="btn-remove btn btn-info btn-lg btn-block mb-3" style="display: none;">-</button>
        <button type="button" class="btn-ajax btn btn-info btn-lg btn-block mb-3">プラン最適化</button>
        <h5>コメント</h5>
        <textarea class="form-control mb-3" name="comment" cols="30" rows="10" placeholder="コメント"></textarea>
        <h5 class="mb-2">画像</h5>
        <div class="custom-file mb-2">
          <input class="custom-file-input" id="customFile" type="file" name="image" accept="image/*">
          <label class="custom-file-label" for="customFile">画像を選択</label>
        </div>
        <p class="alert alert-warning mb-3">画像は3MBまでアップロードできます。</p>
        <input class="btn btn-info btn-lg btn-block" type="submit" value="作成！">
      </form>
    </main>
    <footer>
    </footer>
    <?php include __DIR__ . '/assets/scripts.php' ?>
    <script src="assets/scripts/backkey.js"></script>
    <script src="assets/scripts/clone_input.js"></script>
    <script src="assets/scripts/ajax.js"></script>
  </body>
</html>