const mix = require('laravel-mix');

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

mix.styles([
    'resources/css/bootstrap.min.css',
    'resources/css/vendors.min.css',
    'resources/css/toastr.min.css',
    'resources/css/pace.css',
    'resources/css/prism.min.css',
    'resources/css/bootstrap-extended.min.css',
    'resources/css/colors.min.css',
    'resources/css/components.min.css',
    'resources/css/horizontal-top-icon-menu.min.css',
    'resources/css/toastr-ext.min.css',
    'resources/css/animate.min.css',
    'resources/css/sweetalert.css',
    'resources/css/datatables-b4.min.css',
    'resources/css/datatables-responsive-b4.min.css',
    'resources/css/style.css',
    'resources/css/loading.css',
    'resources/css/loading-btn.css',
    'resources/css/select2.min.css',
    'resources/css/utils.css',
],'public/css/ventio-styles.css');

mix.styles([
    'resources/css/fonts/feather.min.css',
    'resources/css/fonts/font-awesome.min.css',
    'resources/css/fonts/simpleline.min.css',
],'public/css/ventio-icons.css');


mix.scripts([
    'resources/js/vendors.min.js',
    'resources/js/jquery.sticky.js',
    'resources/js/jquery.sparkline.min.js',
    'resources/js/toastr.min.js',
    'resources/js/prism.min.js',
    'resources/js/app-menu.min.js',
    'resources/js/app.min.js',
    'resources/js/sweetalert.min.js',
    'resources/js/datatables.min.js',
    'resources/js/datatables-b4.min.js',
    'resources/js/datatables-responsive.min.js',
    'resources/js/datatables-responsive-b4.min.js',
    'resources/js/select2.full.min.js',
    'resources/js/form-select2.js',
    'resources/js/init.js',
    'resources/js/saleAjaxFunctions.js',
    'resources/js/utils.js',
],'public/js/ventio-scripts.js');
