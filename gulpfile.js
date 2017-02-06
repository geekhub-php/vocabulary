var gulp = require('gulp'),
    less = require('gulp-less'),
    clean = require('gulp-clean');
gulp.task('less', function() {
    return gulp.src(['web-src/less/*.less'])
        .pipe(less({compress: true}))
        .pipe(gulp.dest('web/css/'));
});
gulp.task('images', function () {
    return gulp.src([
        'web-src/images/*'
    ])
        .pipe(gulp.dest('web/images/'))
});
gulp.task('js', function () {
    return gulp.src([
        'web-src/js/*'
    ])
        .pipe(gulp.dest('web/js/'))
});
gulp.task('fonts', function () {
    return gulp.src(['bower_components/bootstrap/fonts/*'])
        .pipe(gulp.dest('web/fonts/'))
});
gulp.task('clean', function () {
    return gulp.src(['web/css/*', 'web/js/*', 'web/images/*', 'web/fonts/*'])
        .pipe(clean());
});
gulp.task('default', ['clean'], function () {
    var tasks = ['images','js', 'fonts', 'less'];
    tasks.forEach(function (val) {
        gulp.start(val);
    });
});
gulp.task('watch', function () {
    var less = gulp.watch('web-src/less/*.less', ['less']);
});