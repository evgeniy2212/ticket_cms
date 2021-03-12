const mix = require('laravel-mix');
require('laravel-mix-dload');

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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// mix.sass('resources/scss/default/styles.scss', 'public/assets/css/default/app.min.css');

/*
 |--------------------------------------------------------------------------
 | Backend
 |--------------------------------------------------------------------------
 |
 */
function backend(mix) {

    mix.copy('resources/assets/css', 'public/assets/css');
    mix.copy('resources/assets/img', 'public/assets/img');
    mix.copy('resources/assets/js', 'public/assets/js');

// bootstrap-datepicker
    mix.copy('node_modules/bootstrap-datepicker/dist/', 'public/assets/plugins/bootstrap-datepicker/dist/');

// flag-icon-css
    mix.copy('node_modules/flag-icon-css/', 'public/assets/plugins/flag-icon-css/');

// sweetalert
    mix.copy('node_modules/sweetalert/dist/', 'public/assets/plugins/sweetalert/dist/');

// simple-line-icons
    mix.copy('node_modules/simple-line-icons/', 'public/assets/plugins/simple-line-icons/');

// lightbox2
    mix.copy('node_modules/lightbox2/dist/', 'public/assets/plugins/lightbox2/dist/');

// x-editable-bs4
    mix.copy('node_modules/x-editable-bs4/dist/', 'public/assets/plugins/x-editable-bs4/dist/');

// parsleyjs
    mix.copy('node_modules/parsleyjs/', 'public/assets/plugins/parsleyjs/');

// summernote
    mix.copy('node_modules/summernote/dist/', 'public/assets/plugins/summernote/dist/');

// select2
    mix.copy('node_modules/select2/dist/', 'public/assets/plugins/select2/dist/');

// dropzone
    mix.copy('node_modules/dropzone/dist/', 'public/assets/plugins/dropzone/dist/');

// bootstrap-select
    mix.copy('node_modules/bootstrap-select/', 'public/assets/plugins/bootstrap-select/');

// datatables
    mix.copy('node_modules/datatables.net/js/', 'public/assets/plugins/datatables.net/js/');
    mix.copy('node_modules/datatables.net-bs4/css/', 'public/assets/plugins/datatables.net-bs4/css/');
    mix.copy('node_modules/datatables.net-bs4/js/', 'public/assets/plugins/datatables.net-bs4/js/');
    mix.copy('node_modules/datatables.net-autofill/js/', 'public/assets/plugins/datatables.net-autofill/js/');
    mix.copy('node_modules/datatables.net-autofill-bs4/css/', 'public/assets/plugins/datatables.net-autofill-bs4/css/');
    mix.copy('node_modules/datatables.net-autofill-bs4/js/', 'public/assets/plugins/datatables.net-autofill-bs4/js/');
    mix.copy('node_modules/datatables.net-responsive/js/', 'public/assets/plugins/datatables.net-responsive/js/');
    mix.copy('node_modules/datatables.net-responsive-bs4/css/', 'public/assets/plugins/datatables.net-responsive-bs4/css/');
    mix.copy('node_modules/datatables.net-responsive-bs4/js/', 'public/assets/plugins/datatables.net-responsive-bs4/js/');
    mix.copy('node_modules/datatables.net-buttons/js/', 'public/assets/plugins/datatables.net-buttons/js/');
    mix.copy('node_modules/datatables.net-buttons-bs4/css/', 'public/assets/plugins/datatables.net-buttons-bs4/css/');
    mix.copy('node_modules/datatables.net-buttons-bs4/js/', 'public/assets/plugins/datatables.net-buttons-bs4/js/');
    mix.copy('node_modules/datatables.net-colreorder/js/', 'public/assets/plugins/datatables.net-colreorder/js/');
    mix.copy('node_modules/datatables.net-colreorder-bs4/css/', 'public/assets/plugins/datatables.net-colreorder-bs4/css/');
    mix.copy('node_modules/datatables.net-colreorder-bs4/js/', 'public/assets/plugins/datatables.net-colreorder-bs4/js/');
    mix.copy('node_modules/datatables.net-fixedcolumns/js/', 'public/assets/plugins/datatables.net-fixedcolumns/js/');
    mix.copy('node_modules/datatables.net-fixedcolumns-bs4/css/', 'public/assets/plugins/datatables.net-fixedcolumns-bs4/css/');
    mix.copy('node_modules/datatables.net-fixedcolumns-bs4/js/', 'public/assets/plugins/datatables.net-fixedcolumns-bs4/js/');
    mix.copy('node_modules/datatables.net-fixedheader/js/', 'public/assets/plugins/datatables.net-fixedheader/js/');
    mix.copy('node_modules/datatables.net-fixedheader-bs4/css/', 'public/assets/plugins/datatables.net-fixedheader-bs4/css/');
    mix.copy('node_modules/datatables.net-fixedheader-bs4/js/', 'public/assets/plugins/datatables.net-fixedheader-bs4/js/');
    mix.copy('node_modules/datatables.net-keytable/js/', 'public/assets/plugins/datatables.net-keytable/js/');
    mix.copy('node_modules/datatables.net-keytable-bs4/css/', 'public/assets/plugins/datatables.net-keytable-bs4/css/');
    mix.copy('node_modules/datatables.net-keytable-bs4/js/', 'public/assets/plugins/datatables.net-keytable-bs4/js/');
    mix.copy('node_modules/datatables.net-rowreorder/js/', 'public/assets/plugins/datatables.net-rowreorder/js/');
    mix.copy('node_modules/datatables.net-rowreorder-bs4/css/', 'public/assets/plugins/datatables.net-rowreorder-bs4/css/');
    mix.copy('node_modules/datatables.net-rowreorder-bs4/js/', 'public/assets/plugins/datatables.net-rowreorder-bs4/js/');
    mix.copy('node_modules/datatables.net-scroller/js/', 'public/assets/plugins/datatables.net-scroller/js/');
    mix.copy('node_modules/datatables.net-scroller-bs4/css/', 'public/assets/plugins/datatables.net-scroller-bs4/css/');
    mix.copy('node_modules/datatables.net-scroller-bs4/js/', 'public/assets/plugins/datatables.net-scroller-bs4/js/');
    mix.copy('node_modules/datatables.net-select/js/', 'public/assets/plugins/datatables.net-select/js/');
    mix.copy('node_modules/datatables.net-select-bs4/css/', 'public/assets/plugins/datatables.net-select-bs4/css/');
    mix.copy('node_modules/datatables.net-select-bs4/js/', 'public/assets/plugins/datatables.net-select-bs4/js/');
    mix.copy('node_modules/pdfmake/build/', 'public/assets/plugins/pdfmake/build/');
    mix.copy('node_modules/jszip/dist/', 'public/assets/plugins/jszip/dist/');

// plugins download from url
    mix.download({
        enabled: true,
        urls: [{
            'url': 'https://unpkg.com/ionicons@4.2.6/dist/css/ionicons.min.css',
            'dest': 'public/assets/plugins/ionicons/css/'
        }, {
            'url': 'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.eot',
            'dest': 'public/assets/plugins/ionicons/fonts/'
        }, {
            'url': 'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.woff2',
            'dest': 'public/assets/plugins/ionicons/fonts/'
        }, {
            'url': 'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.woff',
            'dest': 'public/assets/plugins/ionicons/fonts/'
        }, {
            'url': 'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.ttf',
            'dest': 'public/assets/plugins/ionicons/fonts/'
        }, {
            'url': 'https://unpkg.com/ionicons@4.2.6/dist/fonts/ionicons.svg',
            'dest': 'public/assets/plugins/ionicons/fonts/'
        }, {
            'url': 'https://raw.githubusercontent.com/smalot/bootstrap-datetimepicker/master/js/locales/bootstrap-datetimepicker.de.js',
            'dest': 'public/assets/plugins/bootstrap-datetimepicker/js/locales/'
        }, {
            'url': 'https://raw.githubusercontent.com/smalot/bootstrap-datetimepicker/master/js/locales/bootstrap-datetimepicker.fr.js',
            'dest': 'public/assets/plugins/bootstrap-datetimepicker/js/locales/'
        }, {
            'url': 'https://raw.githubusercontent.com/smalot/bootstrap-datetimepicker/master/js/locales/bootstrap-datetimepicker.ru.js',
            'dest': 'public/assets/plugins/bootstrap-datetimepicker/js/locales/'
        }, {
            'url': 'https://raw.githubusercontent.com/smalot/bootstrap-datetimepicker/master/js/locales/bootstrap-datetimepicker.ua.js',
            'dest': 'public/assets/plugins/bootstrap-datetimepicker/js/locales/'
        }, {
            'url': 'https://raw.githubusercontent.com/smalot/bootstrap-datetimepicker/master/js/locales/bootstrap-datetimepicker.uk.js',
            'dest': 'public/assets/plugins/bootstrap-datetimepicker/js/locales/'
        }]
    });

    mix
        .js('resources/js/backend/pages/pages.js', 'public/js/pages.js')
        .version();
    mix
        .js('resources/js/backend/pages/templates.js', 'public/js/templates.js')
        .version();

    mix.js([
        'resources/js/backend/app.js',
    ], 'public/js/backend.js').version()
}

backend(mix);
