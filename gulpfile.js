const {src, dest, watch, series, parallel} = require('gulp');
const sourcemaps = require('gulp-sourcemaps');
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
const purgecss = require('gulp-purgecss');
const tailwindcss = require('tailwindcss');

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

function cssTask() {
    return src('src/styles/*.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build')
        );
}

function buildStyleTask() {
    return src([
        'node_modules/tailwindcss/dist/base.css', 'node_modules/tailwindcss/dist/components.css', 'node_modules/tailwindcss/dist/utilities.css',
        'src/styles/genstyle.css', 'src/styles/admin.css', 'src/styles/calendar.css', 'src/styles/cemeteries.css', 'src/styles/media.css', 'src/styles/verticalchart.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/styles')
        );
}

function buildImgViewerStyleTask() {
    return src('src/styles/img_viewer.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/styles')
        )
}

function buildTimelineStyleTask() {
    return src('src/styles/timeline.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/styles')
        )
}

function buildTngMobileStyleTask() {
    return src('src/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/styles')
        )
}

function buildModManagerStyleTask() {
    return src('src/styles/modmanager.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/styles')
        )
}

function buildTngPrintStyleTask() {
    return src('src/styles/tngprint.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/styles')
        )
}

function buildTemplate1StyleTask() {
    return src(['templates/template1/styles/templatestyle.css', 'templates/template1/styles/tngtabs2.css', 'templates/template1/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template1/styles')
        );
}

function buildTemplate2StyleTask() {
    return src(['templates/template2/styles/templatestyle.css', 'templates/template2/styles/tngtabs2.css', 'templates/template2/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template2/styles')
        );
}

function buildTemplate3StyleTask() {
    return src(['templates/template3/styles/templatestyle.css', 'templates/template3/styles/tngtabs2.css', 'templates/template3/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template3/styles')
        );
}

function buildTemplate19StyleTask() {
    return src(['templates/template19/styles/templatestyle.css', 'templates/template19/styles/tngtabs2.css', 'templates/template19/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template19/styles')
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
    watch(['src/styles/**/*.css', 'src/js/**/*.js'],
        series(
            parallel(buildStyleTask, buildImgViewerStyleTask, buildModManagerStyleTask, buildTimelineStyleTask, buildTngMobileStyleTask, buildTngPrintStyleTask, buildTemplate1StyleTask, buildTemplate2StyleTask, buildTemplate3StyleTask, buildTemplate19StyleTask),
            // cacheBustTask
        )
    );
}

exports.imagesTask = imagesTask;
exports.imagesTemplatesTask = imagesTemplatesTask;
exports.buildStyleTask = buildStyleTask;
exports.buildTemplate1StyleTask = buildTemplate1StyleTask;
exports.default = series(
    parallel(buildStyleTask, buildImgViewerStyleTask, buildModManagerStyleTask, buildTimelineStyleTask, buildTngMobileStyleTask, buildTngPrintStyleTask, buildTemplate1StyleTask, buildTemplate2StyleTask, buildTemplate3StyleTask, buildTemplate19StyleTask),
    // cacheBustTask,
    watchTask
);
