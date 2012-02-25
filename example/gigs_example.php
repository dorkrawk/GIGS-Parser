<?php
include("./gigs_parser/gigs_parser.php");

// First customize all the variables in the GIGSParser class located in gigs_parser.php 

$url = "http://gigs.dinosaurseateverybody.com/examples/taa.gigs";

// Create a new GIGSParser object by passing in the URL of a valid GIGS Feed
$gigs = new GIGSParser($url);
if($gigs->valid) {
	// Call the displayGIGS() function.  If you want to use a custom style sheet, pass in the url to the style sheet as a parameter. ex: $gigs->displayGIGS("/style/my_gigs_style.css");
	$gigs->displayGIGS();
}
else {
	echo $gigs->error;
}

?>