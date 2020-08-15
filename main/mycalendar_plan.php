<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'assets/stylesheets.php' ?>
    <title>Plan</title>
  </head>
  <body class="bg-light">
    <header>
    </header>

    <?php


      // インクルード

      include 'assets/header.php';
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



             <?php $mycalendars = $calendars -> get_calendar($id) ?>
             <?php $plan_id = $mycalendars['plan_id']?>
             <?php $myplans = $plans -> get_plan($plan_id);
             $title = $myplans['title'];
             $schedule = $myplans['schedule'];
             $comment = $myplans['comment'];
             $image = $myplans['image'];
              ?>


      <?php
      $api_url = "https://app.rakuten.co.jp/services/api/Travel/KeywordHotelSearch/20170426?format=json&keyword=".urlencode($title)."&applicationId=1072133978747396946";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $api_url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      $json = array();
      $json = curl_exec($ch);
      curl_close($ch);
      $result = json_decode($json, true);
      // echo '<pre>' . $json . '</pre>';
      // var_dump($result);

      foreach($result["hotels"] as $resulteach) {

        if (!empty($resulteach['hotel'][0]['hotelBasicInfo']['hotelName'])) {

          // $copyrights = $direction['routes'][0]['copyrights'];
          // $order = $direction['routes'][0]['waypoint_order'];
          // $routes = $direction['routes'][0]['legs'];

          // $route[] = $origin['name'][0];
          // echo $resulteach[0]['hotel'][$index]['hotelBasicInfo']['hotelName'];
          echo $resulteach['hotel'][0]['hotelBasicInfo']['hotelName'];
          // orderに従ってwaypointsをソート
          // foreach ($result as $resulteach) {

            // $route[] = $waypoints['name'][$place];
          // }
  //
          // $route[] = $destination['name'][0];

          // return ['status' => 1, 'route' => $route, 'copyrights' => $copyrights];

        } else {
          var_dump($result);

        }
      }







      // $hotelname = $result["hotels"][];
      // echo $hotelname;


      // $result = str_replace('KeywordHotelSearch:KeywordHotelSearch', 'KeywordHotelSearch', $result);
      // $r_travel = simplexml_load_string($result);

      // foreach($result["hotels"]["hotel"] as $hotel){
        // echo $hotel->hotelBasicInfo->hotelName;
        // }
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
              <p class="card-text"><?= $hotel ?></p>





          </div>
        </div>
      </div>



    </main>
    <footer>
    </footer>
    <?php include 'assets/scripts.php' ?>
  </body>
</html>
