$(function(){


  const btn = $('#good_btn');  // button
  const user = $('#user').text();  // user_id
  const plan = $('#plan').text();  // plan_id
  const good_id = $('#good').text();  // good_id
  var good = 0;  // good


  if (good_id >= 0) {
    good = 1;
    btn.removeClass('btn-info').addClass('btn-danger');
  }
  
  
  $('#good_btn').on('click', function() {


    // Ajaxリクエスト
    $.ajax({
      url:'backend/good.php',
      type:'POST',
      data:{
        user: user,
        plan: plan,
        good: good
      },
      dataType: 'json'  // 受け取るデータの型
    })


    // Ajaxリクエストが成功した時発動
    .done(json => {

      console.log(json);

      if (json['status']) {
        if (json['log'] === 'added') {
          good = 1;
          btn.removeClass('btn-info').addClass('btn-danger');
        } else {
          good = 0;
          btn.removeClass('btn-danger').addClass('btn-info');
        }
      }

      else {
        console.log(json['log']);
      }

    })


    // Ajaxリクエストが失敗した時発動
    .fail(json => {
      console.log('Ajax Failed.');
      console.log(json);
      /*
      // 通信失敗時の処理
      alert('ファイルの取得に失敗しました。');
      console.log("ajax通信に失敗しました");
      console.log("jqXHR          : " + jqXHR.status); // HTTPステータスが取得
      console.log("textStatus     : " + textStatus);    // タイムアウト、パースエラー
      console.log("errorThrown    : " + errorThrown.message); // 例外情報
      console.log("URL            : " + url);
      */
    });


  });
});