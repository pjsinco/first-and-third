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

* Sitepoint: [Mock your Test Dependencies with Mockery](http://www.sitepoint.com/mock-test-dependencies-mockery/)

* [Mockery docs](http://docs.mockery.io/en/latest/index.html)
    * [Mockery on github](https://github.com/padraic/mockery)

###2015-03-31
* ```xmllint --noout --dtdvalid boards/board.dtd boards/game-board-5.xml```

###2015-04-03
* [Retrosheet.org](http://www.retrosheet.org)

* Github [Python scripts for Retrosheet data downloading and parsing](https://github.com/wellsoliver/py-retrosheet) 

* [Chadwick: Software Tools for Game-Level Baseball Data](http://chadwick.sourceforge.net/doc/index.html) 
    * [event descriptors](http://chadwick.sourceforge.net/doc/cwevent.html)

* [Building a Retrosheet Database – Part 1](http://www.techgraphs.com/building-a-retrosheet-database-part-1/)

* [96 variables on a play](http://www.pitchbypitch.com/2009/01/09/an-introduction-to-retrosheets-beventexe-software/)

* A Retrosheet event parser in python: [see link for parseretrosheet.py](http://gregstoll.dyndns.org/~gregstoll/baseball/stats.php)

###2015-04-04
* [Let's Build a Compiler, by Jack Crenshaw](http://compilers.iecc.com/crenshaw/)
    ```
    This fifteen-part series, written from 1988 to 1995, is a non-technical introduction to compiler construction. 
    ```

* Github: [An ANTLR context-free grammar for parsing Retrosheet event fields.](https://github.com/jeffreyolchovy/retrosheet)

* Retrosheet: [The event file](http://www.retrosheet.org/eventfile.htm#5)
    * STAR STAR STAR

* Video: [Building a Retrosheet Database — Part 3 (The Easy/Mac Way)](http://www.techgraphs.com/building-a-retrosheet-database-part-3-the-easymac-way/)

* Stack: [How to parse a CSV file using PHP](http://stackoverflow.com/questions/9139202/how-to-parse-a-csv-file-using-php)
    ```php
    $csvFile = file('../somefile.csv');
    $data = [];
    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }
    ```

###2015-04-05
```
number  field
------  -----
0       game id*
1       visiting team*
2       inning*
3       batting_team*
4       outs*
5       balls*
6       strikes*
7       pitch sequence
8       vis score*
9       home score*
10      batter
11      batter hand
12      res batter*
13      res batter hand*
14      pitcher
15      pitcher hand
16      res pitcher*
17      res pitcher hand*
18      catcher
19      first base
20      second base
21      third base
22      shortstop
23      left field
24      center field
25      right field
26      first runner*
27      second runner*
28      third runner*
29      event text*
30      leadoff flag*
31      pinchhit flag*
32      defensive position*
33      lineup position*
34      event type*
35      batter event flag*
36      ab flag*
37      hit value*
38      SH flag*
39      SF flag*
40      outs on play*
41      double play flag
42      triple play flag
43      RBI on play*
44      wild pitch flag*
45      passed ball flag*
46      fielded by
47      batted ball type
48      bunt flag
49      foul flag
50      hit location
51      num errors*
52      1st error player
53      1st error type
54      2nd error player
55      2nd error type
56      3rd error player
57      3rd error type
58      batter dest* (5 if scores and unearned, 6 if team unearned)
59      runner on 1st dest* (5 if scores and unearned, 6 if team unearned)
60      runner on 2nd dest* (5 if scores and unearned, 6 if team unearned)
61      runner on 3rd dest* (5 if scores and unearned, 6 if team unearned)
62      play on batter
63      play on runner on first
64      play on runner on second
65      play on runner on third
66      SB for runner on 1st flag
67      SB for runner on 2nd flag
68      SB for runner on 3rd flag
69      CS for runner on 1st flag
70      CS for runner on 2nd flag
71      CS for runner on 3rd flag
72      PO for runner on 1st flag
73      PO for runner on 2nd flag
74      PO for runner on 3rd flag
75      Responsible pitcher for runner on 1st
76      Responsible pitcher for runner on 2nd
77      Responsible pitcher for runner on 3rd
78      New Game Flag
79      End Game Flag
80      Pinch-runner on 1st
81      Pinch-runner on 2nd
82      Pinch-runner on 3rd
83      Runner removed for pinch-runner on 1st
84      Runner removed for pinch-runner on 2nd
85      Runner removed for pinch-runner on 3rd
86      Batter removed for pinch-hitter
87      Position of batter removed for pinch-hitter
88      Fielder with First Putout (0 if none)
89      Fielder with Second Putout (0 if none)
90      Fielder with Third Putout (0 if none)
91      Fielder with First Assist (0 if none)
92      Fielder with Second Assist (0 if none)
93      Fielder with Third Assist (0 if none)
94      Fielder with Fourth Assist (0 if none)
95      Fielder with Fifth Assist (0 if none)
96      event num

These additional fields are available in this version of cwevent.
These are specified using the -x option, and appear in the output
after all fields specified with -f. By default, none of these
fields are output.

number  field
------  -----
0       home team id
1       batting team id
2       fielding team id
3       half inning (differs from batting team if home team bats first
4       start of half inning flag
5       end of half inning flag
6       score for team on offense
7       score for team on defense
8       runs scored in this half inning
9       number of plate appearances in game for team on offense
10      number of plate appearances in inning for team on offense
11      start of plate appearance flag
12      truncated plate appearance flag
13      base state at start of play
14      base state at end of play
15      batter is starter flag
16      result batter is starter flag
17      ID of batter on deck
18      ID of batter in the hold
19      pitcher is starter flag
20      result pitcher is starter flag
21      defensive position of runner on first
22      lineup position of runner on first
23      event number on which runner on first reached base
24      defensive position of runner on second
25      lineup position of runner on second
26      event number on which runner on second reached base
27      defensive position of runner on third
28      lineup position of runner on third
29      event number on which runner on third reached base
30      Responsible catcher for runner on 1st
31      Responsible catcher for runner on 2nd
32      Responsible catcher for runner on 3rd
33      number of balls in plate appearance
34      number of called balls in plate appearance
35      number of intentional balls in plate appearance
36      number of pitchouts in plate appearance
37      number of pitches hitting batter in plate appearance
38      number of other balls in plate appearance
39      number of strikes in plate appearance
40      number of called strikes in plate appearance
41      number of swinging strikes in plate appearance
42      number of foul balls in plate appearance
43      number of balls in play in plate appearance
44      number of other strikes in plate appearance
45      number of runs on play
46      id of player fielding batted ball
47      force play at second flag
48      force play at third flag
49      force play at home flag
50      batter safe on error flag
51      fate of batter (base ultimately advanced to)
52      fate of runner on first
53      fate of runner on second
54      fate of runner on third
55      runs scored in half inning after this event
56      fielder with sixth assist
57      fielder with seventh assist
58      fielder with eighth assist
59      fielder with ninth assist
60      fielder with tenth assist
61      unknown fielding credit flag
62      uncertain play flag
```
