module.exports = function(grunt) {

	// Project configuration.
	grunt.initConfig({
		concat: {
			debug: {
				files: {
					'media/js/viewer.js': ['media/src/external/jquery.js', 'media/src/viewer.js']
				}
			}
		},
		uglify: {
		  dist: {
		    files: {
					'media/js/viewer.js': ['media/src/external/jquery.js', 'media/src/viewer.js']
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