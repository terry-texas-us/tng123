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
    return src('src/styles/genstyle.css')
        .pipe(purgecss({
            content: ['**/*.php']
        }))
        .pipe(dest('./src/styles/purged'))
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
        'src/styles/genstyle.css', 'src/styles/tngtabs2.css', 'src/styles/admin.css', 'src/styles/calendar.css', 'src/styles/cemeteries.css', 'src/styles/media.css', 'src/styles/verticalchart.css'])
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

function buildTemplate1MobileStyleTask() {
    return src('templates/Template1/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template1/styles')
        )
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

function buildTemplate2MobileStyleTask() {
    return src('templates/Template2/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template2/styles')
        )
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

function buildTemplate3MobileStyleTask() {
    return src('templates/Template3/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template3/styles')
        )
}

function buildTemplate4StyleTask() {
    return src(['templates/template4/styles/templatestyle.css', 'templates/template4/styles/tngtabs2.css', 'templates/template4/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template4/styles')
        );
}

function buildTemplate4MobileStyleTask() {
    return src('templates/Template4/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template4/styles')
        )
}

function buildTemplate5StyleTask() {
    return src(['templates/template5/styles/templatestyle.css', 'templates/template5/styles/tngtabs2.css', 'templates/template5/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template5/styles')
        );
}

function buildTemplate5MobileStyleTask() {
    return src('templates/Template5/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template5/styles')
        )
}

function buildTemplate6StyleTask() {
    return src(['templates/template6/styles/templatestyle.css', 'templates/template6/styles/tngtabs2.css', 'templates/template6/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template6/styles')
        );
}

function buildTemplate6MobileStyleTask() {
    return src('templates/Template6/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template6/styles')
        )
}

function buildTemplate7StyleTask() {
    return src(['templates/template7/styles/templatestyle.css', 'templates/template7/styles/tngtabs2.css', 'templates/template7/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template7/styles')
        );
}

function buildTemplate7MobileStyleTask() {
    return src('templates/Template7/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template7/styles')
        )
}

function buildTemplate8StyleTask() {
    return src(['templates/template8/styles/templatestyle.css', 'templates/template8/styles/tngtabs2.css', 'templates/template8/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template8/styles')
        );
}

function buildTemplate8MobileStyleTask() {
    return src('templates/Template8/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template8/styles')
        )
}

function buildTemplate9StyleTask() {
    return src(['templates/template9/styles/templatestyle.css', 'templates/template9/styles/tngtabs2.css', 'templates/template9/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template9/styles')
        );
}

function buildTemplate9MobileStyleTask() {
    return src('templates/Template9/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template9/styles')
        )
}

function buildTemplate10StyleTask() {
    return src(['templates/template10/styles/templatestyle.css', 'templates/template10/styles/tngtabs2.css', 'templates/template10/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template10/styles')
        );
}

function buildTemplate10MobileStyleTask() {
    return src('templates/Template10/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template10/styles')
        )
}

function buildTemplate11StyleTask() {
    return src(['templates/template11/styles/templatestyle.css', 'templates/template11/styles/tngtabs2.css', 'templates/template11/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template11/styles')
        );
}

function buildTemplate11MobileStyleTask() {
    return src('templates/Template11/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template11/styles')
        )
}

function buildTemplate12StyleTask() {
    return src(['templates/template12/styles/templatestyle.css', 'templates/template12/styles/tngtabs2.css', 'templates/template12/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template12/styles')
        );
}

function buildTemplate12MobileStyleTask() {
    return src('templates/Template12/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template12/styles')
        )
}

function buildTemplate13StyleTask() {
    return src(['templates/template13/styles/templatestyle.css', 'templates/template13/styles/tngtabs2.css', 'templates/template13/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template13/styles')
        );
}

function buildTemplate13MobileStyleTask() {
    return src('templates/Template13/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template13/styles')
        )
}

function buildTemplate14StyleTask() {
    return src(['templates/template14/styles/templatestyle.css', 'templates/template14/styles/tngtabs2.css', 'templates/template14/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template14/styles')
        );
}

function buildTemplate14MobileStyleTask() {
    return src('templates/Template14/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template14/styles')
        )
}

function buildTemplate15StyleTask() {
    return src(['templates/template15/styles/templatestyle.css', 'templates/template15/styles/tngtabs2.css', 'templates/template15/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template15/styles')
        );
}

function buildTemplate15MobileStyleTask() {
    return src('templates/Template15/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template15/styles')
        )
}

function buildTemplate16StyleTask() {
    return src(['templates/template16/styles/templatestyle.css', 'templates/template16/styles/tngtabs2.css', 'templates/template16/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template16/styles')
        );
}

function buildTemplate16MobileStyleTask() {
    return src('templates/Template16/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template16/styles')
        )
}

function buildTemplate17StyleTask() {
    return src(['templates/template17/styles/templatestyle.css', 'templates/template17/styles/tngtabs2.css', 'templates/template17/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template17/styles')
        );
}

