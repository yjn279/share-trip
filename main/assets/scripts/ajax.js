$(function(){


  $('.btn-ajax').on('click', function() {

    const waypoints = [];
    
    $('.waypoint').each(function(index, waypoint){
      waypoints.push(waypoint.value);
    })

    $.ajax({
      url:'backend/ajax.php',
      type:'POST',
      data:{
        waypoints: waypoints
      },
      dataType: 'json'  // 受け取るデータの型
    })

    // Ajaxリクエストが成功した時発動
    .done(data => {

      console.log(data);
      console.log('abcde');

      data.forEach(element => {
        console.log(element);
      });

    })

    // Ajaxリクエストが失敗した時発動
    .fail( (data) => {
      console.log(data);
    })

    // Ajaxリクエストが成功・失敗どちらでも発動
    .always( (data) => {
       
    });

  });
});