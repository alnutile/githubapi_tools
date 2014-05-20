## Some basic github api tools

I needed to run some reports and do some tedious work like make a readme for each repo or new folder.
Here are some helper files.


### Files

  * createManyFiles.php - go through a list of repos and add a folder/file to each one
  * getMembers.php - get members for an Org
  * getTeams.php - get Teams for an org

### 1. Setup

Make sure to set your environment variables

copy the evn file to .env and put in the right info into that file eg password/token username etc


Then run

~~~
composer install
~~~

put in place all the libraries

After that, at the command line, run

~~~
php getTeams.php
~~~

or

~~~
php getMembers.php
~~~

or

Fill in all the details inside createManyFolders.php and run it

~~~
php createManyFolders.php
~~~

And it will check each repo make the folder/file and report on any issues.

