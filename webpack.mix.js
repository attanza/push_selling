const { mix } = require('laravel-mix');
mix.js('resources/assets/js/app.js', 'public/js').version();
if (mix.config.inProduction) {
    mix.version();
}
