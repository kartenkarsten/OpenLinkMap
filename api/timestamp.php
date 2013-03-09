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
	$lang = $_GET['lang'];
	if (!$lang)
		$lang = getUserLang();
	// offset of user's timezone to UTC
	$offset = offset($_GET['offset']);
	$callback = $_GET['callback'];

	date_default_timezone_set("UTC");


	// getting timestamp
	$timestamp = implode(" ", @file("../import/timestamp"));

	if ($timestamp)
	{
		if ($format == "xml")
			echo xmlTimestampOut($timestamp, $offset, $lang);
		else if ($format == "json")
			echo jsonTimestampOut($timestamp, $offset, $lang, $callback);
		else
			echo textTimestampOut($timestamp, $offset);
	}
	else
		echo "NULL";


	// output of timestamp data in plain text format, given: timestamp of last update, offset to user's timezone in hours, lang
	function textTimestampOut($lastupdate, $offset = 0)
	{
		if ($lastupdate)
		{
			header("Content-Type: text/plain; charset=UTF-8");

			$difference = timeAgo(time(), $lastupdate, $offset);

			$output .= timestampString($lastupdate, $offset);
			$output .= ", ";
			$output .= timeAgoString($difference);

			return $output;
		}

		else
			return false;
	}


	// output of timestamp data in xml format, given: timestamp of last update, offset to user's timezone in hours, lang
	function xmlTimestampOut($lastupdate, $offset = 0, $lang)
	{
		if ($lastupdate)
		{
			$difference = timeAgo(time(), $lastupdate, $offset);

			$output = xmlStart("last_update");

			$output .= "<timestamp>\n";
			$output .= "<unix>".substr($lastupdate, 0, -1)."</unix>\n";
			$output .= "<string>".timestampString($lastupdate, $offset)."</string>\n";
			$output .= "</timestamp>\n";

			$output .= "<difference>\n";
			$output .= "<unix>".$difference."</unix>\n";
			$output .= "<string lang=\"".$lang."\">".timeAgoString($difference)."</string>\n";
			$output .= "</difference>\n";

			$output .= "</last_update>\n";

			return $output;
		}

		else
			return false;
	}


	// output of timestamp data in json format, given: timestamp of last update, offset to user's timezone in hours, lang, JSONP callback function name
	function jsonTimestampOut($lastupdate, $offset = 0, $lang, $callback)
	{
		if ($lastupdate)
		{
			header("Content-Type: text/plain; charset=UTF-8");

			$difference = timeAgo(time(), $lastupdate, $offset);

			$jsonData = json_encode(
				array(
					'timestamp' => array(
						'unix' => substr($lastupdate, 0, -1),
						'string' => timestampString($lastupdate, $offset),
					),
					'difference' => array(
						'unix' => $difference,
						'lang' => $lang,
						'string' => timeAgoString($difference)
					)
				)
			);
			// JSONP request?
			if (isset($callback))
				return $callback.'('.$jsonData.')';
			else
				return $jsonData;
		}
		return false;
	}
?>
