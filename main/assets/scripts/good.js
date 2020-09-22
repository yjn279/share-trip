$(function(){


  $('#good').on('click', function() {


    console.log(user);
    console.log(plan);
    console.log(good);


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
        console.log(json['log']);
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