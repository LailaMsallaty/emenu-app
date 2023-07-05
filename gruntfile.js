module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    validation: {
      options: {
        doctype: 'HTML5',
        generateReport: false,
        generateCheckstyleReport: false
      },
      files: {
        src: ['./*.html']
      }
    },
    zip: {
      'build-package': {
        src: ['**/*', '!node_modules/**', '!.git/**', '!w3cErrors/**', '!.gitlab-ci.yml', '!.deployignore', '!validation-report.json', '!validation-status.json', '!package-lock.json', '!.gitignore'],
        dot: true,
        dest: '../soup-html.zip'
      }
    }
  })

  grunt.loadNpmTasks('grunt-w3c-html-validation')
  grunt.loadNpmTasks('grunt-zip')
}
