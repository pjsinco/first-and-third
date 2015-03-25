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
