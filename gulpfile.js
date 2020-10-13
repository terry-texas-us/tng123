const {src, dest, watch, series, parallel} = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
const sass = require('gulp-sass');
const concat = require('gulp-concat');
const uglify = require('gulp-uglify');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const replace = require('gulp-replace');
const newer = require('gulp-newer');
const size = require('gulp-size');
const imagemin = require('gulp-imagemin');

// const browserSync = require('browser-sync').create();
// const rename = require('gulp-rename');

const purgecss = require('gulp-purgecss')

function purgecssTask() {
    return src('build/genstyle.css')
        .pipe(purgecss({
            content: ['**/*.php']
        }))
        .pipe(purgecss({
            content: ['**/*.js']
        }))
        .pipe(dest('build/purged'))
}

exports.purgecssTask = purgecssTask;

function imagesTask() {
    return src('img/*')
        .pipe(newer('./build/img'))
        .pipe(imagemin({
            optimizationLevel: 5
        }))
        .pipe(size({showFiles: true}))
        .pipe(dest('./build/img'));

}

function imagesTemplatesTask() {
    return src('templates/**/img/*')
        .pipe(newer('./build'))
        .pipe(imagemin({
            optimizationLevel: 5
        }))
        .pipe(size({showFiles: true}))
        .pipe(dest('./build'));

}

function scssTask() {
    return src('scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build')
        );
}

function scssTemplatesTask() {
    return src('templates/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass({outputStyle: 'expanded'}))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build')
        );
}

function jsTask() {
    return src([
        'js/**/*.js'
        //,'!' + 'includes/js/jquery.min.js', // to exclude any specific files
    ])
        .pipe(concat('all.js'))
        .pipe(uglify())
        .pipe(dest('./build')
        );
}

function cacheBustTask() {
    var cbString = new Date().getTime();
    return src(['index.html'])
        .pipe(replace(/cb=\d+/g, 'cb=' + cbString))
        .pipe(dest('.'));
}

function watchTask() {
    watch(['scss/**/*.scss', 'js/**/*.js'],
        series(
            parallel(scssTask, jsTask),
            cacheBustTask
        )
    );
}

exports.imagesTask = imagesTask;
exports.imagesTemplatesTask = imagesTemplatesTask;
exports.scssTask = scssTask;
exports.scssTemplatesTask = scssTemplatesTask;

exports.default = series(
    parallel(scssTask, jsTask),
    cacheBustTask,
    watchTask
);
