var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    sass = require('gulp-ruby-sass'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss = require('gulp-minify-css'),
    newer = require('gulp-newer'),
    imagemin = require('gulp-imagemin'),
    livereload = require('gulp-livereload'),
    lr = require('tiny-lr'),
    server = lr();
 
    
gulp.task('styles', function(){
  return gulp.src('themes/starter-theme/scss/style.scss', {base: 'scss'})
      .pipe(plumber())
      .pipe(sass({ style: 'expanded' }))
      .pipe(gulp.dest(''))
      .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
      .pipe(minifycss())
      .pipe(gulp.dest(''))
      .pipe(livereload(server));
});
 
 
var imgSrc = 'themes/starter-theme/assets/images/originals/*';
var imgDest = 'themes/starter-theme/assets/images';
 
gulp.task('images', function() {
  return gulp.src(imgSrc, {base: 'themes/starter-theme/assets/images/originals'})
        .pipe(newer(imgDest))
        .pipe(imagemin({ optimizationLevel: 3, progressive: true, interlaced: true }))
        .pipe(gulp.dest(imgDest));
});
 
gulp.task('default', ['styles', 'images']);
 
gulp.task('watch', function() {
  // Listen on port 35729
  server.listen(35729, function (err) {
      if (err) {
        return console.log(err)
      };
  
      // Watch .scss files
      gulp.watch('themes/starter-theme/scss/*.scss', ['styles']);
      gulp.watch('themes/starter-theme/scss/**/*.scss', ['styles']);
      gulp.watch('themes/starter-theme/assets/images/originals/**', ['images']);
  
    });
 
});