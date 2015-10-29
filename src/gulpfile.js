var gulp = require('gulp');
var notify = require('gulp-notify');
var elixir = require('laravel-elixir');
var ts = require('gulp-typescript');

// public path sistemaPCI/public
elixir.config.publicPath = '../public';

// para copiar u otros.
var paths = {
    'typescript': elixir.config.assetsPath + '/typescript/**/*.ts',
    'public': elixir.config.publicPath,
    'jquery': './vendor/bower_components/jquery/',
    'bootstrap': './node_modules/bootstrap-sass/assets/',
    'fontAwesome': './vendor/bower_components/font-awesome/',
    'datepicker': './vendor/bower_components/bootstrap-datepicker/',
    'select2': './node_modules/Select2/dist/'
};

// git bump (v0.1.2) <-- gulp release|feature|patch|pre
var git = require('gulp-git');
var bump = require('gulp-bump');
var filter = require('gulp-filter');
var tag_version = require('gulp-tag-version');

// editar envs
var replace = require('gulp-replace');

/**
 * Bumping version number and tagging the repository with it.
 * Please read http://semver.org/
 *
 * You can use the commands
 *
 *     gulp pre       # makes v0.1.0 → v0.1.1-0
 *     gulp patch     # makes v0.1.0 → v0.1.1
 *     gulp feature   # makes v0.1.1 → v0.2.0
 *     gulp release   # makes v0.2.1 → v1.0.0
 *
 * To bump the version numbers accordingly after you did a patch,
 * introduced a feature or made a backwards-incompatible release.
 */

function inc(importance) {
    // get all the files to bump version in
    return gulp.src(['./package.json'])
        // bump the version number in those files
        .pipe(bump({type: importance}))
        // save it back to filesystem
        .pipe(gulp.dest('./'))
        // commit the changed version number
        .pipe(git.commit('bumps package version'))

        // read only one file to get the version number
        .pipe(filter('package.json'))
        // **tag it in the repository**
        .pipe(tag_version());
}

gulp.task('pre',     function() { return inc('prerelease'); });
gulp.task('patch',   function() { return inc('patch'); });
gulp.task('feature', function() { return inc('minor'); });
gulp.task('release', function() { return inc('major'); });

gulp.task('compile-ts', function () {
    return gulp.src(paths.typescript)
        .pipe(ts({
            noImplicitAny: false,
            noEmitOnError: true,
            removeComments: true,
            sourceMap: false,
            out: "appBundle.js",
            target: "es5"
        }))
        .pipe(gulp.dest(elixir.config.assetsPath + '/js'));
});

elixir(function (mix) {
    mix
        .task('compile-ts')
        .sass('app.sass')
        // copiamos los fonts de bootstrap para que no se queje.
        // otra opcion seria un symlink o algo asi.
        .copy(paths.bootstrap + 'fonts/bootstrap/**', paths.public + '/fonts')
        .copy(paths.fontAwesome + 'fonts/**', paths.public + '/fonts')
        // i dont even know
        .copy(paths.bootstrap + 'fonts/bootstrap/**', paths.public + '/build/fonts')
        .copy(paths.fontAwesome + 'fonts/**', paths.public + '/build/fonts')

        // le hace el amor y ejacula ~/sistemaPCI/public/js/all.js
        .scripts([
            '', //asqueroso, pero funciona
            paths.jquery + "dist/jquery.js",
            paths.bootstrap + "javascripts/bootstrap.js",
            paths.select2 + "js/select2.js",
            paths.select2 + "js/i18n/es.js",
            'appBundle.js'
        ])
        .scripts([
            '../ajax/address/getAddress.js'
        ], paths.public + '/js/getAddress.js')
        .scripts([
            '../ajax/address/setAddress.js'
        ], paths.public + '/js/setAddress.js')
        .scripts([
            paths.datepicker + 'dist/js/bootstrap-datepicker.min.js',
            paths.datepicker + 'dist/locales/bootstrap-datepicker.es.min.js',
        ], paths.public + '/js/datepicker.js')
        .styles([
            paths.datepicker + 'dist/css/bootstrap-datepicker3.css',
            paths.select2 + "css/select2.css",
        ], paths.public + '/css/vendor.css')

        // 'versiona' los archivos para obtener copias actualizadas
        // y no versiones de cache del explorador (firefox es el peor)
        .version([
            'css/app.css',
            '/css/vendor.css',
            'js/all.js',
            'js/setAddress.js',
            'js/getAddress.js',
            '/js/datepicker.js'
        ]);
});
