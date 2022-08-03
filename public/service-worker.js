/**
 * Copyright 2018 Google Inc. All Rights Reserved.
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *     http://www.apache.org/licenses/LICENSE-2.0
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// If the loader is already loaded, just stop.
if (!self.define) {
  let registry = {};

  // Used for `eval` and `importScripts` where we can't get script URL by other means.
  // In both cases, it's safe to use a global var because those functions are synchronous.
  let nextDefineUri;

  const singleRequire = (uri, parentUri) => {
    uri = new URL(uri + ".js", parentUri).href;
    return registry[uri] || (
      
        new Promise(resolve => {
          if ("document" in self) {
            const script = document.createElement("script");
            script.src = uri;
            script.onload = resolve;
            document.head.appendChild(script);
          } else {
            nextDefineUri = uri;
            importScripts(uri);
            resolve();
          }
        })
      
      .then(() => {
        let promise = registry[uri];
        if (!promise) {
          throw new Error(`Module ${uri} didn’t register its module`);
        }
        return promise;
      })
    );
  };

  self.define = (depsNames, factory) => {
    const uri = nextDefineUri || ("document" in self ? document.currentScript.src : "") || location.href;
    if (registry[uri]) {
      // Module is already loading or loaded.
      return;
    }
    let exports = {};
    const require = depUri => singleRequire(depUri, uri);
    const specialDeps = {
      module: { uri },
      exports,
      require
    };
    registry[uri] = Promise.all(depsNames.map(
      depName => specialDeps[depName] || require(depName)
    )).then(deps => {
      factory(...deps);
      return exports;
    });
  };
}
define(['./workbox-0e5c19ae'], (function (workbox) { 'use strict';

  /**
  * Welcome to your Workbox-powered service worker!
  *
  * You'll need to register this file in your web app.
  * See https://goo.gl/nhQhGp
  *
  * The rest of the code is auto-generated. Please don't update this file
  * directly; instead, make changes to your Workbox build configuration
  * and re-run your build process.
  * See https://goo.gl/2aRDsh
  */

  self.skipWaiting();
  /**
   * The precacheAndRoute() method efficiently caches and responds to
   * requests for URLs in the manifest.
   * See https://goo.gl/S9QRab
   */

  workbox.precacheAndRoute([{
    "url": "/js/core/app-menu.js",
    "revision": "739ee5ffaf714d23f357d320ea0b195c"
  }, {
    "url": "/js/core/app.js",
    "revision": "da8ce553b9a61a4281306bcaba1d4da3"
  }, {
    "url": "/js/core/scripts.js",
    "revision": "99df4125bf62980c140b09703a9f0ab6"
  }, {
    "url": "/js/frontend/manifest.js",
    "revision": "828f256b98199237e737e71dfd71205d"
  }, {
    "url": "/js/frontend/vendor.js",
    "revision": "2b19da463dbdd9c3afc88cdd30f6659a"
  }, {
    "url": "css/base/core/colors/palette-gradient.css",
    "revision": "3a156ecdd79fe4df07d0b0e31af0e340"
  }, {
    "url": "css/base/core/colors/palette-noui.css",
    "revision": "cb81890f6716d65bdf9d16e3aecd0c6f"
  }, {
    "url": "css/base/core/colors/palette-variables.css",
    "revision": "68b329da9893e34099c7d8ad5cb9c940"
  }, {
    "url": "css/base/core/menu/menu-types/horizontal-menu.css",
    "revision": "07cc302abb81abdc6eeff0c949578cd5"
  }, {
    "url": "css/base/core/menu/menu-types/vertical-menu.css",
    "revision": "1967f93ea05a8653ff52acd6cc6a8ebd"
  }, {
    "url": "css/base/core/menu/menu-types/vertical-overlay-menu.css",
    "revision": "9b732a5fd845c0ca8ffdd308543ccd89"
  }, {
    "url": "css/base/core/mixins/alert.css",
    "revision": "68b329da9893e34099c7d8ad5cb9c940"
  }, {
    "url": "css/base/core/mixins/hex2rgb.css",
    "revision": "68b329da9893e34099c7d8ad5cb9c940"
  }, {
    "url": "css/base/core/mixins/main-menu-mixin.css",
    "revision": "68b329da9893e34099c7d8ad5cb9c940"
  }, {
    "url": "css/base/core/mixins/transitions.css",
    "revision": "68b329da9893e34099c7d8ad5cb9c940"
  }, {
    "url": "css/base/pages/app-calendar.css",
    "revision": "3d1ef944b86b737b47a8a241f431df98"
  }, {
    "url": "css/base/pages/app-chat-list.css",
    "revision": "98b7dec84b4152ed15822161f64d45d3"
  }, {
    "url": "css/base/pages/app-chat.css",
    "revision": "6cb106362ec4b253bb5065a5b9a653d4"
  }, {
    "url": "css/base/pages/app-ecommerce-details.css",
    "revision": "f9d5b45371b6e5f4fa8dc13c2dce069f"
  }, {
    "url": "css/base/pages/app-ecommerce.css",
    "revision": "4363072417d7ab457bf215a790e4a782"
  }, {
    "url": "css/base/pages/app-email.css",
    "revision": "f28344990d8061b12215037bf925633d"
  }, {
    "url": "css/base/pages/app-file-manager.css",
    "revision": "562a4e75c5681833bc38066673a7d287"
  }, {
    "url": "css/base/pages/app-invoice-list.css",
    "revision": "100a727835e3fae701fe87d270008c8a"
  }, {
    "url": "css/base/pages/app-invoice-print.css",
    "revision": "20ee25d970ffd636b5b79538820f8580"
  }, {
    "url": "css/base/pages/app-invoice.css",
    "revision": "2ca25f4f12bcf698bcc77d0966e96cf0"
  }, {
    "url": "css/base/pages/app-kanban.css",
    "revision": "b779a3a86b35b9376791f85c67399fb4"
  }, {
    "url": "css/base/pages/app-todo.css",
    "revision": "9817e2a029f13b2b89e85ba7941a117f"
  }, {
    "url": "css/base/pages/authentication.css",
    "revision": "348620d01d3dbc996d406b2592f65d25"
  }, {
    "url": "css/base/pages/dashboard-ecommerce.css",
    "revision": "8e1353a745e31512f0d9deede0b77396"
  }, {
    "url": "css/base/pages/modal-create-app.css",
    "revision": "b4ee8bc1e587dc7c6727208ccfbe6ad3"
  }, {
    "url": "css/base/pages/page-blog.css",
    "revision": "6a7b4f2592ef15018bfc24fc61a46741"
  }, {
    "url": "css/base/pages/page-coming-soon.css",
    "revision": "b2928901328ab4b3a7b99a420a796c8c"
  }, {
    "url": "css/base/pages/page-faq.css",
    "revision": "3d5b32bc0e27bc493314461d63082d2d"
  }, {
    "url": "css/base/pages/page-knowledge-base.css",
    "revision": "c540947c5a3b44eb953a131e6a9cb422"
  }, {
    "url": "css/base/pages/page-misc.css",
    "revision": "560310296bd2b009c86b62bbb48141f2"
  }, {
    "url": "css/base/pages/page-pricing.css",
    "revision": "73e137ddb175c6ee406915ca6e0387e2"
  }, {
    "url": "css/base/pages/page-profile.css",
    "revision": "6f44ffb7a5a339fca1d6959b9e32bf65"
  }, {
    "url": "css/base/pages/ui-feather.css",
    "revision": "cf47589c6c6f4d46181c7c1cd322f5bf"
  }, {
    "url": "css/base/plugins/charts/chart-apex.css",
    "revision": "e392e8ccb5a2ea2c1afd964817ff3593"
  }, {
    "url": "css/base/plugins/extensions/ext-component-context-menu.css",
    "revision": "bb5cf3bc034930e2165e107664b25907"
  }, {
    "url": "css/base/plugins/extensions/ext-component-drag-drop.css",
    "revision": "86346d0d8d728d02459f48c8cf5e1821"
  }, {
    "url": "css/base/plugins/extensions/ext-component-media-player.css",
    "revision": "47662d3a19ee4a6c0b479bebbdb0e279"
  }, {
    "url": "css/base/plugins/extensions/ext-component-ratings.css",
    "revision": "4a77a0e7009eb5f7920beb7d4c4e021d"
  }, {
    "url": "css/base/plugins/extensions/ext-component-sliders.css",
    "revision": "7dec2c9890cd6ee63c8ca3f191c82b42"
  }, {
    "url": "css/base/plugins/extensions/ext-component-sweet-alerts.css",
    "revision": "82afc712b8a66b2caac6eef85c13df8d"
  }, {
    "url": "css/base/plugins/extensions/ext-component-swiper.css",
    "revision": "d44e7a994f114c9855a7a2cc3107327a"
  }, {
    "url": "css/base/plugins/extensions/ext-component-toastr.css",
    "revision": "0acd41fddb4e3f33b20aedb5122eb390"
  }, {
    "url": "css/base/plugins/extensions/ext-component-tour.css",
    "revision": "f61958a02484fbef50792a95ad08e5be"
  }, {
    "url": "css/base/plugins/extensions/ext-component-tree.css",
    "revision": "c3a606b531a5bace32eeb01c83707c41"
  }, {
    "url": "css/base/plugins/forms/form-file-uploader.css",
    "revision": "267d497a6def277d3487124fec6ae6e0"
  }, {
    "url": "css/base/plugins/forms/form-number-input.css",
    "revision": "008f97e54843301c5d106b717a9e0384"
  }, {
    "url": "css/base/plugins/forms/form-quill-editor.css",
    "revision": "d869568d10b2072b2bcb106ea77c4507"
  }, {
    "url": "css/base/plugins/forms/form-validation.css",
    "revision": "b5c5846a944e1d5357466a5269c9280a"
  }, {
    "url": "css/base/plugins/forms/form-wizard.css",
    "revision": "50e28b2acca2abfe645f7cbdf8c02080"
  }, {
    "url": "css/base/plugins/forms/pickers/form-flat-pickr.css",
    "revision": "5b8eed07a073bebaef1dc58edb9397c1"
  }, {
    "url": "css/base/plugins/forms/pickers/form-pickadate.css",
    "revision": "826aab50911036130804fa9feae62891"
  }, {
    "url": "css/base/plugins/maps/map-leaflet.css",
    "revision": "c477fad84ab794628633d42e8be75939"
  }, {
    "url": "css/base/plugins/ui/coming-soon.css",
    "revision": "b6a00d89ca3c26be89b990cd2e087797"
  }, {
    "url": "css/base/themes/dark-layout.css",
    "revision": "f27d038f34192f553b9275c74e44d883"
  }, {
    "url": "css/core.css",
    "revision": "21826c8259b7e8e6d3694fa170a5ea56"
  }, {
    "url": "css/overrides.css",
    "revision": "d4bd2f216fb5dea051c0163008a89c29"
  }, {
    "url": "css/style.css",
    "revision": "68b329da9893e34099c7d8ad5cb9c940"
  }, {
    "url": "js/core/resources_src_Pages_Dashboard_vue.js",
    "revision": "63764255074330ebf4007c477ef74c73"
  }, {
    "url": "js/core/resources_src_Pages_Forex_Forex_vue.js",
    "revision": "44ade9710e99c5d40f8d8991a6cd50b2"
  }, {
    "url": "js/core/resources_src_Pages_Forex_Trading_vue.js",
    "revision": "b74f613fdc2fc3345c374285898ba319"
  }, {
    "url": "js/core/resources_src_Pages_Market_vue.js",
    "revision": "5abe219e7bb46b324a4191a983a75376"
  }, {
    "url": "js/core/resources_src_Pages_Network_vue.js",
    "revision": "07e5e0f17ab5b467e9ceed10a05bd9d6"
  }, {
    "url": "js/core/resources_src_Pages_Swap_vue.js",
    "revision": "7ecf045ca16a97cef4f85e617e44379a"
  }, {
    "url": "js/core/resources_src_Pages_Trading_vue.js",
    "revision": "d2d5c15dd1cdad5a1c796e8dda3ae0d9"
  }, {
    "url": "js/core/resources_src_Pages_Wallets_vue.js",
    "revision": "908ec73e51edd2cc78d7f8e3e34624b1"
  }, {
    "url": "js/core/resources_src_Pages_binary_Binary_vue.js",
    "revision": "703009e55ee203ead8e0b1a102df7535"
  }, {
    "url": "js/core/resources_src_Pages_binary_logs_Practice_vue.js",
    "revision": "e4b2b7fdf3dbfb657ae7d157f35e1969"
  }, {
    "url": "js/core/resources_src_Pages_binary_logs_Trade_vue.js",
    "revision": "7761812ff1de6365570eb6749c194fd7"
  }, {
    "url": "js/core/resources_src_Pages_bot_BotTradePage_vue.js",
    "revision": "84368fc1c8a7da4257f1b767d2be7cae"
  }, {
    "url": "js/core/resources_src_Pages_bot_Bots_vue.js",
    "revision": "8151b4a0f9b758121fa6f6e44ee3d208"
  }, {
    "url": "js/core/resources_src_Pages_ico_ICODetails_vue.js",
    "revision": "a30733bd818bb7feca1e6cbac04c2164"
  }, {
    "url": "js/core/resources_src_Pages_ico_ICO_vue.js",
    "revision": "eaadb152fc416d0a2b78070cf79f0b9a"
  }, {
    "url": "js/core/resources_src_Pages_logs_Deposit_vue.js",
    "revision": "8c70051a9bfbb3daf4eaeb9b462a6b6d"
  }, {
    "url": "js/core/resources_src_Pages_logs_Transactions_vue.js",
    "revision": "1a9e88f20221898bdb8b97e82cae18ae"
  }, {
    "url": "js/core/resources_src_Pages_logs_Withdraw_vue.js",
    "revision": "95e048a1b00d463a20dc89ada2e82378"
  }, {
    "url": "js/core/resources_src_Pages_staking_StakingLogs_vue.js",
    "revision": "785c2f6c880ea7876bb2213ca4cbfa5c"
  }, {
    "url": "js/core/resources_src_Pages_staking_Staking_vue.js",
    "revision": "caaefdea1729d18fc1c0fd727fbed9b4"
  }, {
    "url": "js/core/resources_src_components_wallets_WalletDetail_vue.js",
    "revision": "1dedb9093e666e82339dc9b6257ebf5e"
  }], {});
  workbox.registerRoute(/\.(?:png|jpg|jpeg|svg|js|css|woff2)$/, new workbox.CacheFirst({
    "cacheName": "images",
    plugins: []
  }), 'GET');

}));
//# sourceMappingURL=service-worker.js.map
