const path = require("path");

module.exports = {
    publicPath: "/",
    lintOnSave: false,
    css: {
        loaderOptions: {
            sass: {
                sassOptions: {
                    includePaths: ["node_modules", "resources/assets"],
                },
            },
        },
    },
    chainWebpack: (config) => {
        config.module.rule("vue").use("vue-loader").loader("vue-loader");
    },
    transpileDependencies: ["resize-detector"],
};
