"use strict";

$(document).ready(function () {
  $('#reset_button').click(function (event) {
    event.preventDefault();
    history.pushState('','','/shops');
    location.reload();
  });
  $('#small-find').click(function (event) {
    event.preventDefault();
    $('.shop-find').css('visibility', 'visible');
  });
});