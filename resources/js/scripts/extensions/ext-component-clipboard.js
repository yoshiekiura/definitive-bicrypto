/*=========================================================================================
    File Name: ext-component-clipboard.js
    Description: Copy to clipboard
    --------------------------------------------------------------------------------------
    Item Name: Bicrypto - Crypto Trading Platform
    Author: MashDiv
    Author URL: http://www.themeforest.net/user/mashdiv
==========================================================================================*/

'use strict';

var userText = $('#copy-to-clipboard-input');
var btnCopy = $('#btn-copy'),
  isRtl = $('html').attr('data-textdirection') === 'rtl';

// copy text on click
btnCopy.on('click', function () {
  userText.select();
  document.execCommand('copy');
  toastr['success']('', 'Copied to clipboard!', {
    rtl: isRtl
  });
});
