<?php
	/*
	OpenLinkMap Copyright (C) 2010 Alexander Matheisen
	This program comes with ABSOLUTELY NO WARRANTY.
	This is free software, and you are welcome to redistribute it under certain conditions.
	See http://wiki.openstreetmap.org/wiki/OpenLinkMap for details.
	*/

	// addressformats for different countries
	$addressformats = array(
		"default" => "<div>#housename#</div>\n<div class=\"street-address\">#street# #housenumber#</div>\n<span class=\"postal-code\">#postcode# </span>\n<span class=\"locality\">#city#-#suburb#</span>\n",
		"at" => "<div>#housename#</div>\n<div class=\"street-address\">#street# #housenumber#</div>\n<span class=\"postal-code\">#postcode# </span>\n<span class=\"locality\">#city#-#suburb#</span>\n",
		"de" => "<div>#housename#</div>\n<div class=\"street-address\">#street# #housenumber#</div>\n<span class=\"postal-code\">#postcode# </span>\n<span class=\"locality\">#city#-#suburb#</span>\n",
		"es" => "<div>#housename#</div>\n<div class=\"street-address\">#street#, #housenumber#</div>\n<span class=\"postal-code\">#postcode# </span>\n<span class=\"locality\">#city# (#province#)</span>\n",
		"fr" => "<div>#housename#</div>\n<div class=\"street-address\">#housenumber#, #street#</div>\n<span class=\"postal-code\">#postcode# </span>\n<span class=\"locality\">#city#</span>\n",
		"us" => "<div class=\"street-address\">#housenumber# #street#</div>\n<span class=\"locality\">#city#</span>, <span class=\"postal-code\">#state# #postcode#</span>\n"
	);
?>
