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
      $image = $plans['image'];
      $date = $plans['created_at'];
      $name_id = $plans['user_id'];
      $name = $users -> get_user($name_id);

      $cost_calendars_pick = $cost_calendars_inst -> get($id);
      $budget = $cost_calendars_pick['total'];
      $hotel = $cost_calendars_pick['hotel'];
      $food = $cost_calendars_pick['food'];
      $tour = $cost_calendars_pick['tour'];
      $others = $cost_calendars_pick['others'];


      // sheduleを配列に分割
      $split = $plans_inst -> escape(' > ');
      $schedule = explode($split, $schedule);


      ?>


<style>
*ズームイン*/
.zoomIn img {
    -webkit-transform: scale(1);
    transform: scale(1);
    /* -webkit-transition: .3s ease-in-out; */

    -webkit-transition: all 1s;
    -moz-transition: all 1s;
    -ms-transition: all 1s;
    -o-transition: all 1s;
    transition: all 1s;
}
.zoomIn:hover img {
  transform:scale(1.2,1.2);
  -webkit-transition: all 1s;
  -moz-transition: all 1s;
  -ms-transition: all 1s;
  -o-transition: all 1s;
  transition: all 1s;
}

/*黒色フィルター ＋　キャプション*/
.filter img{
    width:100%;
    height:270px;
}
.filter a{
    display:block;
    position: relative;
    width:100%;
    min-height:270px;
    display: flex;
    justify-content: center;
    justify-content: flex-start;
    align-items: center;
    align-items: flex-end;
}
.filter .name{
    color:#FFF;
    position: absolute;
    width: 100%;
    min-height:270px;
    text-align: center;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 160%;
    font-family: bolder
}
.filter a:before{
    background-color: rgba(0,0,0,0.2);
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    content: ' ';
    -webkit-transition: all 1s;
    -moz-transition: all 1s;
    -ms-transition: all 1s;
    -o-transition: all 1s;
    transition: all 1s;
}
.filter a:hover:before{
    background-color: rgba(0,0,0,0.0);
}

</style>






      <?php
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

        ?>



      <main class="container">
        <div class="row justify-content-md-center">
          <?php if(!empty($image)): ?>
            <img class="col-md-7 mt-5 rounded" src="backend/image.php?id=<?= $plan_id ?>" alt="image">
          <?php endif ?>
          <div class="col-md-7 mt-5">
            <!-- form -->
            <form>
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

                <table class="table">
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
      <td><?= $hotel?>円</td>
      <td><?= $food?>円</td>
      <td><?= $tour?>円</td>
      <td><?= $others?>円</td>
    </tr>

  </tbody>
</table>


                <h5 class="card-text">おすすめの周辺のホテル・旅館はこちら</h5>
         <!-- ここからホテルサジェスト -->
                      <div id="carouselExampleControls" class="carousel slide mb-5" data-ride="carousel">

                          <div class="carousel-inner">
                              <div class="carousel-item active zoomIn filter">
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

                                  <div class="carousel-item zoomIn filter">
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
<!-- 右左ボタン -->
              <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
              </div>
              <!-- 右左ボタン -->

<!-- ここまでホテルサジェスト -->

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
    <footer>
      <!-- Rakuten Web Services Attribution Snippet FROM HERE -->
  <a href="https://webservice.rakuten.co.jp/" target="_blank">Supported by Rakuten Developers</a>
  <!-- Rakuten Web Services Attribution Snippet TO HERE -->

    </footer>
    <?php include __DIR__ . '/assets/scripts.php' ?>
    <script src="asetts/scripts/calendar_modal.js"></script>
  </body>
</html>
