var gulp = require('gulp'),
	cleanCSS = require('gulp-clean-css'),
	sass = require('gulp-sass'),
	livereload = require('gulp-livereload'),
	connect = require('gulp-connect');

gulp.task('connect', function() {
	connect.server({	
		livereload: true
	})
})

gulp.task('convertCss', function() {
    gulp.src('scss/styles.scss')
		.pipe(sass())
		.pipe(gulp.dest("css"))
		.pipe(connect.reload())
	gulp.src('css/styles.css')
    	.pipe(cleanCSS({compatibility: 'ie8'}))
		.pipe(gulp.dest('css/min'))
		.pipe(connect.reload())
});

gulp.task('html', function() {
	gulp.src('index.php')
		.pipe(connect.reload())
});

gulp.task('default', ['watch', 'convertCss', 'html', 'connect']);

gulp.task('watch', function() {
	gulp.watch('scss/styles.scss', ['convertCss']);
	gulp.watch('index.php', ['html']);
});