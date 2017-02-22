var gulp = require('gulp');
var gulpif = require('gulp-if');
var uglify = require('gulp-uglify');
var uglifycss = require('gulp-uglifycss');
var less = require('gulp-less');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var exec = require('child_process').exec;

// Minify JS
gulp.task('js', function () {
    return gulp.src(['bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js'])
        .pipe(concat('javascript.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/minified/js'));
});

// Minify CSS
gulp.task('css', function () {
    return gulp.src([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'src/AppBundle/Resources/public/less/*.less',
        'src/AppBundle/Resources/public/sass/*.scss',
        'src/AppBundle/Resources/public/css/*.css'])
        .pipe(gulpif(/[.]less/, less()))
        .pipe(gulpif(/[.]scss/, sass()))
        .pipe(concat('styles.css'))
        .pipe(uglifycss())
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest('web/minified/css'));
});

// Copy Fonts
gulp.task('fonts', function() {
    return gulp.src('bower_components/bootstrap/fonts/*.{ttf,woff,woff2,eof,svg}')
    .pipe(gulp.dest('web/minified/fonts'));
});

gulp.task('installAssets', function() {
    exec('./scripts/console assets:install --symlink', logStdOutAndErr);
});

//define executable tasks when running "gulp" command
gulp.task('default', ['js', 'css', 'fonts', 'installAssets']);

gulp.task('watch', function () {
    var onChange = function (event) {
        console.log('File '+event.path+' has been '+event.type);
    };
    gulp.watch('src/AppBundle/Resources/public/js/*.js', ['default'])
        .on('change', onChange);

    gulp.watch('src/AppBundle/Resources/public/less/*.less', ['default'])
        .on('change', onChange);

    gulp.watch('src/AppBundle/Resources/public/sass/*.scss', ['default'])
        .on('change', onChange);

    gulp.watch('src/AppBundle/Resources/public/css/*.css', ['default'])
        .on('change', onChange);
});

// show exec output
var logStdOutAndErr = function (err, stdout, stderr) {
    console.log(stdout + stderr);
};
