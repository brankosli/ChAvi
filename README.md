# chavi-test

Option to have 2 type of connection(MySQL and SqlLite).

Simple copy git repo to desired folder and do:

<b>composer install</b>

create mysql DB and DB user.
Use config/db.php script to add credentials for mysql user and DB

If use SqlLite DB will be stored in /db/phpsqlite.db file

after that you should run setup.php script from root folder where you can pass type argument for desired type of DB

http://localhost/setup.php?type=XXXX