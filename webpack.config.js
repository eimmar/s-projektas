var Encore = require('@symfony/webpack-encore');

Encore
    // the project directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // uncomment to create hashed filenames (e.g. app.abc123.css)
    // .enableVersioning(Encore.isProduction())

    .addEntry(
        'js/bootstrap',
        [
            './assets/js/bootstrap.js',
            './assets/js/bootstrap.bundle.js'
        ]
    )
    .addStyleEntry(
        'css/bootstrap',
        [
            './assets/css/bootstrap.css',
            './assets/css/bootstrap-grid.css',
            './assets/css/bootstrap-reboot.css'
        ]
    )
    // .enableSassLoader()

    // uncomment for legacy applications that require $/jQuery as a global variable
    // .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
