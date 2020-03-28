"use strict";
const { watch, series } = require("gulp");
var browserSync = require("browser-sync").create(),
    gulp = require("gulp"),
    less = require("gulp-less"),
    livereload = require("gulp-livereload"),
    sass = require("gulp-sass"),
    sassRuby = require("gulp-ruby-sass"),
    notify = require("gulp-notify"),
    bower = require("gulp-bower"),
    uglify = require("gulp-uglify"),
    minify = require("gulp-minify"),
    sourcemaps = require("gulp-sourcemaps"),
    autoprefixer = require("gulp-autoprefixer"),
    webpack = require("webpack-stream"),
    react = require("gulp-react"),
    plumber = require("gulp-plumber");

/**
 * Global vars
 */
var devEnv = "free.site";

/**
 * Error function which wont break gulp
 */

function errorAlert(error) {
    notify.onError({
        title: "SCSS Error",
        message:
            "😭  getfreeapi | Check your terminal to see what's wrong in your sass files 😭"
    })(error);
    console.log(error.toString());
    this.emit("end");
}

/**
 * gulp sass
 */

gulp.task("sass", function() {
    var stream = gulp
        .src("scss/*.scss")
        .pipe(
            plumber({
                errorHandler: errorAlert
            })
        )
        .pipe(sourcemaps.init())
        .pipe(
            sass({
                errLogToConsole: true,
                outputStyle: "compressed" // nested | compact | expanded | compressed
            })
        )
        .pipe(autoprefixer("last 2 version"))
        .pipe(sourcemaps.write("."))
        .pipe(gulp.dest("css"))
        .pipe(browserSync.stream())
        .pipe(
            notify({
                message: "🍺   getfreeapi | happy to tell you gulp is Done! 🍺",
                onLast: true
            })
        );
    return stream;
});

/**
 * gulp serve
 *
 * Use 'gulp serve' for working with browsersync
 * For a livereload workflow use 'gulp watch'
 */

gulp.task("serve", gulp.series("sass"), function() {
    browserSync.init({
        proxy: devEnv,
        open: true
    });
    gulp.watch("scss/*.scss", gulp.series("sass")).on(
        "change",
        browserSync.reload
    );
    gulp.watch("js/*.js", gulp.series("js")).on("change", livereload.changed);

    // Gulp watch templates needs a Drupal cache rebuild before working
    gulp.watch("templates/*", gulp.series("tpl")).on(
        "change",
        browserSync.reload
    );
});

/**
 * gulp watch
 *
 * Use 'gulp watch' for working with livereload
 * For a browsersync workflow use 'gulp serve'
 */

gulp.task("watch", gulp.series("sass"), function() {
    browserSync.init({
        proxy: devEnv,
        open: true
    });
    livereload.listen();
    gulp.watch("scss/{,*/}*.scss", gulp.series("sass")).on(
        "change",
        browserSync.reload
    );
    gulp.watch("js/*.js", gulp.series("js")).on("change", livereload.changed);
});

/**
 * gulp deploy
 */

gulp.task("deploy", function() {});
/**
 * Default gulp task calling 'gulp serve'
 */

function clean(cb) {
    // body omitted
    cb();
}

function js(cb) {
    // body omitted
    return (
        gulp
            .src("js/ddkits.js")
            .pipe(
                webpack({
                    mode: "production",
                    output: {
                        filename: "now-ui-dashboard.js"
                    }
                })
            )
            // .pipe(gulp.series("react"))
            .pipe(minify())
            // .pipe(uglify())
            .pipe(gulp.dest("js/build"))
    );
}

function scss(cb) {
    // body omitted
    cb();
}

exports.default = function() {
    // You can use a single task
    watch("scss/*.scss", series("sass")).on("change", browserSync.reload);
    watch("scss/{,*/}*.scss", series("sass")).on("change", browserSync.reload);
    watch("scss/{,*/}{,*/}*.scss", series("sass")).on(
        "change",
        browserSync.reload
    );
    // Or a composed task
    watch("js/*.js", series(js)).on("change", livereload.changed);
};

// Using less if needed
gulp.task("less", function() {
    gulp.src("less/*.less")
        .pipe(less())
        .pipe(gulp.dest("css"))
        .pipe(livereload());
});

// react
gulp.task("react", function() {
    return gulp.src("reactJS.jsx").pipe(react());
});
// gulp.task('watch', function () {
//   livereload.listen();
//   gulp.watch('less/*.less', ['less']);
// });
