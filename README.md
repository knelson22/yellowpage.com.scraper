This project automatically collects data from yellowpages.com.  I used it to populate crm.  I worked on crm for years and saw the needs salespeople have.  You can do a search on any location, for any industry.  It puts results in the results table.  

I wrote this 2 years ago.  The dom has changed slightly, yp_page needs to be changed.  It is a complete encapsulation of all the data on a list view page.  Some of the attributes in html tags have changed that needs to be reflected.

This project is 100% data driven, so even the search queries come from the database.  To install:

1.  PHP 5.6.38+.  Mysql 5+
2. Run karlscav_yp.sql.  This installs database.  It even has some convenience tables, like zip, which has all locations in the United States.  It contains zip, lat, lon, town name etc.
3. Modify yp_page.php to reflect current dom.
4.  The format that rows need to be in the query table is:
"1"	http://www.yellowpages.com/"	"Grass Valley, CA/"	"MANUFACTURING"	"0"	""	"0"	"0"

Where Grass Valley, CA, is the city state.  MANUFACTURING is the industry.  When the application is started each row in the query table will be fetched from yellowpages.com and data's stored. Each row can return from 0-1000+ results


