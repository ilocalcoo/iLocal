"use strict";

$(document).ready(function () {
  $('.menu-toggler').click(function (event) {
    event.preventDefault();
    $('#navbarNav').toggleClass('content-active');
    $('#navbarNav').toggleClass('content-desc');
    $('.backdrop').show();
  })
  $('#close').click(function (event) {
    event.preventDefault();
    $('.backdrop').hide();
    $('#navbarNav').toggleClass('content-active');
    $('#navbarNav').toggleClass('content-desc');
  })
  $('.backdrop').click(function (event) {
    event.preventDefault();
    $('.backdrop').hide();
    $('#navbarNav').toggleClass('content-active');
    $('#navbarNav').toggleClass('content-desc');
  })
});