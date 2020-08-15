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
      redirect('timeline.php', empty($_SESSION['user'] || $_GET['id']));
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

  //     foreach($result["hotels"] as $resulteach) {
  //
  //       if (!empty($resulteach['hotel'][0]['hotelBasicInfo']['hotelName'])) {
  //
  //         // $copyrights = $direction['routes'][0]['copyrights'];
  //         // $order = $direction['routes'][0]['waypoint_order'];
  //         // $routes = $direction['routes'][0]['legs'];
  //
  //         // $route[] = $origin['name'][0];
  //         // echo $resulteach[0]['hotel'][$index]['hotelBasicInfo']['hotelName'];
  //         echo $resulteach['hotel'][0]['hotelBasicInfo']['hotelName'];
  //         // orderに従ってwaypointsをソート
  //         // foreach ($result as $resulteach) {
  //
  //           // $route[] = $waypoints['name'][$place];
  //         // }
  // //
  //         // $route[] = $destination['name'][0];
  //
  //         // return ['status' => 1, 'route' => $route, 'copyrights' => $copyrights];
  //
  //       } else {
  //         var_dump($result);
  //
  //       }
  //     }







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

              <h4 class="card-text">宿をお探しですか？おすすめの周辺のホテル・旅館はこちら</h4>


                    
                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">

                      <div class="carousel-inner">
                    <div class="carousel-item active">
                      <a class="card border-0 text-reset shadow-sm" href=<?= $result['hotels'][0]['hotel'][0]['hotelBasicInfo']["hotelInformationUrl"] ?> target="_blank" rel="noopener noreferrer" >
                      <img src="<?= $result['hotels'][0]['hotel'][0]['hotelBasicInfo']['hotelImageUrl'] ?>" alt="..." style="width: 100%;
                                            height: 270px;
                                            object-fit: cover;


                                            ">

                      <div class="carousel-caption d-none d-md-block">
                                              <h5><?= $result['hotels'][0]['hotel'][0]['hotelBasicInfo']['hotelName'] ?></h5>
                                              <p>大人１人 <?= $result['hotels'][0]['hotel'][0]['hotelBasicInfo']['hotelMinCharge'] ?>円から </p>
                                              </div>
                                            </a>

                      </div>

              <?php
              foreach($result["hotels"] as $index => $resulteach) {
                if ($index > 0){
                if (!empty($resulteach['hotel'][0]['hotelBasicInfo']['hotelName'])) { ?>


                  <!-- // echo $resulteach['hotel'][0]['hotelBasicInfo']['hotelName']: -->


                      <div class="carousel-item">
                        <a class="card border-0 text-reset shadow-sm " href=<?= $resulteach['hotel'][0]['hotelBasicInfo']["hotelInformationUrl"] ?> target="_blank" rel="noopener noreferrer" >
                        <img src="<?= $resulteach['hotel'][0]['hotelBasicInfo']['hotelImageUrl'] ?>" alt="..." style="width: 100%;
                        height: 270px;
                        object-fit: cover;

                        ">

                        <div class="carousel-caption d-none d-md-block">
                          <h5><?= $resulteach['hotel'][0]['hotelBasicInfo']['hotelName'] ?></h5>
                          <p>大人１人 <?= $resulteach['hotel'][0]['hotelBasicInfo']['hotelMinCharge'] ?>円〜 </p>
                          </div>
                        </a>
                      </div>




              <?php
                } else {
                  var_dump($result);

                }
              }
            }
              ?>
              </div>

              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>





            <!-- Button trigger modal -->
            <button type="button" class="btn btn-lg btn-block border-info text-info mt-5" data-toggle="modal" data-target="#exampleModal">削除</button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header border-0">
                    <h5 class="modal-title" id="exampleModalLabel">本当に削除しますか？</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    一度削除したカレンダーは復元できません。
                  </div>
                  <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
                    <a class="btn btn-danger" href="backend/deletecalendar.php?id=<?= $id ?>">削除</a>
                  </div>
                </div>
              </div>
            </div>


          </div>


        </div>
      </div>






    </main>
    <footer>
      <!-- Rakuten Web Services Attribution Snippet FROM HERE -->
  <a href="https://webservice.rakuten.co.jp/" target="_blank">Supported by Rakuten Developers</a>
  <!-- Rakuten Web Services Attribution Snippet TO HERE -->

    </footer>
    <?php include __DIR__ . '/assets/scripts.php' ?>

  </body>
</html>
