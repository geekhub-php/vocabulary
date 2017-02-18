var gulp        = require('gulp'),
    gulpif      = require('gulp-if'),
    uglify      = require('gulp-uglify'),
    uglifycss   = require('gulp-uglifycss'),
    less        = require('gulp-less'),
    concat      = require('gulp-concat'),
    sourcemaps  = require('gulp-sourcemaps'),
    del         = require('del'),
    env         = process.env.GULP_ENV;

var Config = {
    path: {
        'source': 'web-src',
        'build': 'web'
    },
    mainCss: 'app.css',
    mainJs: 'app.js',
    jsFiles: [
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        'web-src/js/*.js',
        'web-src/js/**/*.js'
    ],
    cssFiles: [
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'web-src/less/*.less',
        'web-src/less/**/*.less'
    ],
    fontsFiles: [
        'bower_components/bootstrap/dist/fonts/*'
    ],
    ieFiles: [
        'bower_components/html5shiv/dist/html5shiv.min.js',
        'bower_components/respond/dest/respond.min.js'
    ]
};

// Clean task: Delete all
gulp.task('clean', function () {
    del.sync(['web/css', 'web/js', 'web/img', 'web/fonts']);
});

// JavaScript task: Write one minified js file
gulp.task('js', function () {
    return gulp.src(Config.jsFiles)
        .pipe(sourcemaps.init())
        .pipe(concat(Config.mainJs))
        .pipe(gulpif(env === 'prod', uglify()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(Config.path.build + '/js'));
});

// CSS task: Write one minified css file
gulp.task('css', function () {
    return gulp.src(Config.cssFiles)
        .pipe(sourcemaps.init())
        .pipe(gulpif(/[.]less/, less()))
        .pipe(concat(Config.mainCss))
        .pipe(gulpif(env === 'prod', uglifycss()))
        .pipe(sourcemaps.write('./'))
        .pipe(gulp.dest(Config.path.build + '/css'));
});

// Image task: Pipe images from project folder to public web folder
gulp.task('img', function() {
    return gulp.src(Config.path.source + '/img/**/*.*')
        .pipe(gulp.dest(Config.path.build + '/img'));
});

// Fonts task: Pipe fonts to public web folder
gulp.task('fonts', function() {
    return gulp.src(Config.fontsFiles)
        .pipe(gulp.dest(Config.path.build + '/fonts'));
});

// IE task: Pipe IE hacks to public web folder
gulp.task('ie', function() {
    return gulp.src(Config.ieFiles)
        .pipe(gulp.dest(Config.path.build + '/js/ie'));
});

// Default task when running 'gulp' command
gulp.task('default', ['clean'], function () {
    gulp.start(['js', 'css', 'img', 'fonts', 'ie'])
});

// Watch task
gulp.task('watch', ['default'], function () {
    gulp.watch(Config.path.source + '/less/*.less', ['css']);
    gulp.watch(Config.path.source + '/less/**/*.less', ['css']);
    gulp.watch(Config.path.source + '/js/*.js', ['js']);
    gulp.watch(Config.path.source + '/js/**/*.js', ['js']);
});
