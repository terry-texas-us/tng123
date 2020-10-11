const {src, dest, watch, series, parallel} = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const replace = require('gulp-replace');

// const browserSync = require('browser-sync').create();
// const rename = require('gulp-rename');

const files = {
    scssPath: 'scss/**/*.scss',
    jsPath: 'js/**/*.js'
}

function scssTask() {
    return src(files.scssPath)
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./css')
        );
}

function jsTask() {
    return src([
        files.jsPath
        //,'!' + 'includes/js/jquery.min.js', // to exclude any specific files
    ])
        .pipe(concat('all.js'))
        .pipe(uglify())
        .pipe(dest('dist')
        );
}

function cacheBustTask() {
    var cbString = new Date().getTime();
    return src(['index.html'])
        .pipe(replace(/cb=\d+/g, 'cb=' + cbString))
        .pipe(dest('.'));
}

function watchTask() {
    watch([files.scssPath, files.jsPath],
        series(
            parallel(scssTask, jsTask),
            cacheBustTask
        )
    );
}

exports.scssTask = scssTask;

exports.default = series(
    parallel(scssTask, jsTask),
    cacheBustTask,
    watchTask
);
