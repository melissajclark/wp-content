module.exports = function( grunt ) {
    "use strict";

    var openCommand = "open";

    /* jshint ignore:start */
    if ( process.platform === "linux" ) {
        openCommand = "xdg-open";
    }
    /* jshint ignore:end */

    var jsFiles = [ "Gruntfile.js", "./assets/js/**/*.js", "!./assets/js/**/*.min.js" ],
        config = {

            pkg: grunt.file.readJSON("package.json"),

            jshint: {
                files: jsFiles,
                options: {
                    jshintrc: "./.jshintrc",
                    globals: {
                        jQuery: true,
                        console: true,
                        module: true,
                        document: true
                    }
                }
            },

            jscs: {
                src: jsFiles,
                options: {
                    config: "./.jscs.json"
                }
            },

            plato: {
                app: {
                    options: {
                        jshint: grunt.file.readJSON("./.jshintrc")
                    },
                    files: {
                        "reports/plato": jsFiles
                    }
                }
            },

            shell: {
                platoreports: {
                    command: openCommand + " ./reports/plato/index.html"
                }
            },

            uglify: {
                build: {
                    options: {
                        // banner: "/* <%= pkg.name %> <%= pkg.version %> <%= grunt.template.today('yyyy-mm-dd') %> */",
                        sourceMap: true,
                        // mangle: false,
                        preserveComments: "some",
                        compress: {
                            drop_console: true
                        }
                    },
                    files: [ {
                        expand: true,
                        cwd: "./assets/js/",
                        src: [ "**/*.js", "!**/*.min.js" ],
                        dest: "./assets/js/",
                        ext: ".min.js"
                    } ]
                }
            },

            sass: {
                css: {
                    options: {
                        style: "compressed"
                    },
                    files: [ {
                        expand: true,
                        cwd: "./assets/scss/",
                        src: [ "*.scss", "*.sass" ],
                        dest: "./assets/css/",
                        ext: ".css"
                    } ]
                }
            },

            autoprefixer: {
                options: {
                    browsers: [ "last 3 versions", "ie 8", "ie 9" ],
                    map: true
                },
                css: {
                    expand: true,
                    flatten: true,
                    src: "./assets/css/*.css",
                    dest: "./assets/css/"
                },
            },

            checkwpversion: {
                options:{
                    readme: "readme.txt",
                    plugin: "<%= pkg.name %>.php",
                },
                check: {
                    version1: "plugin",
                    version2: "readme",
                    compare: "=="
                },
                check2: {
                    version1: "plugin",
                    version2: "<%= pkg.version %>",
                    compare: "==",
                }
            },

            watch: {
                checkwpversion: {
                    files: [ "readme.txt", "package.json", "<%= pkg.name %>.php" ],
                    tasks: [ "checkwpversion" ]
                },
                sass: {
                    files: [ "./assets/scss/**/*.{scss,sass}" ],
                    tasks: [ "style" ]
                },
                js: {
                    files: jsFiles,
                    tasks: [ "js" ]
                },
                livereload: {
                    options: {
                        livereload: true
                    },
                    files: [
                        "./assets/css/**/*",
                        "./assets/js/dist/**/*",
                    ]
                }
            },

            wp_readme_to_markdown: {
                readme: {
                    files: {
                        "readme.md": "readme.txt"
                    }
                }
            },
        };

    grunt.config.init( config );

    // https://github.com/sindresorhus/load-grunt-tasks
    require("load-grunt-tasks")(grunt);

    // https://www.npmjs.com/package/time-grunt
    require("time-grunt")(grunt);

    grunt.registerTask(
        "default",
        [ "checkwpversion", "assets", "watch" ]
    );

    grunt.registerTask(
        "check",
        [ "checkwpversion", "jshint", "jscs" ]
    );

    grunt.registerTask(
        "assets",
        [ "style", "js" ]
    );

    grunt.registerTask(
        "style",
        [ "sass", "autoprefixer" ]
    );

    grunt.registerTask(
        "js",
        [ "jshint", "jscs", "uglify" ]
    );

    grunt.registerTask(
        "reports",
        [ "jshint", "jscs", "plato", "shell:platoreports" ]
    );

};
