# GIGS Parser

by Dave Schwantes
[www.dinosaurseateverybody.com](www.dinosaurseateverybody.com)

## What Is GIGS Parser?

GIGS Parser is a PHP class built to take in a GIGS feed and output a table of shows for use on your website.  It is free to use and free to modify.

For more information about the GIGS Feed format visit the [GIGS Feed site](http://gigs.dinosaurseateverybody.com).

## How To Use The GIGS Parser

1. Download the GIGS-Feed files.  You've probably done this already. Good job.

2. Open gigs_parser.php in your favorite code/text editor.  Just inside the GIGSParser class you will see a comment that reads: "Fill in the necessary values to set up your GIGS Feed Parser".  Make any adjustments that you need to these settings to best meet your display requirements and save the file

If you want to customize the style of the table either edit gigs_style.css or build your own style sheet based on gigs_style.css.

3. Copy all the files in the /gigs_parser/ folder that you have unzipped into a /gigs_parser folder on your server. For example: http://www.yourwebsite.com/gigs_parser/

4. On the page(s) in your site that you would like to display a table from a GIGS Feed place the following code in the appropriate places:

    `include("./gigs_parser/gigs_parser.php");`

    `$gigs = new GIGSParser("http://www.gigsfeedlocation.com/gigsfeed.gigs");`
    
    `$gigs->displayGIGS();`
    
See /example/gigs_example.php for a more detailed example of how to use the GIGS Parser class.