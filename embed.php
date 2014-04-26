<?php
	require_once("api/functions.php");

	if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $langs))
		$lang = $_GET['lang'];
	else
		$lang = getUserLang();

	includeLocale($lang);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<? echo $lang; ?>" lang="<? echo $lang; ?>">
	<head>
		<title><?=$appname?></title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="<? echo $lang; ?>" />
		<meta name="keywords" content="openstreetmap, openlinkmap, alexander matheisen, rurseekatze, openlayers, osm, matheisen, olm" />
		<meta name="title" content="<?=$appname?>" />
		<meta name="author" content="rurseekatze, Alexander Matheisen" />
		<meta name="publisher" content="rurseekatze, Alexander Matheisen" />
		<meta name="copyright" content="GNU General Public License v3" />
		<meta name="revisit-after" content="after 90 days" />
		<meta name="date" content="2010-01-01" />
		<meta name="page-topic" content="<?=$appname?>" />
		<meta name="robots" content="index,follow" />
		<link rel="shortcut icon" href="img/favicon.ico" type="image/vnd.microsoft.icon" />
		<link rel="icon" href="img/favicon.ico" type="image/vnd.microsoft.icon" />
		<meta http-equiv="content-script-type" content="text/javascript" />
		<meta http-equiv="content-style-type" content="text/css" />
		<link rel="stylesheet" type="text/css" href="css/embed.css" />
		<script type="text/javascript" src="js/OpenLayers.js"></script>
		<?php
			// params
			$latlon = getLatLon($_GET['id'], $_GET['type']);
			echo "<script type=\"text/javascript\">\n";
				echo "var params={\n";
				echo "id : ".(isValidId($_GET['id']) ? ($_GET['id']) : ("null")).",\n";
				echo "type : ".(isValidType($_GET['type']) ? ("'".$_GET['type']."'") : ("null")).",\n";
				echo "lat : ";
					if (isValidCoordinate($_GET['lat']))
						echo $_GET['lat'].",\n";
					else if ($latlon)
						echo $latlon[1].",\n";
					else
						echo "null,\n";
				echo "lon : ";
					if (isValidCoordinate($_GET['lon']))
						echo $_GET['lon'].",\n";
					else if ($latlon)
						echo $latlon[0].",\n";
					else
						echo "null,\n";
				echo "zoom : ".(isValidZoom($_GET['zoom']) ? ($_GET['zoom']) : ("null")).",\n";
				echo "offset : ".(isValidOffset($_GET['offset']) ? ($_GET['offset']) : ("null")).",\n";
				echo "lang : \"".$lang."\"\n";
				echo "};\n";
			echo "</script>\n";
		?>
		<script type="text/javascript" src="api/jstranslations.php?lang=<? echo $lang; ?>"></script>
		<script type="text/javascript" src="js/OpenStreetMap.js"></script>
		<script type="text/javascript" src="js/embed.js"></script>
	</head>
	<body onload="createMap();">
		<div id="mapFrame" class="mapFrame">
			<noscript>
				<p><b><?=_("Javascript is not activated")?></b><br /><?=_("Javascript is needed to show the map and run this website. Please turn on Javascript in your browser settings.")?></p>
			</noscript>
		</div>
	</body>
</html>
