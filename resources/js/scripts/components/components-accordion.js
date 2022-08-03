/*=========================================================================================
    File Name: components-collapse.js
    ----------------------------------------------------------------------------------------
    Item Name: Bicrypto - Crypto Trading Platform
    Author: MashDiv
    Author URL: hhttp://www.themeforest.net/user/mashdiv
==========================================================================================*/
(function (window, document, $) {
  'use strict';

  var accordion = $('.accordion'),
    collapseHoverTitle = $('.accordion-hover-title');

  // To open Collapse on hover
  if (accordion.attr('data-toggle-hover', 'true')) {
    collapseHoverTitle.closest('.accordion-item').on('mouseenter', function () {
      $(this).children('.collapse').collapse('show');
    });
  }
  
})(window, document, jQuery);