function buildTemplate17MobileStyleTask() {
    return src('templates/Template17/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template17/styles')
        )
}

function buildTemplate18StyleTask() {
    return src(['templates/template18/styles/templatestyle.css', 'templates/template18/styles/tngtabs2.css', 'templates/template18/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template18/styles')
        );
}

function buildTemplate18MobileStyleTask() {
    return src('templates/Template18/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template18/styles')
        )
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

function buildTemplate19MobileStyleTask() {
    return src('templates/Template19/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template19/styles')
        )
}

function buildTemplate20StyleTask() {
    return src(['templates/template20/styles/templatestyle.css', 'templates/template20/styles/tngtabs2.css', 'templates/template20/styles/mytngstyle.css'])
        .pipe(sourcemaps.init())
        .pipe(concat('style.css'))
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template20/styles')
        );
}

function buildTemplate20MobileStyleTask() {
    return src('templates/Template20/styles/tngmobile.css')
        .pipe(sourcemaps.init())
        .pipe(postcss([autoprefixer(), cssnano()]))
        .pipe(sourcemaps.write('.'))
        .pipe(dest('./build/template20/styles')
        )
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
            parallel(buildStyleTask, buildImgViewerStyleTask, buildModManagerStyleTask, buildTimelineStyleTask, buildTngMobileStyleTask, buildTngPrintStyleTask,
                buildTemplate1StyleTask, buildTemplate2StyleTask, buildTemplate3StyleTask, buildTemplate4StyleTask, buildTemplate5StyleTask, buildTemplate6StyleTask, buildTemplate7StyleTask, buildTemplate8StyleTask, buildTemplate9StyleTask, buildTemplate10StyleTask,
                buildTemplate11StyleTask, buildTemplate12StyleTask, buildTemplate13StyleTask, buildTemplate14StyleTask, buildTemplate15StyleTask, buildTemplate16StyleTask, buildTemplate17StyleTask, buildTemplate18StyleTask, buildTemplate19StyleTask, buildTemplate20StyleTask,
                buildTemplate1MobileStyleTask, buildTemplate2MobileStyleTask, buildTemplate3MobileStyleTask, buildTemplate4MobileStyleTask, buildTemplate5MobileStyleTask, buildTemplate6MobileStyleTask, buildTemplate7MobileStyleTask, buildTemplate8MobileStyleTask, buildTemplate9MobileStyleTask, buildTemplate10MobileStyleTask,
                buildTemplate11MobileStyleTask, buildTemplate12MobileStyleTask, buildTemplate13MobileStyleTask, buildTemplate14MobileStyleTask, buildTemplate15MobileStyleTask, buildTemplate16MobileStyleTask, buildTemplate17MobileStyleTask, buildTemplate18MobileStyleTask, buildTemplate19MobileStyleTask, buildTemplate20MobileStyleTask
            )


            // cacheBustTask
        )
    );
}

exports.purgecssTask = purgecssTask;
exports.imagesTask = imagesTask;
exports.imagesTemplatesTask = imagesTemplatesTask;
exports.buildStyleTask = buildStyleTask;
exports.buildTemplate1StyleTask = buildTemplate1StyleTask;
exports.default = series(
    parallel(buildStyleTask, buildImgViewerStyleTask, buildModManagerStyleTask, buildTimelineStyleTask, buildTngMobileStyleTask, buildTngPrintStyleTask,
        buildTemplate1StyleTask, buildTemplate2StyleTask, buildTemplate3StyleTask, buildTemplate4StyleTask, buildTemplate5StyleTask, buildTemplate6StyleTask, buildTemplate7StyleTask, buildTemplate8StyleTask, buildTemplate9StyleTask, buildTemplate10StyleTask,
        buildTemplate11StyleTask, buildTemplate12StyleTask, buildTemplate13StyleTask, buildTemplate14StyleTask, buildTemplate15StyleTask, buildTemplate16StyleTask, buildTemplate17StyleTask, buildTemplate18StyleTask, buildTemplate19StyleTask, buildTemplate20StyleTask,
        buildTemplate1MobileStyleTask, buildTemplate2MobileStyleTask, buildTemplate3MobileStyleTask, buildTemplate4MobileStyleTask, buildTemplate5MobileStyleTask, buildTemplate6MobileStyleTask, buildTemplate7MobileStyleTask, buildTemplate8MobileStyleTask, buildTemplate9MobileStyleTask, buildTemplate10MobileStyleTask,
        buildTemplate11MobileStyleTask, buildTemplate12MobileStyleTask, buildTemplate13MobileStyleTask, buildTemplate14MobileStyleTask, buildTemplate15MobileStyleTask, buildTemplate16MobileStyleTask, buildTemplate17MobileStyleTask, buildTemplate18MobileStyleTask, buildTemplate19MobileStyleTask, buildTemplate20MobileStyleTask
    ),
    // cacheBustTask,
    watchTask
);
