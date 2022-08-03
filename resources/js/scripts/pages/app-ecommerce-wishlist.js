/*=========================================================================================
    File Name: app-ecommerce-wishlist.js
    Description: Ecommerce wishlist pages js
    ----------------------------------------------------------------------------------------
    Item Name: Bicrypto - Crypto Trading Platform
    Author: MashDiv
    Author URL: http://www.themeforest.net/user/mashdiv
==========================================================================================*/

$(function () {
  'use strict';

  var removeItem = $('.remove-wishlist'),
    moveToCart = $('.move-cart'),
    isRtl = $('html').attr('data-textdirection') === 'rtl';

  // remove items from wishlist page
  removeItem.on('click', function () {
    $(this).closest('.ecommerce-card').remove();
    toastr['error']('', 'Removed Item 🗑️', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });

  // move items to cart
  moveToCart.on('click', function () {
    $(this).closest('.ecommerce-card').remove();
    toastr['success']('', 'Moved Item To Your Cart 🛒', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  });
});
