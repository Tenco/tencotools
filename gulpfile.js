var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    
    /**
    *    Elixir is looking in "resources/[css|js] 
    *    and output goes to "public/[css|js].
    */

	mix.styles([
        "bootstrap.min.css",
        "bootstrap-glyphicons.css",
        "dragula.css",
        "custom.css",
        //"sweetalert.css",
    ])
    .scripts([
        "jquery.min.js",
        "bootstrap.min.js",
        "custom.js"
    ]);
});
