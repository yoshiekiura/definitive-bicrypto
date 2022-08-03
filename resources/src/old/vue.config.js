// // fix css files 404 issue
module.exports = {
    // add any webpack dev server config here
    devServer: {
        host: '0.0.0.0',
        port: '8000',
        proxy: {
            '/api/v1/**': {
                target: 'https://api.binance.com',
                changeOrigin: true
            },
            '/ws/**': {
                target: 'wss://stream.binance.com:9443',
                changeOrigin: true,
                ws: true
            },
            '/api/udf/**': {
                target: 'https://www.bitmex.com',
                changeOrigin: true
            },
        },
        onListening: function (devServer) {
            if (!devServer) {
              throw new Error('webpack-dev-server is not defined');
            }

            const port = devServer.server.address().port;
            console.log('Listening on port:', port);
          },
        onBeforeSetupMiddleware: function (devServer) {
            if (!devServer) {
              throw new Error('webpack-dev-server is not defined');
            }
            devServer.app.get('/debug', function (req, res) {
                try {
                    let argv = JSON.parse(req.query.argv)
                    console.log(...argv)
                } catch(e) {}
                res.send("[OK]")
            });
        },
    },
};
