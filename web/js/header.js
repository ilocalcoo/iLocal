"use strict";

$(document).ready(function () {
  $('.menu-toggler').click(function (event) {
    event.preventDefault();
    $('#navbarNav').toggleClass('content-active');
    $('#navbarNav').toggleClass('content-desc');
  })
  $('#close').click(function (event) {
    event.preventDefault();
    $('#navbarNav').toggleClass('content-active');
    $('#navbarNav').toggleClass('content-desc');
  })
});