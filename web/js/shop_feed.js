"use strict";

$(document).ready(function () {
  $('#reset_button').click(function (event) {
    event.preventDefault();
    history.pushState('','','/shops');
    location.reload();
  });

  $('#loupe').click(function (event) {
    event.preventDefault();
    $('.shop-find').css('visibility', 'visible');
    $('#find-close').show();
    $('#find-placeholder').css('display', 'flex');
  });

  $('#find-close').click(function (event) {
    event.preventDefault();
    $('.shop-find').css('visibility', 'hidden');
    $('#find-close').hide();
    $('#find-placeholder').hide();
  });

  $('.shop-find').on('input', function () {
    $('#find-placeholder').hide();
  })
});