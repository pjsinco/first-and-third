module.exports = function(grunt) {

  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.loadNpmTasks("grunt-contrib-jade");


  grunt.initConfig({

    jade: {
      compile: {
        options: {
          pretty: true,
        },
        files: [{
          expand: true,
          cwd: 'components/jade/',
          src: '**/*.jade',
          dest: '.',
          ext: '.xml'
        }]
      }
    },


    watch: {
      options: {
        livereload: true
      },
      
      compileXml: {
        files: ['components/jade/*.jade'],
        tasks: ['jade']
      },


    } // watch
  }); // initConfig
  
  grunt.registerTask('default', ['watch']);

}; // exports

