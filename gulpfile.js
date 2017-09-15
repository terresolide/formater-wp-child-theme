var gulp = require('gulp');
var less = require('gulp-less');

gulp.task('default', function() {
	  console.log("Ne fait rien");
	});


gulp.task('lessify', function(){
	 gulp.src('style.less')
   .pipe(less())
   .pipe(gulp.dest(''));
	
});