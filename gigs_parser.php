<?php
/**************************

GIGS Parser
2010 by Dave Schwantes
Dinosaurs Eat Everybody
www.dinosaurseateverybody.com

The GIGS Parser class is designed to make it easier to pull in a 
GIGS Feed and display the information in a readable way.

version: 1.0b

For more information about GIGS vist: http://gigs.dinosaurseateverybody.com

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser Public License
as published by the Free Software Foundation.

***************************/


class GIGSParser {	
	/*
	Fill in the necessary values to set up your GIGS Feed Parser
	*/
	
	/*************************
	Columns To Display
	**************************/
	
	private $showTitle = false; // title
	private $showDate = true; // date 
	private $showTime = true; // time 
	private $venueName = true; // name of venue
	private $address = true; // street address of venue
	private $city = true; // city of venue
	private $state = true; // state of venue
	private $zip = true; // zip code of venue
	private $country = false; // country of venue
	private $venueLink = true; // link to venue website
	private $cost = true; // price of show
	private $otherArtists = true; // list of other artists playing show
	private $otherArtistsLinks = true; // links to other artits playing show
	private $showDescription = false; // description of show details
	
	/*************************
	Column Titles
	**************************/
	
	private $showTitle_title = "Show Title";
	private $showDate_title = "Date";
	private $showTime_title = "Time";
	private $venueName_title = "Venue";
	private $address_title = "Address";
	private $cost_title = "Price";
	private $otherArtists_title = "Other Artists";
	private $showDescription_title = "Details";
	
	/*************************
	Display Settings
	**************************/
	
	private $displayFeedTitle = false; // display the title of the feed
	private $displayArtist = false; // display the artist name
	private $displayArtistLink = false; // display the artist link
	private $displayFeedDescription = false; // display the description of the feed
	private $dateFormat = "M jS Y"; // format for date display
	private $timeFormat = "g:i a"; // format for time display
	private $displayMapLink = true; // generates a link to a map for the venue, if possible
	private $displayFeedLink = true; // display a link and feed icon for your GIGS Feed
	private $feedLinkText = "Subscribe to this GIGS Feed."; // text displayed on the feed link
	private $feedIconImage = "/gigs_parser/feed-icon-14x14.png";  // address of the GIGS Feed icon image
	private $mapSource = "mapquest"; // select service for map link from: "google", "mapquest"
	private $addressFormat = "%A %C, %S"; // %A = street address, %C = city, %S = state, %Z = zip code, %N = county 
	private $venueLinkStyle = "self"; // the text for the venue link (example: "[link]" ) or use "self" to make the name of the venue the link
	private $mapLinkStyle = "[map]"; // the text for the map link (example: "[map]" )
	private $otherArtistsLinkStyle = "self"; // the text for the link to other artist's site (example: "[link]") or use "self" to use the name of the artist
	
	/*
	End GIGS config variables.
	
	Do not edit anything after this unless you know what you're doing.
	*/
	
	public $valid = true; // a bool indicating if the GIGS feed supplied is valid.
	public $error;  // a string describing the error	
	private $gigs;  // an array containing the information parsed from the GIGS Feed
	private $feed_url; // a url to the GIGS feed
		
	/*************************
	GIGSParser($url)
	
	Sets $gigs to a multidimentioal array containing the information from the GIGS feed that was passed in if the function was successful
	
			 
	**************************/
	public function GIGSParser($url) {
		if(!$this->validateGIGS($url)) {
			$this->valid = false;
			return false;
		}
		
		if($this->gigs = simplexml_load_file($url)) {
			$this->feed_url = $url;
			return true;
		}
		else {
			$this->error = "Error in returning GIGS feed from $url.";
			$this->valid = false;
			return false;
		}
	}
	
	/**************************
	displayGIGS($css)
	
	$css : address of a CSS file to style the GIGS table [optional]
	output: A <table> based show with the data from the GIGS feed that was passed in.
		
	**************************/
	public function displayGIGS($css='') {
		if($css != "") {
			echo "<link rel='stylesheet' type='text/css' href='$css' />\n";
		}
		echo "<div id='gigs_cell'> \n";
	
		if($this->displayFeedTitle) {
			echo "\t<span class='gigs_title'>".$this->gigs->title."</span>\n";
		}
		
		if($this->displayArtist) {
			echo "\t<span class='gigs_artist'>".$this->gigs->artist."</span>\n";
		}
		
		if($this->displayArtistLink) {
			echo "\t<span class='gigs_artistlink'><a href='".$this->gigs->link."' title='".$this->gigs->artist."'>[link]</a></span>\n";
		}
		
		if($this->displayFeedDescription) {
			echo "\t<span class='gigs_description'>".$this->gigs->description."</span>\n";
		}
		
		// start displaying the show table
		
		echo "\t <table class='gigs_table'>\n";
		
			echo "\t\t<tr class='gigs_coltitlerow'>\n";
			
			if($this->showDate) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->showDate_title."</th>\n";
			}
			
