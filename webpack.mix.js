const { mix } = require('laravel-mix');
mix.js('resources/assets/js/app.js', 'public/js');
if (mix.config.inProduction) {
    mix.version();
}
