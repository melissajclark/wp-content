var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    sass = require('gulp-sass'),
    minifycss    = require('gulp-minify-css'),
    autoprefixer = require('gulp-autoprefixer'),
    newer = require('gulp-newer');

gulp.task('styles', function(){
  return gulp.src(['themes/starter-theme/assets/scss/*.scss',
                   'themes/starter-theme/assets/scss/**/*.scss'], 
            {base: 'themes/starter-theme/assets/scss/'} )
      .pipe(plumber())
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        // .pipe(minifycss())
        .pipe(gulp.dest('themes/starter-theme'));
});


gulp.task('watch', function() {
      gulp.watch('themes/starter-theme/assets/scss/*.scss', ['styles']);
      gulp.watch('themes/starter-theme/assets/scss/**/*.scss', ['styles']);
});

gulp.task('default', ['styles', 'watch' ]);