//gulpfile.js
'use strict';

var gulp = require('gulp'),
  sass = require('gulp-sass'),
  prefixer = require('gulp-autoprefixer'),
  sourcemaps = require('gulp-sourcemaps'),
  cssmin = require('gulp-minify-css'),
  cleanCSS = require('gulp-clean-css'),
  // watch = require('gulp-watch'),
  browserSync = require("browser-sync"),
  plumber = require("gulp-plumber"),
  uglify = require('gulp-uglify'),
  concat = require('gulp-concat'),
  criticalCss = require('gulp-penthouse'),
  reload = browserSync.reload;

var path = {
  build: {
    css: 'assets/css',
    js: 'assets/js',
    critical: 'assets/css/main.css',
  },
  src: {
    style: 'src/sass/**/*.scss',
    js: 'src/js/**/*.js'
  },
  watch: {
    style: 'src/sass/**/*.scss',
    js: 'src/js/**/*.js'
  }
}

function css() {
  return gulp.src(path.src.style)
    .pipe(sourcemaps.init())
    .pipe(sass())
    .pipe(prefixer())
    // .pipe(cleanCSS())
    // .pipe(cssmin())
    .pipe(concat('main.css'))
    .pipe(sourcemaps.write())
    .pipe(gulp.dest(path.build.css))
    .pipe(reload({stream: true}));
}

// minify scripts
function scripts() {
  return (
    gulp
      .src(path.src.js)
      // .pipe(uglify())
      .pipe(concat('main.js'))
      .pipe(gulp.dest(path.build.js))
  );
}


function watcher() {
    gulp.watch([path.watch.style], css);
    gulp.watch([path.watch.js], scripts);
}

const watch = gulp.parallel(watcher);
exports.watch = watch;

// Move the javascript files into our /src/js folder
gulp.task('js', function () {
  return gulp.src([
      // 'node_modules/bootstrap/dist/js/bootstrap.min.js',
      // 'node_modules/vivus/src/vivus.js',
      // 'node_modules/vivus/src/pathformer.js',
      // 'node_modules/inputmask/dist/min/inputmask/inputmask.min.js'
  ])
    .pipe(gulp.dest(path.build.js));
});

// critical css
gulp.task('critical-css', function () {
  return gulp.src('assets/css/main.css')
    .pipe(criticalCss({
      out: '/critical.css', // output file name
      url: '/', // url from where we want penthouse to extract critical styles
      width: 2560, // max window width for critical media queries
      height: 900, // max window height for critical media queries
      forceInclude: [ // selectors to keep, useful for above-the-fold styles added by js scripts
        '.keepMeEvenIfNotSeenInDom',
        /^\.regexWorksToo/
      ],
      propertiesToRemove: [
        '(.*)transition(.*)',
        'cursor',
        'pointer-events',
        '(-webkit-)?tap-highlight-color',
        '(.*)user-select'
      ],
      userAgent: 'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)' // pretend to be googlebot when grabbing critical page styles.
    }))
    .pipe(cssmin())
    .pipe(gulp.dest(path.build.css)); // destination folder for the output file
});

gulp.task('default_css', function () {
  return gulp.src('style.css')
    .pipe(cssmin())
    .pipe(gulp.dest('.'));
});