"use strict";

$(document).ready(function () {
  $('#reset_button').click(function (event) {
    event.preventDefault();
    history.pushState('','','/shops');
    location.reload();
  })
});