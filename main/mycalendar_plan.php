<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/assets/stylesheets.php' ?>
    <title>Plan</title>
  </head>
  <body class="bg-light">
    <header>
    </header>

    <?php


      // インクルード

      include __DIR__ . '/assets/header.php';
      $users = new Users();
      $plans = new Plans();
      $calendars = new Calendars();


      // リダイレクト
      redirect('timeline.php', empty($_GET['id']));
      // header('Content-type:image/*');

      $id = $_GET['id'];


      ?>
      <?php $mycalendars = $calendars -> get_calendar($id) ?>
      <?php $plan_id = $mycalendars['plan_id']?>
      <?php $myplans = $plans -> get_plan($plan_id);
      $title = $myplans['title'];
      $schedule = $myplans['schedule'];
      $comment = $myplans['comment'];
      $image = $myplans['image'];
       ?>

      <main class="card bg-light border-0 p-3">
        <div class="row no-gutters">

          <?php if(!empty($image)): ?>
            <img class="card-img-top col-md-6" src="backend/image.php?id=<?= $plan_id ?>" alt="image">
          <?php endif ?>

          <div class="col-md-6 mx-md-auto">
            <div class="card-body">
              <h2 class="card-title"><?= $mycalendars['from_date'] ?>　〜　<?= $mycalendars['to_date'] ?></h2>
              <p class="card-text"><?= $title ?>への旅行</p>
              <p class="card-text"><?= $schedule ?></p>
              <p class="card-text"><?= $comment ?></p>





          </div>
        </div>
      </div>



    </main>
    <footer>
    </footer>
    <?php include __DIR__ . '/assets/scripts.php' ?>
  </body>
</html>