			if($this->showTime) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->showTime_title."</th>\n";
			}
			
			if($this->showTitle) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->showTitle_title."</th>\n";
			}
			
			if($this->venueName) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->venueName_title."</th>\n";
			}
			
			if($this->address) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->address_title."</th>\n";
			}
			
			if($this->cost) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->cost_title."</th>\n";
			}
			
			if($this->otherArtists) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->otherArtists_title."</th>\n";
			}
			
			if($this->showDescription) {
				echo "\t\t\t<th class='gigs_coltitle'>".$this->showDescription_title."</th>\n";
			}
	
			
			echo "\t\t</tr>\n";	
		
			$shows_count = count($this->gigs->show);
			
			for($i=0;$i<$shows_count;$i++) {
				// Parse date/time information
				$showDate_str = strtotime($this->gigs->show[$i]->showDate);
				
				echo "\t\t<tr class='gigs_showrow ";
				
				// Add class for zebra striping
				if($i%2 == 0) {
					echo "gigs_oddrow";
				}
				else {
					echo "gigs_evenrow";
				}
				
				echo "'>\n";
					
					if($this->showDate) {
						$the_date = date($this->dateFormat,$showDate_str);
						echo "\t\t\t<td class='gig_showcell'>$the_date</td>\n";
					}
					
					if($this->showTime) {
						$the_time = date($this->timeFormat,$showDate_str);
						echo "\t\t\t<td class='gig_showcell'>$the_time</td>\n";
					}
					
					if($this->showTitle) {
						echo "\t\t\t<td class='gig_showcell'>".$this->gigs->show[$i]->showTitle."</td>\n";
					}
					
					if($this->venueName) {
						$the_venueName = $this->formatVenue($i);
						echo "\t\t\t<td class='gig_showcell'>$the_venueName</td>\n";
					}
					
					if($this->address) {
						$the_address = $this->formatAddress($i);
						echo "\t\t\t<td class='gig_showcell'>$the_address</td>\n";
					}
					
					if($this->cost) {
						echo "\t\t\t<td class='gig_showcell'>".$this->gigs->show[$i]->cost."</td>\n";
					}
					
					if($this->otherArtists) {
						$the_otherArtists = $this->formatOtherArtist($i);
						echo "\t\t\t<td class='gig_showcell'>$the_otherArtists</td>\n";
					}
					
					if($this->showDescription) {
						echo "\t\t\t<td class='gig_showcell'>".$this->gigs->show[$i]->showDescription."</td>\n";
					}
					
				echo "\t\t</tr>\n";
			}		
		echo "\t</table>\n";
		
		if($this->displayFeedLink) {
			echo "\t<div id='gigs_link'>\n";
			echo "\t\t";
			echo $this->feedLinkText;
			echo " <a href='".$this->feed_url."' title='".$this->gigs->title."' class='image'><img src='".$this->feedIconImage."' alt='GIGS Feed icon'/></a>\n";
			echo "\t</div>\n";
		}
		echo "</div>"; // for #gigs_cell
	}
	
	/**************************
	validateGIGS($url)
	
	$url : a url to a GIGS Feed
	returns : true if the feed is valid based on the DTD at http://gigs.dinosaurseateverybody.com/dtd/gigs.dtd
			  false if the feed is not valid
	
	**************************/
	private function validateGIGS($url) {
		$gigs_dtd = "http://gigs.dinosaurseateverybody.com/dtd/gigs.dtd";
		$root = "gigs";
		
		libxml_use_internal_errors(true);
		$xml_test = simplexml_load_file($url);
		if(!$xml_test) {
			$this->error = "$url is not a valid GIGS Feed.";
			return false;
		}
		
		$old = new DOMDocument();
		$old->load($url); 
		
		$creator = new DOMImplementation;
		$doctype = $creator->createDocumentType($root, null, $gigs_dtd);
		$new = $creator->createDocument(null, null, $doctype);
		$new->encoding = "utf-8";
		
		$oldNode_elements = $old->getElementsByTagName($root);
		$oldNode = $oldNode_elements->item(0);
		if($oldNode_elements->length > 0 ) {
			$newNode = $new->importNode($oldNode, true);
			$new->appendChild($newNode);
			
			$gigs_valid = $new->validate();
			
			if (!$gigs_valid) { 
			   $this->error = "$url is not a valid GIGS Feed.";
			   return false;
			} 
			else { 
			   return true; 
			}
		}
		else {
			$this->error = "$url is not a valid GIGS Feed.";
			return false;
		}
		
	}
	
	/**************************
	createMapURI($address_data)
	
	$address_data : an array of address information form array(address,city,state,zip,country)
	return: a URI to a map service
	output: none
	
	**************************/
	private function createMapURI($address_data) {
		$address_key = array("%A","%C","%S","%Z","%N");
		
		switch($this->mapSource) {
			case "google":
				$map_link = str_replace($address_key,$address_data,"http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=%A,+%C,+%S+%Z,+%N");
				return $map_link;
				break;
			case "mapquest":
				$map_link = str_replace($address_key,$address_data,"http://www.mapquest.com/maps?city=%C&state=%S&address=%A&zipcode=%Z&country=%N");
				return $map_link;
				break;
			default:
				// default to Google Maps
				$map_link = str_replace($address_key,$address_data,"http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=%A,+%C,+%S+%Z,+%N");
				return $map_link;
		
		}
	}
	
	/**************************
	formatOtherArtist($i)
	
	$i : the id of the the show to pull from
	return: a list of otherArtists with links to artist, if applicable
	output: none
	
	**************************/
	private function formatOtherArtist($i) {
		$otherArtist_count = count($this->gigs->show[$i]->otherArtist);
			
		if($otherArtist_count > 0) {
			// Add the first otherArtist
				
			// Add the link to the artist name
			if($this->otherArtistsLinks && ($this->otherArtistsLinkStyle == "self") && ($this->gigs->show[$i]->otherArtist[0]["link"] != "")) {
				$the_otherArtists = "<a href='".$this->gigs->show[$i]->otherArtist[0]["link"]."' title='".$this->gigs->show[$i]->otherArtist[0]."'>";
				$the_otherArtists .= $this->gigs->show[$i]->otherArtist[0];
				$the_otherArtists .= "</a>";
			}
			else {
				$the_otherArtists .= $this->gigs->show[$i]->otherArtist[0];
			}
			
			// Or add the artistLink after the artist name
			if($this->otherArtistsLinks && ($this->otherArtistsLinkStyle != "self") && ($this->gigs->show[$i]->otherArtist[0]["link"] != "")) {
				$the_otherArtists .= " <a href='".$this->gigs->show[$i]->otherArtist[0]["link"]."' title='".$this->gigs->show[$i]->otherArtist[0]."'>".$this->otherArtistsLinkStyle."</a>";
			}
			
			// Cycle through the rest of the otherArists (adding ',' before each entry)
			for($j=1;$j<$otherArtist_count;$j++) {
			
				// add the link to the artist name
				if($this->otherArtistsLinks && ($this->otherArtistsLinkStyle == "self") && ($this->gigs->show[$i]->otherArtist[$j]["link"] != "")) {
					$the_otherArtists .= ", <a href='".$this->gigs->show[$i]->otherArtist[$j]["link"]."' title='".$this->gigs->show[$i]->otherArtist[$j]."'>";
					$the_otherArtists .= $this->gigs->show[$i]->otherArtist[$j];
					$the_otherArtists .= "</a>";
				}
				else {
					$the_otherArtists .= ", ".$this->gigs->show[$i]->otherArtist[$j];
				}
				
				// or add the artistLink after the artist name
				if($this->otherArtistsLinks && ($this->otherArtistsLinkStyle != "self") && ($this->gigs->show[$i]->otherArtist[$j]["link"] != "")) {
					$the_otherArtists .= " <a href='".$this->gigs->show[$i]->otherArtist[$j]["link"]."' title='".$this->gigs->show[$i]->otherArtist[$j]."'>".$this->otherArtistsLinkStyle."</a>";
				}
			}
		
		}	
		return $the_otherArtists;
	}
	
	/**************************
	formatVenue($i)
	
	$i : the id of the the show to pull from
	return: the venue name with venue link added, if applicable
	output: none
	
	**************************/
	private function formatVenue($i) {
		if($this->venueLink && ($this->gigs->show[$i]->venue->venueLink != "") && ($this->venueLinkStyle == "self")){
			$the_venueName = "<a href='".$this->gigs->show[$i]->venue->venueLink."' title='".$this->gigs->show[$i]->venue->venueName."'>".$this->gigs->show[$i]->venue->venueName."</a>";
		}
		else {
			$the_venueName = $this->gigs->show[$i]->venue->venueName;
		}
		
		if($this->venueLink && ($this->gigs->show[$i]->venue->venueLink != "") && ($this->venueLinkStyle != "self")){
			$the_venueName .= " <a href='".$this->gigs->show[$i]->venue->venueLink."' title='".$this->gigs->show[$i]->venue->venueName."'>$this->venueLinkStyle</a>";
		}
		return $the_venueName;
	}
	
	/**************************
	formatAddress($i)
	
	$i : the id of the the show to pull from
	return: the address formatted based on $addressFormat from the config
	output: none
	
	**************************/
	private function formatAddress($i) {
		$address_key = array("%A","%C","%S","%Z","%N");
		$address_data = array($this->gigs->show[$i]->venue->address,$this->gigs->show[$i]->venue->city,$this->gigs->show[$i]->venue->state,$this->gigs->show[$i]->venue->zip,$this->gigs->show[$i]->venue->country);
		
		$the_address = str_replace($address_key,$address_data,$this->addressFormat);
		
		if ($this->displayMapLink){
			$map_uri = $this->createMapURI($address_data);
			
			$map_link = "<a href='$map_uri' title='$the_address'>".$this->mapLinkStyle."</a>";
			
			$the_address .= " $map_link";
		}		
		return $the_address;
	}
}

?>