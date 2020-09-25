



<div class="carousel-item active">
                  <a class="card border-0 text-reset shadow-sm" href=<?= $hotelInformationUrl ?> target="_blank" rel="noopener noreferrer" >
                    <div class="zoomIn filter">
                    <img src="<?= $hotelImageUrl ?>" alt="..." style="width: 100%; height: 270px; object-fit: cover;">
                              </div>
                              <div class="carousel-caption d-none d-md-block">
                                <h5><?= $hotelName ?></h5>
                                <p>大人１人 <?= $result['hotels'][0]['hotel'][0]['hotelBasicInfo']['hotelMinCharge'] ?>円から </p>
                                </div>
                </a>
                              <button type="button" class="btn btn-info btn-lg btn-block mt-4 mb-2" data-toggle="modal" data-target="#testModal">このホテルを予約</button>

                              <!-- ボタン・リンククリック後に表示される画面の内容 -->
                              <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel"><?= $hotelName ?></h4>
                                  </div>
                                  <div class="modal-body">

                                      <label><?= $from?>から<?=$to?>の利用</label>

                                      <br>
                                      <br>

                                      <div class="card w-auto">

                                      <!-- <div class="card w-auto" style="width: 18rem;"> -->
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

                                    </form>
                                  </div>
                                </div>
                                </div>
                              </div>
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
                                      <button type="button" class="btn btn-info btn-lg btn-block mt-4 mb-2" data-toggle="modal" data-target="#testModal">このホテルを予約</button>

                                      <!-- ボタン・リンククリック後に表示される画面の内容 -->
                                      <div class="modal fade" id="testModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                        <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h4 class="modal-title" id="myModalLabel"><?= $hotelName ?></h4>
                                          </div>
                                          <div class="modal-body">

                                              <label><?= $from?>から<?=$to?>の利用</label>

                                              <br>
                                              <br>

                                              <div class="card w-auto">

                                              <!-- <div class="card w-auto" style="width: 18rem;"> -->
                                                  <img src="<?= $roomImageUrl ?>" class="card-img-top">
                                                  <div class="card-body">
                                                    <h5 class="card-title"><?= $roomName ?></h5>
                                                    <p class="card-text"><?= $planName?></p>
                                                    <p class="card-text"><?= $rakutenCharge?>円</p>
                                                    <a href="<?= $reserveUrl ?>" class="btn btn-primary">予約する</a>
                                                  </div>

                                                </div>


                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>

                                            </form>
                                          </div>
                                        </div>
                                        </div>
                                      </div>
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