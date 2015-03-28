###2015-03-24
* Stack: [How to use XMLReader in PHP?](http://stackoverflow.com/questions/1835177/how-to-use-xmlreader-in-php)
    * 
    ```
    My advice: write a prototype with SimpleXML, see if it works for you. If performance is paramount, try DOM. Stay as far away from XMLReader as possible. Remember that the more code you write, the higher the possibility of you introducing bugs or introducing performance regressions.
    ```

* Oracle: [How XPath Works](https://docs.oracle.com/javase/tutorial/jaxp/xslt/xpath.html)

* php enumerations
  ```php
  abstract class DaysOfWeek
  {
      const Sunday = 0;
      const Monday = 1;
      // etc.
  }
  
  $today = DaysOfWeek::Sunday;
  ```
    * Stack: [PHP and Enumerations](http://stackoverflow.com/questions/254514/php-and-enumerations)


###2015-03-25
* Tuts+: [PHP Exceptions](http://code.tutsplus.com/tutorials/php-exceptions--net-22274)

###2015-03-26
* [Run shell commands with grunt-shell](https://jonsuh.com/blog/take-grunt-to-the-next-level/#run-shell-commands-with-grunt-shell)
    ```js
    npm install grunt-shell --save-dev
    ```

    ```js
    grunt.initConfig({
      shell: {
        options: {
          stdout: true,
          stderr: true
        },
        deploy: {
          command: 'bundle exec cap production deploy'
        }
      },
    });  
    ```

    ```js
    grunt.registerTask('production', ['build', 'cssmin', 'uglify', 'shell:deploy']);
    ```

* Stack: [XML Schema (XSD) validation tool?](http://stackoverflow.com/questions/124865/xml-schema-xsd-validation-tool)
    ```
    xmllint --noout --schema XSD_FILE XML_FILE
    ```
* [XML schema example](http://cs.au.dk/~amoeller/XML/schemas/xmlschema-example.html)

###2015-03-28
* Tuts+: [Mockery: A Better Way](http://code.tutsplus.com/tutorials/mockery-a-better-way--net-28097)



