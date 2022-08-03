/*=========================================================================================
    File Name: form-repeater.js
    Description: form repeater page specific js
    ----------------------------------------------------------------------------------------
    Item Name: Bicrypto - Crypto Trading Platform
    Version: 1.0
    Author: MashDiv
    Author URL: http://www.themeforest.net/user/mashdiv
==========================================================================================*/

$(function () {
  'use strict';

  // form repeater jquery
  $('.invoice-repeater, .repeater-default').repeater({
    show: function () {
      $(this).slideDown();
      // Feather Icons
      if (feather) {
        feather.replace({ width: 14, height: 14 });
      }
    },
    hide: function (deleteElement) {
      if (confirm('Are you sure you want to delete this element?')) {
        $(this).slideUp(deleteElement);
      }
    }
  });
});
