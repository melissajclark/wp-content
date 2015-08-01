var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    sass = require('gulp-sass'),
    minifycss    = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    newer = require('gulp-newer');

// output minifined version of SCSS to theme
// ----------------------------------------
gulp.task('styles-min', function(){
  return gulp.src(['themes/starter-theme/scss/*.scss',
                   'themes/starter-theme/scss/**/*.scss'], 
            {base: 'themes/starter-theme/scss/'} )
      .pipe(plumber())
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(minifycss())
        .pipe(gulp.dest('themes/starter-theme/'));
});

// output regular version of CSS to assets
// --------------------------------------
gulp.task('styles', function(){
  return gulp.src(['themes/starter-theme/scss/*.scss',
                   'themes/starter-theme/scss/**/*.scss'], 
            {base: 'themes/starter-theme/scss/'} )
      .pipe(plumber())
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(gulp.dest('themes/starter-theme/assets/css/'));
});

gulp.task('watch', function() {
      gulp.watch('themes/starter-theme/**/*.scss', ['styles']);
});


gulp.task('default', ['styles', 'styles-min', 'watch']);