$(function() {

  // clone object
  $(document).on('click', '.add_waypoint', function() {

    var waypoint = $('.waypoint').last();

    waypoint
      .clone()
      // .hide()
      .val('')
      .insertAfter(waypoint)

  });
});
