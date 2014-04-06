module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		concat: {
			debug: {
				files: {
					'media/js/viewer.js': ['media/src/external/jquery.js', 'media/src/viewer.js'],
					'media/js/control.js': ['media/src/external/jquery.js', 'media/src/control.js'],
					'media/js/overview.js': ['media/src/external/jquery.js', 'media/src/overview.js'],
					'media/js/players.js': ['media/src/external/jquery.js', 'media/src/players.js']
				}
			}
		},
		uglify: {
		  dist: {
		    files: {
					'media/js/viewer.js': ['media/src/external/jquery.js', 'media/src/viewer.js'],
					'media/js/control.js': ['media/src/external/jquery.js', 'media/src/conrtol.js'],
					'media/js/overview.js': ['media/src/external/jquery.js', 'media/src/overview.js'],
					'media/js/players.js': ['media/src/external/jquery.js', 'media/src/players.js']
				}
		  }
		},
		watch: {
			scripts: {
				files: ['media/src/*.js'],
				tasks: ['concat'],
				options: {
					spawn: false
				}
			}
		}
	});

  grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-watch');

  // Default task(s).
  grunt.registerTask('default', ['watch']);

};