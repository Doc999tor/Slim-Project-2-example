var gulp        = require('gulp'),
    php         = require('gulp-connect-php'),
	watch       = require('gulp-watch'),
	browserSync = require("browser-sync").create(),
	reload      = browserSync.reload;

var config = {
    proxy: '127.0.0.1:3000',
	port: 9000,
	open: true
};

gulp.task('watch', function () {
	gulp.watch([
		'*.*',
		'lib/**/*.*',
		'views/**/*.*',
		'public/**/*.*',
		'!node_modules/**/*.*',
	]).on('change', reload);
});

gulp.task('default', ['php', 'watch'], function () {
	browserSync.init(config);
});

gulp.task('php', function() {
    php.server({base: ".", port: 3000, keepalive: true});
});