const mix = require("laravel-mix");
const exec = require("child_process").exec;
require("dotenv").config();
require("laravel-mix-workbox");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const glob = require("glob");
const path = require("path");
/*
 |--------------------------------------------------------------------------
 | Vendor assets
 |--------------------------------------------------------------------------
 */

function mixAssetsDir(query, cb) {
    (glob.sync("resources/" + query) || []).forEach((f) => {
        f = f.replace(/[\\\/]+/g, "/");
        cb(f, f.replace("resources", "public"));
    });
}

const sassOptions = {
    precision: 5,
    includePaths: ["node_modules", "resources/assets/"],
};

// plugins Core stylesheets
mixAssetsDir("scss/base/plugins/**/!(_)*.scss", (src, dest) =>
    mix.sass(
        src,
        dest
            .replace(/(\\|\/)scss(\\|\/)/, "$1css$2")
            .replace(/\.scss$/, ".css"),
        { sassOptions }
    )
);

// pages Core stylesheets
mixAssetsDir("scss/base/pages/**/!(_)*.scss", (src, dest) =>
    mix.sass(
        src,
        dest
            .replace(/(\\|\/)scss(\\|\/)/, "$1css$2")
            .replace(/\.scss$/, ".css"),
        { sassOptions }
    )
);

// Core stylesheets
mixAssetsDir("scss/base/core/**/!(_)*.scss", (src, dest) =>
    mix.sass(
        src,
        dest
            .replace(/(\\|\/)scss(\\|\/)/, "$1css$2")
            .replace(/\.scss$/, ".css"),
        { sassOptions }
    )
);

// script js
mixAssetsDir("js/scripts/**/*.js", (src, dest) => mix.scripts(src, dest));

/*
 |--------------------------------------------------------------------------
 | Application assets
 |--------------------------------------------------------------------------
 */

mixAssetsDir("vendors/js/**/*.js", (src, dest) => mix.scripts(src, dest));
mixAssetsDir("vendors/bower/**/*.js", (src, dest) => mix.scripts(src, dest));
mixAssetsDir("vendors/css/**/*.css", (src, dest) => mix.copy(src, dest));
mixAssetsDir("css/*", (src, dest) => mix.copy(src, dest));
mixAssetsDir("js/kyc/*", (src, dest) => mix.copy(src, dest));
mixAssetsDir("vendors/bower/**/*.css", (src, dest) => mix.copy(src, dest));
mixAssetsDir("vendors/**/**/images", (src, dest) => mix.copy(src, dest));
mixAssetsDir("vendors/css/editors/quill/fonts/", (src, dest) =>
    mix.copy(src, dest)
);
mixAssetsDir("fonts", (src, dest) => mix.copy(src, dest));
mixAssetsDir("fonts/**/**/*.css", (src, dest) => mix.copy(src, dest));
mix.copyDirectory("resources/images", "public/images");
mix.copyDirectory("resources/img", "public/img");
mix.copyDirectory("resources/data", "public/data");
mix.copyDirectory("resources/assets/frontends", "public/assets/frontends");
mixAssetsDir("assets/frontends/**/css/*.css", (src, dest) =>
    mix.copy(src, dest)
);
mixAssetsDir("assets/frontends/**/css/**/*.css", (src, dest) =>
    mix.copy(src, dest)
);
mixAssetsDir("assets/frontends/**/js/*.js", (src, dest) => mix.copy(src, dest));
mixAssetsDir("assets/frontends/**/js/**/*.js", (src, dest) =>
    mix.copy(src, dest)
);

mix.js("resources/js/core/app-menu.js", "public/js/core")
    .js("resources/js/core/app.js", "public/js/core")
    .js("resources/assets/js/scripts.js", "public/js/core")
    .js("resources/js/frontend/app.js", "public/js/frontend")
    .js("resources/js/frontend/manifest.js", "public/js/frontend")
    .js("resources/js/frontend/vendor.js", "public/js/frontend")
    .sass("resources/scss/core.scss", "public/css", { sassOptions })
    .sass("resources/scss/overrides.scss", "public/css", { sassOptions })
    .sass(
        "resources/scss/base/themes/dark-layout.scss",
        "public/css/base/themes",
        { sassOptions }
    )
    .sass("resources/assets/scss/style.scss", "public/css", { sassOptions })
    .js("resources/src/index.js", "public/js")
    .vue()
    .generateSW({
        // Do not precache images
        exclude: [/\.(?:png|jpg|jpeg|svg)$/],

        // Define runtime caching rules.
        runtimeCaching: [
            {
                // Match any request that ends with .png, .jpg, .jpeg or .svg.
                urlPattern: /\.(?:png|jpg|jpeg|svg|js|css|woff2)$/,

                // Apply a cache-first strategy.
                handler: "CacheFirst",

                options: {
                    // Use a custom cache name.
                    cacheName: "images",
                },
            },
        ],

        skipWaiting: true,
    });

if (mix.inProduction()) {
    mix.version().options({
        // Optimize JS minification process
        terser: {
            //cache: true,
            parallel: true,
            //sourceMap: false
        },
    });
} else {
    // Uses inline source-maps on development
    mix.sourceMaps().webpackConfig({
        stats: {
            children: true,
        },
        devtool: "inline-source-map",
    });
}
//mix.browserSync('127.0.0.1:8000')
