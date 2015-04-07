var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    sass = require('gulp-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    uglify = require('gulp-uglifyjs'),
    newer = require('gulp-newer');

gulp.task('styles', function(){
  return gulp.src(['themes/starter-theme/scss/*.scss',
                   'themes/starter-theme/scss/**/*.scss'], 
            {base: 'themes/starter-theme/scss/'} )
      .pipe(plumber())
        .pipe(sass({ style: 'expanded' }))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe(gulp.dest('themes/starter-theme'));
});

gulp.task('watch', function() {
      // Watch .scss files
      gulp.watch('themes/starter-theme/scss/*.scss', ['styles']);
      gulp.watch('themes/starter-theme/scss/**/*.scss', ['styles']);
});

gulp.task('uglify', function() {
  gulp.src('themes/starter-theme/assets/js/*.js')
    .pipe(uglify('themes/starter-theme/assets/js/scripts.min.js', {
      outSourceMap: false
    }))
});


gulp.task('default', ['styles', 'uglify', 'watch', ]);