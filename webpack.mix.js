const mix = require('laravel-mix');
const ngrok = require('ngrok');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .version();

mix.browserSync({
  proxy: 'vinylshop7.lrv',
  port: 3000,
  callbacks: {
    ready:async function (err, bs) {
      const tunnel = await ngrok.connect({
          port: bs.options.get('port'),
          region: 'eu'
      });
      console.log(' ------------------------------------------------');
      console.log(`  ngrok control panel: http://localhost:4040`);
      console.log(`  public URL running at: ${tunnel}`);
      console.log(' ------------------------------------------------');
    }
  }
});

mix.disableNotifications();