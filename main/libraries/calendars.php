<?php


  class Calendars extends DataBase {


    function add(string $user, string $plan, data $from, data $to) {
      // プランをカレンダーに登録
      // libraries/plans.php > make_plan()を参考
  }


  function get(string $id) {
    // 登録したプランの表示用
    // get_plan()を参考
  }


  function get_all(string $user) {
    // ユーザーの全カレンダーを取得
    // get_by_user()を参考
    // そのまま使いまわせなかったわ笑
  }


?>