<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include __DIR__ . '/assets/stylesheets.php' ?>
    <link rel="stylesheet" href="assets/stylesheets/mycalendar_plan.css">
    <title>Plan</title>
  </head>
  <body class="bg-light">
    <?php


      // インクルード

      include __DIR__ . '/assets/header.php';
      $users = new Users();
      $plans_inst = new Plans();
      $calendars_inst = new Calendars();
      $cost_calendars_inst = new Cost_Calendars();


      // リダイレクト
      redirect('timeline.php', empty($_SESSION['user'] || $_GET['id']));


      // データの取得

      $id = $_GET['id'];
      $calendars = $calendars_inst -> get_calendar($id);
      $plan_id = $calendars['plan_id'];
      $from = $calendars['from_date'];
      $to = $calendars['to_date'];
      $froms = explode("-",$from);
      $tos = explode("-",$to);
      $tos1 = $tos[2] + 1;

      $plans = $plans_inst -> get_plan($plan_id);
      $title = $plans['title'];
      $schedule = $plans['schedule'];
      $comment = $plans['comment'];
      $profit = $plans['profit'];
      $image = $plans['image'];
      $date = $plans['created_at'];
      $name_id = $plans['user_id'];
      $name = $users -> get_user($name_id);

      $cost_calendars_pick = $cost_calendars_inst -> get($id);
      $budget = $cost_calendars_pick['total'];
      $cost_hotel = $cost_calendars_pick['hotel'];
      $food = $cost_calendars_pick['food'];
      $tour = $cost_calendars_pick['tour'];
      $others = $cost_calendars_pick['others'];


      // sheduleを配列に分割
      $split = $plans_inst -> escape(' > ');
      $schedule = explode($split, $schedule);



      $api_url = "https://app.rakuten.co.jp/services/api/Travel/KeywordHotelSearch/20170426?format=json&keyword=".urlencode($title)."&applicationId=1072133978747396946&affiliateId=1cab7601.42c0d3db.1cab7602.5db9b85c";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $api_url);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      $json = array();
      $json = curl_exec($ch);
      curl_close($ch);
      $result = json_decode($json, true);

      $latitude = $result['hotels'][0]['hotel'][0]['hotelBasicInfo']['latitude'];
      $longitude = $result['hotels'][0]['hotel'][0]['hotelBasicInfo']['longitude'];

      $api_url2 = "https://app.rakuten.co.jp/services/api/Travel/VacantHotelSearch/20170426?format=json&checkinDate=".urlencode($from)."&checkoutDate=".urlencode($to)."&latitude=".urlencode($latitude)."&longitude=".urlencode($longitude)."&affiliateId=1cab7601.42c0d3db.1cab7602.5db9b85c&applicationId=1072133978747396946";
      $ch1 = curl_init();
      curl_setopt($ch1, CURLOPT_URL, $api_url2);
      curl_setopt($ch1, CURLOPT_HEADER, false);
      curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch1, CURLOPT_TIMEOUT, 60);
      $jsons = array();
      $jsons = curl_exec($ch1);
      curl_close($ch1);
      $result2 = json_decode($jsons, true);
      $hotelInformationUrl = $result2['hotels'][0]['hotel'][0]['hotelBasicInfo']["hotelInformationUrl"];
      $hotelImageUrl = $result2['hotels'][0]['hotel'][0]['hotelBasicInfo']['hotelImageUrl'];
      $hotelName = $result2['hotels'][0]['hotel'][0]['hotelBasicInfo']['hotelName'];

      $roomImageUrl = $result2['hotels'][0]['hotel'][0]['hotelBasicInfo']['roomImageUrl'];

      $planName = $result2['hotels'][0]['hotel'][1]['roomInfo'][0]['roomBasicInfo']['planName'];
      // var_dump($planName);
      $roomName = $result2['hotels'][0]['hotel'][1]['roomInfo'][0]['roomBasicInfo']['roomName'];
      $reserveUrl = $result2['hotels'][0]['hotel'][1]['roomInfo'][0]['roomBasicInfo']['reserveUrl'];
      $rakutenCharge = $result2['hotels'][0]['hotel'][1]['roomInfo'][1]['dailyCharge']['rakutenCharge'];



      $hotels = $result2['hotels'];


    ?>


    <main class="container">
      <div class="row justify-content-md-center">
        <?php if(!empty($image)): ?>
          <img class="col-md-7 mt-5 rounded" src="backend/image.php?id=<?= $plan_id ?>" alt="image">
        <?php endif ?>
        <div class="col-md-7 mt-5">
          <!-- form -->
          <form action="backend/mycalendar_plan.php" method="POST">
            <h5>
              タイトル
              <small>
                <a class="float-right text-secondary mt-1" href="https://www.google.com/calendar/event?action=TEMPLATE&text=<?= $title ?>への旅行&location=<?= $title ?>&dates=<?= $froms[0] ?><?= $froms[1] ?><?= $froms[2] ?>/<?= $tos[0] ?><?= $tos[1] ?><?= $tos1 ?>&details=<?= implode("→",$schedule)?>%20https://tb-220145.tech-base.net/mycalendar_plan.php?id=<?=$id?>%20powered%20by%20Share%20Trip">
                  Googleカレンダーに追加
                  <i class="far fa-calendar-plus ml-2 mr-1"></i>
                </a>
              </small>
            </h5>
            <div class="input-group mb-3">
              <input class="form-control bg-light" type="text" value="<?= $title ?>" readonly>
              <div class="input-group-append">
                <span class="input-group-text">への旅行</span>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col">
                <input class="form-control bg-light" type="date" value="<?= $from ?>" readonly></input>
              </div>
              <p> - </p>
              <div class="col">
                <input class="form-control bg-light" type="date" value="<?= $to ?>" readonly></input>
              </div>
            </div>
            <p class="small text-right mb-3">created at <?= $date ?> by <?= $name ?></p>
            <table class="table mt-5">
              <thead>
                <tr>
                  <th scope="col">総予算</th>
                  <th scope="col">ホテル</th>
                  <th scope="col">飲食</th>
                  <th scope="col">観光</th>
                  <th scope="col">その他</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row"><?= $budget?>円</th>
                  <td><?= $cost_hotel?>円</td>
                  <td><?= $food?>円</td>
                  <td><?= $tour?>円</td>
                  <td><?= $others?>円</td>
                </tr>
              </tbody>
            </table>


            <h5 class="mt-5">おすすめの周辺のホテル・旅館はこちら</h5>
            <div id="carouselExampleControls" class="carousel slide mb-5" data-ride="carousel">
              <div class="carousel-inner">
                <?php foreach($hotels as $index => $resulteach): ?>$hotel
                  <?php //$hotel = $hotel[0]['hotel'] // [1] ?>
                  <?php if (!empty($resulteach['hotel'][0]['hotelBasicInfo']['hotelName'])): ?>
                    <?php if ($index == 0): ?>
                      <div class="carousel-item zoomIn filter active">
                    <?php else: ?>
                      <div class="carousel-item zoomIn filter">
                    <?php endif ?>
                      <a class="card border-0 text-reset shadow-sm" href="<?= $resulteach['hotel'][0]['hotelBasicInfo']["hotelInformationUrl"] ?>" target="_blank" rel="noopener noreferrer">
                        <div class="zoomIn filter">
                          <img src="<?= $resulteach['hotel'][0]['hotelBasicInfo']['hotelImageUrl'] ?>" alt="..." style="width: 100%; height: 270px; object-fit: cover;">
                        </div>
                        <div class="carousel-caption d-none d-md-block">
                          <h5><?= $resulteach['hotel'][0]['hotelBasicInfo']['hotelName'] ?></h5>
                          <p>大人１人 <?= $resulteach['hotel'][0]['hotelBasicInfo']['hotelMinCharge'] ?>円〜 </p>
                        </div>
                      </a>
                      <button type="button" class="btn btn-info btn-lg btn-block mt-4 mb-2" data-toggle="modal" data-target="#testModal<?= $index ?>">このホテルを予約</button>

                      <!-- ボタン・リンククリック後に表示される画面の内容 -->
                      <?php //foreach ($hotel as $room): ?>
                        <?php //$room = $room['roomInfo'] ?>
                      <?php //endforeach ?>
                      <div class="modal fade" id="testModal<?= $index ?>" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel"><?= $resulteach['hotel'][0] ?></h4>
                            </div>
                            <div class="modal-body">
                              <label class="mb-3"><?= $from ?>から<?= $to ?>の利用</label>
                              <div class="card w-auto">
                                <img src="<?= $roomImageUrl ?>" class="card-img-top">
                                <div class="card-body">
                                  <h5 class="card-title"><?= $roomName ?></h5>
                                  <p class="card-text"><?= $planName?></p>
                                  <p class="card-text"><?= $rakutenCharge?>円</p>
                                  <input type="hidden" name="plan" value="<?= $plan_id ?>">
                                  <input type="hidden" name="url" value="<?= $reserveUrl ?>">
                                  <button type="submit" class="btn btn-primary">予約する</button>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Next</span>
                    </a>
                  <?php endif ?>
                <?php endforeach ?>
              </div>
            </div>


            <h5>スケジュール</h5>
            <?php foreach ($schedule as $index => $place): ?>
              <?php if ($index == 0): ?>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text">出発</span>
                  </div>
                  <input class="form-control bg-light" type="text" value="<?= $place ?>" readonly>
                </div>
              <?php elseif ($index < count($schedule) - 1): ?>
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <span class="input-group-text">></span>
                  </div>
                  <input class="form-control bg-light" type="text" value="<?= $place ?>" readonly>
                </div>
              <?php else: ?>
                <div class="input-group mb-5">
                  <div class="input-group-prepend">
                    <span class="input-group-text">到着</span>
                  </div>
                  <input class="form-control bg-light" type="text" value="<?= $place ?>" readonly>
                </div>
              <?php endif ?>
            <?php endforeach ?>
            <!-- ルート最適化実装前の投稿への対応 -->
            <?php if (count($schedule) < 3): ?>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <span class="input-group-text">></span>
                </div>
                <input class="form-control bg-light" type="text" value="<?= $place ?>" readonly>
              </div>
              <div class="input-group mb-5">
                <div class="input-group-prepend">
                  <span class="input-group-text">到着</span>
                </div>
                <input class="form-control bg-light" type="text" value="<?= $place ?>" readonly>
              </div>
            <?php endif ?>
            <h5>コメント</h5>
            <textarea class="form-control bg-light mb-5" cols="30" rows="10" readonly><?= $comment ?></textarea>
          </form>
          <!-- 削除ボタン -->
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
    </main>
    <!-- Rakuten Web Services Attribution Snippet -->
    <a href="https://webservice.rakuten.co.jp/" target="_blank">Supported by Rakuten Developers</a>
    <?php include __DIR__ . '/assets/scripts.php' ?>
    <script src="asetts/scripts/calendar_modal.js"></script>
  </body>
</html>