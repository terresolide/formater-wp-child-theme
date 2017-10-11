var gulp = require('gulp');
var less = require('gulp-less');
var minijs = require('gulp-minify');
var cleancss = require('gulp-clean-css');
var minisvg = require('gulp-pretty-data');

gulp.task('default', function() {
	  console.log("Ne fait rien");
	});


gulp.task('lessify', function(){
	 gulp.src('style.less')
   .pipe(less())
   .pipe(gulp.dest(''));
	
});

gulp.task('compress', function(){
	
	gulp.src('css/manage-svg.css')
	.pipe(cleancss())
	.pipe(gulp.dest('dist'));
	gulp.src('js/manage-svg.js')
	.pipe(minijs())
	.pipe(gulp.dest('dist'));
})

//gulp.task('minixml', function(){
//	
//	gulp.src('svg/coordination_diffusion.svg')
//	.pipe(minisvg( {
//	      type: 'minify',
//	      preserveComments: true
//	     }))
//	.pipe(gulp.dest('dist'));
//})