const { src, dest, lastRun, watch, parallel, series } = require('gulp');
const gulpSass = require('gulp-sass');
const concat = require('gulp-concat');
const gulpPostCss = require('gulp-postcss');
const minifyCss = require('gulp-clean-css');
const uglify = require('gulp-uglify');
const cssMqpacker = require('css-mqpacker');
const autoprefixer = require('autoprefixer');
const imagemin = require('gulp-imagemin');
const cached = require('gulp-cached');
const remember = require('gulp-remember');
const del = require('del');
const tildeImporter = require('node-sass-tilde-importer');
const util = require('gulp-util');
const fs = require('fs');
const path = require('path');
const isProduction = !!util.env.production;

// Récupère le numéro de version de l'application
if (fs.existsSync('./VERSION') !== true) {
    console.error('Could not find VERSION file!');
    throw 'Could not find VERSION file!';
}
const applicationVersion = fs.readFileSync('./VERSION', 'utf8');

function clean() {
    return del(['public/' + applicationVersion]);
}

function applicationScss() {
    let files = [
        'asset/scss/application/main.scss',
    ];

    return src(files, { sourcemaps: ! isProduction })
        .pipe(gulpSass({
            importer: tildeImporter
        }))
        .pipe(gulpPostCss([
            autoprefixer(),
            // Tri les media-queries dans l'ordre ascendant sur la
            // propriété "min-width"
            cssMqpacker({
                sort: true,
            })
        ]))
        .pipe(concat('application.css'))
        .pipe(isProduction ? minifyCss() : util.noop())
        .pipe(dest('public/' + applicationVersion + '/css', { sourcemaps: ! isProduction }));
    ;
}

function applicationJs() {
    let files = [
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'asset/js/application/**/*.js',
    ];

    return src(files, { sourcemaps: true })
        .pipe(concat('application.js'))
        .pipe(isProduction ? uglify() : util.noop())
        .pipe(dest('public/' + applicationVersion + '/js'));
}

function images() {
    return src("asset/img/**/*")
        .pipe(cached('images'))
        .pipe(
            imagemin([
                imagemin.gifsicle({ interlaced: true }),
                imagemin.jpegtran({ progressive: true }),
                imagemin.optipng({ optimizationLevel: 5 }),
                imagemin.svgo({
                    plugins: [{
                        removeViewBox: false,
                        collapseGroups: true
                    }]
                })
            ])
        )
        .pipe(remember('images'))
        .pipe(dest('public/' + applicationVersion + '/img'));
}

function favicon() {
    let files = [
        'asset/favicon/**/*',
        '!asset/favicon/.gitkeep',
    ];

    return src(files)
        .pipe(cached('favicon'))
        .pipe(
            imagemin([
                imagemin.gifsicle({ interlaced: true }),
                imagemin.jpegtran({ progressive: true }),
                imagemin.optipng({ optimizationLevel: 5 }),
                imagemin.svgo({
                    plugins: [{
                        removeViewBox: false,
                        collapseGroups: true
                    }]
                })
            ])
        )
        .pipe(remember('favicon'))
        .pipe(dest('public/' + applicationVersion + '/'));
}

function watchFiles() {
    watch("asset/scss/**/*", { ignoreInitial: false }, applicationScss);
    watch("asset/js/**/*", { ignoreInitial: false }, applicationJs);
    watch("asset/img/**/*", { ignoreInitial: false }, images)
        .on("unlink", function (filepath) {
            var splitedPath = filepath.split('/');
            splitedPath.shift();
            remember.forget('images', path.resolve(filepath));
            delete cached.caches['images'][filepath];
            del(path.resolve('public/' + applicationVersion + '/' + splitedPath.join('/')));
        });
    watch("asset/favicon/**/*", { ignoreInitial: false }, favicon)
        .on("unlink", function (filepath) {
            var splitedPath = filepath.split('/');
            splitedPath.shift();
            splitedPath.shift();
            remember.forget('favicon', path.resolve(filepath));
            delete cached.caches['favicon'][filepath];
            del(path.resolve('public/' + applicationVersion + '/' + splitedPath.join('/')));
        });
}

module.exports = {
    default: series(clean, parallel(applicationScss, applicationJs, images, favicon)),
    'application:js': applicationJs,
    'application:scss': applicationScss,
    'clean': clean,
    'images': series(images, favicon),
    'watch': series(clean, watchFiles)
};