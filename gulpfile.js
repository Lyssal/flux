var gulp = require('gulp'),
    cleanCss = require('gulp-clean-css'),
    concat = require('gulp-concat'),
    plumber = require('gulp-plumber'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    watch = require('gulp-watch')
;

gulp.task('css', function () {
    return gulp
        .src('assets/styles/app.scss')
        .pipe(plumber())
        .pipe(sass({
            includePaths: [
                'node_modules/foundation-sites/scss',
                'node_modules/font-awesome/scss'
            ]
        }))
        .pipe(cleanCss())
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('public/css'))
    ;
});

gulp.task('js', function () {
    return gulp
        .src([
            'node_modules/jquery/dist/jquery.min.js',
            'node_modules/foundation-sites/dist/js/foundation.min.js',
            'node_modules/lyssal-lib-web/src/ajax-page-loader.js',
            'node_modules/lyssal-lib-web/src/blinking.js',
            'node_modules/lyssal-lib-web/src/navigation.js',
            'assets/scripts/app.js'
        ])
        .pipe(plumber())
        .pipe(sourcemaps.write())
        .pipe(uglify())
        .pipe(concat('app.js'))
        .pipe(gulp.dest('public/js'))
    ;
});

gulp.task('fonts', function () {
  return gulp
    .src([
        'node_modules/font-awesome/fonts/*'
    ])
    .pipe(gulp.dest('public/fonts'))
  ;
});

gulp.task('watch', function () {
    gulp.watch('assets/styles/**/*.scss', ['css']);
    gulp.watch('assets/scripts/**/*.js', ['js']);
});

gulp
    .task('default', ['css', 'js', 'fonts'])
    .task('dev', ['default', 'watch'])
;
