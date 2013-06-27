<?php
	/*
	OpenLinkMap Copyright (C) 2010 Alexander Matheisen
	This program comes with ABSOLUTELY NO WARRANTY.
	This is free software, and you are welcome to redistribute it under certain conditions.
	See http://wiki.openstreetmap.org/wiki/OpenLinkMap for details.
	*/


	require_once("functions.php");
	// include translation file
	includeLocale($_GET['lang']);

	$format = $_GET['format'];
	$id = $_GET['id'];
	$type = $_GET['type'];
	// offset of user's timezone to UTC
	$offset = offset($_GET['offset']);
	$callback = $_GET['callback'];

	date_default_timezone_set('UTC');


	// protection of sql injections
	if (!isValidType($type) || !isValidId($id))
	{
		echo "NULL";
		exit;
	}

	// get the most important langs of the user
	$langs = getLangs();
	if ($_GET['lang'])
		$langs[0] = $_GET['lang'];

	if (!getDetails($db, $id, $type, $langs, $offset))
		echo "NULL";


	function getDetails($db, $id, $type, $langs, $offset)
	{
		global $format, $callback;

		// request
		$request = "SELECT
				tags->'addr:street' AS \"street\",
				tags->'addr:housenumber' AS \"housenumber\",
				tags->'addr:housename' AS \"housename\",
				tags->'addr:country' AS \"country\",
				tags->'addr:postcode' AS \"postcode\",
				tags->'addr:city' AS \"city\",
				tags->'addr:suburb' AS \"suburb\",
				tags->'addr:province' AS \"province\",
				tags->'addr:unit' AS \"unit\",
				tags->'addr:floor' AS \"floor\",
				tags->'addr:door' AS \"door\",
				tags->'phone' AS \"phone1\",
				tags->'contact:phone' AS \"phone2\",
				tags->'addr:phone' AS \"phone3\",
				tags->'fax' AS \"fax1\",
				tags->'contact:fax' AS \"fax2\",
				tags->'addr:fax' AS \"fax3\",
				tags->'website' AS \"website1\",
				tags->'url' AS \"website2\",
				tags->'url:official' AS \"website3\",
				tags->'contact:website' AS \"website4\",
				tags->'operator' AS \"operator\",
				tags->'email' AS \"email1\",
				tags->'contact:email' AS \"email2\",
				tags->'addr:email' AS \"email3\",
				tags->'opening_hours' AS \"openinghours\",
				tags->'service_times' AS \"servicetimes\",
				tags->'image' AS \"image\"
			FROM ".$type."s WHERE (id = ".$id.");";

		$wikipediarequest = "SELECT
								foo.keys, foo.values
							FROM (
								SELECT
									skeys(tags) AS keys,
									svals(tags) AS values
								FROM ".$type."s
								WHERE (id = ".$id.")
							) AS foo
							WHERE substring(foo.keys from 1 for 9) = 'wikipedia';";

		$namerequest = "SELECT
								foo.keys, foo.values
							FROM (
								SELECT
									skeys(tags) AS keys,
									svals(tags) AS values
								FROM ".$type."s
								WHERE (id = ".$id.")
							) AS foo
							WHERE substring(foo.keys from 1 for 4) = 'name';";

		// connnecting to database
		$connection = connectToDatabase($db);
		// if there is no connection
		if (!$connection)
			exit;

		$response = requestDetails($request, $connection);
		$wikipediaresponse = requestDetails($wikipediarequest, $connection);
		$nameresponse = requestDetails($namerequest, $connection);

		pg_close($connection);

		if ($response)
		{
			if ($format == "text")
				echo textDetailsOut($response[0], $nameresponse, $wikipediaresponse, $langs, $offset);
			else if ($format == "json")
				echo jsonDetailsOut($response[0], $nameresponse, $wikipediaresponse, $langs, $offset, $id, $type, $callback);
			else
				echo xmlDetailsOut($response[0], $nameresponse, $wikipediaresponse, $langs, $offset, $id, $type);
			return true;
		}
		else
			return false;
	}


	// output of details data in plain text format
	function textDetailsOut($response, $nameresponse, $wikipediaresponse, $langs = "en", $offset = 0)
	{
 		global $db, $id, $type;

		if ($response)
		{
			// setting header
			header("Content-Type: text/html; charset=UTF-8");
			$output = "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">";

			// translation of name
			if ($nameresponse)
				$name = getNameDetail($langs, $nameresponse);

			// if no name is set, use the poi type as name instead
			if ($name[0] == "")
			{
				$tags = getTags($db, $id, $type);
				foreach ($tags as $key => $value)
				{
					$tag = $key."=".$value;
					if (dgettext("tags", $tag) != "")
						$name[0] = dgettext("tags", $tag);
					if ($name[0] != $tag)
						break;
				}
			}

			$phone = getPhoneFaxDetail(array($response['phone1'], $response['phone2'], $response['phone3']));
			$fax = getPhoneFaxDetail(array($response['fax1'], $response['fax2'], $response['fax3']));
			$mobilephone = getPhoneFaxDetail(array($response['mobilephone1'], $response['mobilephone2']));
			$website = getWebsiteDetail(array($response['website1'], $response['website2'], $response['website3'], $response['website4']));
			$email = getMailDetail(array($response['email1'], $response['email2'], $response['email3']));

			// get wikipedia link and make translation
			if ($wikipediaresponse)
				$wikipedia = getWikipediaDetail($langs, $wikipediaresponse);

			$openinghours = getOpeninghoursDetail($response['openinghours']);
			$servicetimes = getOpeninghoursDetail($response['servicetimes']);

			// printing popup details

			// image, only images from domains listed on a whitelist are displayed
			if (imageDomainAllowed($response['image']))
			{
				$url = getImageUrl($response['image']);
				$tmp = parse_url($url);
				if (substr_count($tmp['host'], ".") > 1)
					$domain = substr($tmp['host'], strpos($tmp['host'], ".")+1);
				else
					$domain = $tmp['host'];

				// image from wikimedia commons
				if ($domain == "wikimedia.org")
				{
					// creating url to Wikimedia Commons page of this image
					$attribution = explode("/", $url);
					if (substr($url, 34, 16) == "special:filepath")
						$attribution = $attribution[5];
					else
						$attribution = $attribution[7];

					$output .= "<div id=\"loadingImage\"><img id=\"image\" title=\""._("Fullscreen")."\" src=\"".getWikipediaThumbnailUrl($url)."\" /></div><div class=\"attribution\"><a target=\"_blank\" href=\"http://commons.wikimedia.org/wiki/File:".$attribution."\">"._("attribution-wikimedia.org")."</a></div>\n";
				}
				// image from OpenStreetMap Wiki
				else if ($domain == "openstreetmap.org")
				{
					// creating url to OpenStreetMap Wiki page of this image
					$attribution = explode("/", $url);
					if (substr($url, 35, 16) == "special:filepath")
						$attribution = $attribution[5];
					else
						$attribution = $attribution[7];

					$output .= "<div id=\"loadingImage\"><img id=\"image\" title=\""._("Fullscreen")."\" src=\"".getOsmWikiThumbnailUrl($url)."\" /></div><div class=\"attribution\"><a target=\"_blank\" href=\"http://wiki.openstreetmap.org/wiki/File:".$attribution."\">"._("attribution-openstreetmap.org")."</a></div>\n";
				}
				// image from other source
				else
					$output .= "<div id=\"loadingImage\"><img id=\"image\" title=\""._("Fullscreen")."\" src=\"".$url."\" /></div><div class=\"attribution\"><a target=\"_blank\" href=\""._("attribution-url-".$domain)."\">"._("attribution-".$domain)."</a></div>\n";
			}
			else if (getWikipediaImage($wikipedia[1]))
			{
				// creating url to Wikimedia Commons page of this image
				$attribution = explode("/", $url);
				if (substr($url, 34, 16) == "special:filepath")
					$attribution = $attribution[5];
				else
					$attribution = $attribution[7];

				$image = getWikipediaImage($wikipedia[1]);
				$output .= "<div id=\"loadingImage\"><img id=\"image\" title=\""._("Fullscreen")."\" src=\"".getWikipediaThumbnailUrl($image)."\" /></div><div class=\"attribution\"><a target=\"_blank\" href=\"http://commons.wikimedia.org/wiki/File:".$attribution."\">"._("attribution-wikimedia.org")."</a></div>\n";
			}

			if ($name)
			{
				$output .= "<div class=\"container hcard vcard\"><div class=\"header\">\n";
				$output .= "<strong class=\"name\">".$name[0]."</strong>\n";
				$output .= "</div>\n";
			}

			// address information
			if ($response['street'] || $response['housenumber'] || $response['country'] || $response['city'] || $response['postcode'])
			{
				$output .= "<div class=\"adr\">\n";
				// country-dependend format of address
				$output .= formatAddress($response, $response['country']);
				$output .= "</div>\n";
			}

			// contact information
			if ($phone || $fax || $mobilephone || $email)
			{
				$output .= "<div class=\"contact\">\n";
				if ($phone)
				{
					$output .= "<div class=\"tel\"><span class=\"type\">"._("Phone")."</span>:";
					foreach ($phone as $phonenumber)
						$output .= " <a class=\"value\" href=\"callto:".$phonenumber[0]."\">".$phonenumber[1]."</a>";
					$output .= "</div>\n";
				}
				if ($fax)
				{
					$output .= "<div class=\"tel\"><span class=\"type\">"._("Fax")."</span>:";
					foreach ($fax as $faxnumber)
						$output .= " <span class=\"value\">".$faxnumber[1]."</span>";
					$output .= "</div>\n";
				}
				if ($mobilephone)
				{
					$output .= "<div class=\"tel\"><span class=\"type\">"._("Mobile phone")."</span>:";
					foreach ($mobilephone as $mobilephonenumber)
						$output .= " <span class=\"value\" href=\"callto:".$mobilephonenumber[0]."\">".$mobilephonenumber[1]."</span>";
					$output .= "</div>\n";
				}
				if ($email)
				{
					$output .= "<div>"._("Email").":";
					foreach ($email as $emailaddress)
						$output .= " <a class=\"email\" href=\"mailto:".$emailaddress."\">".$emailaddress."</a>";
					$output .= "</div>\n";
				}
				$output .= "</div>\n";
			}

			// website and wikipedia links
			if ($website || $wikipedia[0])
			{
				$output .= "<div class=\"web\">\n";
				if ($website)
				{
					$output .= "<div>"._("Homepage").":";
					foreach ($website as $webaddress)
					{
						if (($caption = strlen($webaddress[1]) > 37) && (strlen($webaddress[1]) > 40))
							$caption = substr($webaddress[1], 0, 37)."...";
						else
							$caption = $webaddress[1];
						$output .= " <a class=\"url\" target=\"_blank\" href=\"".$webaddress[0]."\">".$caption."</a>\n";
					}
					$output .= "</div>\n";
				}
				if ($wikipedia[1])
					$output .= "<div class=\"wikipedia\">"._("Wikipedia").": <a target=\"_blank\" href=\"".$wikipedia[1]."\">".urldecode($wikipedia[2])."</a></div>\n";
				$output .= "</div>\n";
			}

			// operator
			if ($response['operator'])
				$output .= "<div class=\"operator\">"._("Operator").": ".$response['operator']."</div>\n";

			// opening hours
			if ($openinghours)
			{
				$output .= "<div class=\"openinghours\">"._("Opening hours").":<br />".$openinghours;
				if (isOpen247($response['openinghours']))
					$output .= "<br /><b class=\"open\">"._("Open 24/7")."</b>";
				else if (isPoiOpen($response['openinghours'], $offset))
					$output .= "<br /><b class=\"open\">"._("Now open")."</b>";
				else if (isInHoliday($response['openinghours'], $offset))
					$output .= "<br /><b class=\"maybeopen\">"._("Open on holiday")."</b>";
				else
					$output .= "<br /><b class=\"closed\">"._("Now closed")."</b>";
				$output .= "</div>\n";
			}

			// service times
			if ($servicetimes)
			{
				$output .= "<div class=\"servicetimes\">"._("Service hours").":<br />".$servicetimes;
				if (isPoiOpen($response['openinghours'], $offset))
					$output .= "<br /><b class=\"open\">"._("Now open")."</b>";
				else if (isInHoliday($response['servicetimes'], $offset))
					$output .= "<br /><b class=\"maybeopen\">"._("Open on holiday")."</b>";
				else
					$output .= "<br /><b class=\"closed\">"._("Now closed")."</b>";
				$output .= "</div>\n";
			}

			$output .= "</div>\n";

			return $output;
		}

		else
			return false;
	}


	// output of details data in xml format
	function xmlDetailsOut($response, $nameresponse, $wikipediaresponse, $langs = "en", $offset = 0, $id, $type)
	{
		if ($response)
		{
			$output = xmlStart("details id=\"".$id."\" type=\"".$type."\"");

			$name = getNameDetail($langs, $nameresponse);

			$phone = getPhoneFaxDetail(array($response['phone1'], $response['phone2'], $response['phone3']));
			$fax = getPhoneFaxDetail(array($response['fax1'], $response['fax2'], $response['fax3']));
			$mobilephone = getPhoneFaxDetail(array($element['mobilephone1'], $element['mobilephone2']));
			$website = getWebsiteDetail(array($response['website1'], $response['website2'], $response['website3'], $response['website4']));
			$email = getMailDetail(array($response['email1'], $response['email2'], $response['email3']));

			// get wikipedia link and make translation
			if ($wikipediaresponse)
				$wikipedia = getWikipediaDetail($langs, $wikipediaresponse);

			$openinghours = getOpeninghoursDetail($response['openinghours']);
			$servicetimes = getOpeninghoursDetail($response['servicetimes']);

			// printing popup details
			if ($name)
			{
				$output .= "<name";
				if ($name[0])
					$output .= " lang=\"".$name[1]."\"";
				$output .= ">".$name[0]."</name>\n";
			}

			// address information
			if ($response['street'] || $response['housenumber'] || $response['country'] || $response['postcode'] || $response['city'])
			{
				$output .= "<address>\n";
				if ($response['street'])
					$output .= "<street>".$response['street']."</street>\n";
				if ($response['housenumber'])
					$output .= "<housenumber>".$response['housenumber']."</housenumber>\n";
				if ($response['country'])
					$output .= "<country>".strtoupper($response['country'])."</country>\n";
				if ($response['postcode'])
					$output .= "<postcode>".$response['postcode']."</postcode>\n";
				if ($response['city'])
					$output .= "<city>".$response['city']."</city>\n";
				if ($response['suburb'])
					$output .= "<suburb>".$response['suburb']."</suburb>\n";
				$output .= "</address>\n";
			}

			// contact information
			if ($phone || $fax || $mobilephone || $email)
			{
				$output .= "<contact>\n";
				if ($phone)
					foreach ($phone as $phonenumber)
						$output .= " <phone>".$phonenumber[1]."</phone>";
				if ($fax)
					foreach ($fax as $faxnumber)
						$output .= " <fax>".$faxnumber[1]."</fax>";
				if ($mobilephone)
					foreach ($mobilephone as $mobilephonenumber)
						$output .= " <mobilephone>".$mobilephonenumber[1]."</mobilephone>";
				if ($email)
					foreach ($email as $emailaddress)
						$output .= " <email>".$emailaddress."</email>";
				$output .= "</contact>\n";
			}

			// website and wikipedia links
			if ($website || $wikipedia[0])
			{
				$output .= "<web>\n";
				foreach ($website as $webaddress)
					if ($webaddress[0])
						$output .= "<website>".$webaddress[0]."</website>\n";
				if ($wikipedia[1])
					$output .= "<wikipedia>".$wikipedia[1]."</wikipedia>\n";
				$output .= "</web>\n";
			}

			// operator
			if ($response['operator'])
				$output .= "<operator>".$response['operator']."</operator>\n";

			// opening hours
			if ($openinghours)
			{
				$output .= "<openinghours state=\"";

				if (isPoiOpen($response['openinghours'], $offset))
					$output .= "open";
				else if (isInHoliday($response['openinghours'], $offset))
					$output .= "maybeopen";
				else
					$output .= "closed";

				$output .= "\">".$response['openinghours']."</openinghours>\n";
			}

			// service times
			if ($servicetimes)
			{
				$output .= "<servicetimes state=\"";

				if (isPoiOpen($response['servicetimes'], $offset))
					$output .= "open";
				else if (isInHoliday($response['servicetimes'], $offset))
					$output .= "maybeopen";
				else
					$output .= "closed";

				$output .= "\">".$response['servicetimes']."</servicetimes>\n";
			}

			// image, only images from domains listed on a whitelist are supported
			if (imageDomainAllowed($response['image']))
			{
				$url = getImageUrl($response['image']);
				$output .= "<image>";
 					$output .= $url;
				$output .= "</image>\n";
			}
			elseif (getWikipediaImage($wikipedia[1]))
			{
				$image = getWikipediaImage($wikipedia[1]);

				$output .= "<image>";
					$output .= $image;
				$output .= "</image>\n";
			}

			$output .= "</details>";

			return $output;
		}
		else
			return false;
	}


	// output of details data in json format
	function jsonDetailsOut($response, $nameresponse, $wikipediaresponse, $langs = "en", $offset = 0, $id, $type, $callback)
	{
		if ($response)
		{
			$name = getNameDetail($langs, $nameresponse);

			$phone = getPhoneFaxDetail(array($response['phone1'], $response['phone2'], $response['phone3']));
			$fax = getPhoneFaxDetail(array($response['fax1'], $response['fax2'], $response['fax3']));
			$mobilephone = getPhoneFaxDetail(array($element['mobilephone1'], $element['mobilephone2']));
			$website = getWebsiteDetail(array($response['website1'], $response['website2'], $response['website3'], $response['website4']));
			$email = getMailDetail(array($response['email1'], $response['email2'], $response['email3']));

			// get wikipedia link and make translation
			if ($wikipediaresponse)
				$wikipedia = getWikipediaDetail($langs, $wikipediaresponse);

			$openinghours = getOpeninghoursDetail($response['openinghours']);
			$servicetimes = getOpeninghoursDetail($response['servicetimes']);

			$data = array(
				'id' => (int)$id,
				'type' => $type,
			);

			// name
			if ($name)
			{
				if ($name[0])
					$data['name'] = array('lang' => $name[1], 'name' => $name[0]);
				else
					$data['name'] = $name[0];
			}

			// address information
			if ($response['street'])
				$data['street'] = $response['street'];
			if ($response['housenumber'])
				$data['housenumber'] = $response['housenumber'];
			if ($response['country'])
				$data['country'] = strtoupper($response['country']);
			if ($response['postcode'])
				$data['postcode'] = $response['postcode'];
			if ($response['city'])
				$data['city'] = $response['city'];
			if ($response['suburb'])
				$data['suburb'] = $response['suburb'];

			// contact information
			if ($phone)
			{
				$tmp = array();
				foreach($phone as $phonenumber)
					array_push($tmp, $phonenumber[1]);
				$data['phone'] = $tmp;
			}
			if ($fax)
			{
				$tmp = array();
				foreach($fax as $faxnumber)
					array_push($tmp, $faxnumber[1]);
				$data['fax'] = $tmp;
			}
			if ($mobilephone)
			{
				$tmp = array();
				foreach($mobilephone as $mobilephonenumber)
					array_push($tmp, $mobilephonenumber[1]);
				$data['mobilephone'] = $tmp;
			}
			if ($email)
				$data['email'] = $email;

			// website and wikipedia links
			if ($website)
			{
				$tmp = array();
				foreach($website as $webaddress)
					array_push($tmp, $webaddress[0]);
				$data['website'] = $tmp;
			}
			if ($wikipedia[1])
				$data['wikipedia'] = $wikipedia[1];

			// operator
			if ($response['operator'])
				$data['operator'] = $response['operator'];

			// opening hours
			if ($openinghours)
			{
				if (isPoiOpen($response['openinghours'], $offset))
					$state .= "open";
				else if (isInHoliday($response['openinghours'], $offset))
					$state .= "maybeopen";
				else
					$state .= "closed";

				$data['openinghours'] = array('state' => $state, 'openinghours' => $response['openinghours']);
			}

			// service times
			if ($servicetimes)
			{
				if (isPoiOpen($response['servicetimes'], $offset))
					$state .= "open";
				else if (isInHoliday($response['servicetimes'], $offset))
					$state .= "maybeopen";
				else
					$state .= "closed";

				$data['servicetimes'] = array('state' => $state, 'servicetimes' => $response['servicetimes']);
			}

			// image, only images from domains listed on a whitelist are supported
			if (imageDomainAllowed($response['image']))
				$data['image'] = getImageUrl($response['image']);
			else if (getWikipediaImage($wikipedia[1]))
				$data['image'] = getWikipediaImage($wikipedia[1]);

			$jsonData = json_encode($data);
			// JSONP request?
			if (isset($callback))
				return $callback.'('.$jsonData.')';
			else
				return $jsonData;
		}

		else
			return false;
	}
?>
