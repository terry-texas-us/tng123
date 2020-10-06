const gulp = require('gulp');

const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync').create();
const sourcemaps = require('gulp-sourcemaps');
// const rename = require('gulp-rename');
const sass = require('gulp-sass');
// const postcss = require('gulp-postcss');
const cssnano = require('gulp-cssnano');

function defaultTask(cb) {
    // body ommitted
    cb();
}

exports.default = defaultTask

function processCSS() {
    return gulp.src('css/*.scss')
        .pipe(sourcemaps.init())
        .pipe(autoprefixer())
        .pipe(cssnano({zindex: false, colormin: false}))
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        // .pipe(rename({extname: '.css'}))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./css'));
}

exports.processCSS = processCSS;


function processTemplates() {
    return gulp.src('templates/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(autoprefixer())
        .pipe(cssnano({zindex: false, colormin: false}))
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        // .pipe(rename({extname: '.css'}))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./templates'));
}

exports.processTemplates = processTemplates;
