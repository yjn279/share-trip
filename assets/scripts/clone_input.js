console.log('good morning!');

$(function() {

  // clone object
  $(document).on('click', '.add_input', function() {

    var input = $('.place').last();
    console.log(input);

    input
      .clone()
      // .hide()
      .insertAfter(input)

  });
});
