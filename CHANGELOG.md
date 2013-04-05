OpenLinkMap Changelog
=====================

(all changes without author notice are by [@rurseekatze](https://github.com/rurseekatze)

## 7.5 (05.04.2013)

### Improvements

#### Backend improvements

 * Updated osmupdated, osmfilter, osmconvert
 * Updated osmosis to v0.42
 * Some improvements of installer script
 * Do not show disused next objects
 * Converted translations to gettext format
 * Copy platforms into the database

#### Frontend improvements

 * Added public transport layer
 * Added support for Osmosis TagTransform files
 * Added weblinks to realtime departures support with TagTransform rulefile
 * Added realtime departures support for various public transport operators/networks:
 ** AT: ÖBB
 ** BE: De Lijn
 ** DE: Deutsche Bahn, Verkehrsverbund Stuttgart, Stadtwerke Neuss, Stadtbus Eschwege, Nordhessischer Verkehrsverbund
 ** ES: Titsa
 ** IT: ATAC - by [@Madeco](https://github.com/Madeco) [#17](https://github.com/rurseekatze/OpenLinkMap/pull/17)
 * Added nederlands/dutch translation
 * Updated french translation with Transifex
 * Updated italian translation with Transifex and support by [@Madeco](https://github.com/Madeco) [#18](https://github.com/rurseekatze/OpenLinkMap/pull/18)
 * Optimized POI circle radius size & clustering behaviour to prevent map icons from being hidden by POI circle
 * Better CSS position of langselector
 * Hide non-loading tiles with CSS workaround
 * Show platforms on public-transport-layer
 * Added public transport layer in small-map-mode
 * Added public transport details

### Bugfixes

#### Backend bugfixes

 * Fixed wikipedia image parsing code
 * Wikipedia-own image was selected as related image
 * Fixed wikipedia description parsing code
 * Added OpenLayers-translators to langfiles
 * Bugfix: Array begins with element 0, not 1
 * Fixed wrong variable name in details - mobile phone was not shown
 * Bugfix: "&" converted to "&amp;" to avoid XML errors
 * Casting simplexml-object=>string was missing

#### Frontend bugfixes

 * Repaired embed mode for public transport POIs
 * Bugfix: Popups of clustered markers were not loading
 * Repaired nominatim search: removed workaround for bounded searches (https://trac.openstreetmap.org/ticket/4674)
 * Fixed some bugs in nominatim search
 * Repaired selection of japanese translation


## 7.4.1 (20.01.2013)

### Improvements

#### Backend improvements

 * Show suburb in default address format
 * Some improvements of french translation - by [@cquest](https://github.com/cquest) [#14](https://github.com/rurseekatze/OpenLinkMap/pull/14)

#### Frontend improvements

 * Added Changelog
 * Added download information to Readme

### Bugfixes

#### Frontend bugfixes

 * Removed go-dark-for-IE


## 7.4 (23.11.2012)

### Improvements

#### Backend improvements

 * Added Japanese translation - by [@higa4](https://github.com/higa4)
 * Return integer values for distance
 * Hide near objects which are too far away
 * Better error report procedure
 * Moved to new replication URL
 * Some performance tuning of the database import/update script
 * Updated osmfilter, osmupdate, osmconvert
 * Return only not-private parkings
 * Added suburbs to addresses
 * Address formats now depend on country

#### Frontend improvements

 * Use poi-type as name, if no name is tagged for poi
 * Repaired broken Nominatim-search
 * Update to OpenLayers 2.12
 * Added PayPal and Flattr Buttons
 * Style improvements
 * Updated attribution to ODbL
 * Loading more results in bounded search
 * Workaround for generating thumbnails of too small images
 * Improved search of related images by using the wikipedia article name instead of the poi name

### Bugfixes

#### Backend bugfixes

 * Fixed wikipedia image parsing code
 * Fixed wikipedia description parsing code
 * Fixed problems with timezone offset validity check

#### Frontend bugfixes

 * Repaired thumbnails of pictures smaller than the thumbnail size
 * Fixed broken link to wikimedia commons images
 * Some fixes concerning loading circle in the background of transparent images
 * Repaired thumbnails of SVG images


## 7.3.1 (22.06.2012)

### Improvements

#### Backend improvements

 * Added JSONP support - by [@neoascetic](https://github.com/neoascetic) [#11](https://github.com/rurseekatze/OpenLinkMap/pull/11)

#### Frontend improvements

 * Removed Osmarender layer - by [@dittaeva](https://github.com/dittaeva) [#10](https://github.com/rurseekatze/OpenLinkMap/pull/10)

### Bugfixes

#### Backend bugfixes

 * Fixed csv line end - by [@neoascetic](https://github.com/neoascetic) [#12](https://github.com/rurseekatze/OpenLinkMap/pull/12)
 * Fixed bug in requesting POIs from the database

#### Frontend bugfixes

 * Fixed typos
 * Fixed problems with geolocation in Android - by [@dittaeva](https://github.com/dittaeva) [#9](https://github.com/rurseekatze/OpenLinkMap/pull/9)
 * Fixed problems with images


## 7.3 (18.02.2012)

### Improvements

#### Frontend improvements

 * Added new mode to embed a small OpenLinkMap into another website
 * Show images even in popups
 * Show images with url to wikipedia commons page

### Bugfixes

#### Backend bugfixes

 * Minor fix of selected name language

#### Frontend bugfixes

 * Fixed small bugs with showing images
 * Corrected wrong translation of 24/7


## 7.2 (23.01.2012)

### Improvements

#### Backend improvements

 * Whole new update script, no problems anymore

#### Frontend improvements

 * Save selected language in permalink
 * Geolocation now based on GeoIP database, fixed problems with geolocation

### Bugfixes

#### Frontend bugfixes

 * Fixed empty popups in embed mode


## 7.1 (11.01.2012)

### Improvements

#### Backend improvements

 * Added user statistics
 * Improved error report in database import

#### Frontend improvements

 * Changed link to wikipage
 * Added russian translation - by [@NothisIm](https://github.com/NothisIm) [#5](https://github.com/rurseekatze/OpenLinkMap/pull/5)
 * Added language selection box

### Bugfixes

#### Backend bugfixes

 * Fixed database update problems
 * Fixed wrong url in error report
 * Fixed problems with french translation
 * Fixed problems with opening hours parsing when tag only contains time-interval

#### Frontend bugfixes

 * Fixed bug: geolocate when loading the website
 * Fixed typos
 * Added author of italian translation to copyrights
 * Fixed problems with setting boundingbox after search


## 7.0.3 (15.12.2011)

### Improvements

#### Backend improvements

 * Improved selection of foreign languages names
 * Improved selection of specific language wikipedia articles

### Bugfixes

#### Backend bugfixes

 * Added exceptions
 * Fixed wrong xml output of timestamp
 * Fixed problems with selection of names


## 7.0.2 (12.12.2011)

### Bugfixes

#### Backend bugfixes

 * Fixed bug in update script: problems with deleting nodes


## 7.0.1 (06.12.2011)

### Bugfixes

#### Backend bugfixes

 * Fixed problems with openinghours parsing code

#### Frontend bugfixes

 * Fixed problems with setting startposition
 * Fixed problems with permalinks
 * Fixed problems with searching by GET-parameter
 * Fixed problems with setting bounded parameter
 * Changed method to get permalinks to popup


## 7.0 (04.12.2011)

### Improvements

#### Backend improvements

 * Whole new database backend based on own database, diff-based updates and filebased preprocessing, removed old software which is no longer needed
 * Fixed wrong output order in extdetails
 * Added italian translation
 * Updated osmconvert
 * Added translation of cuisine=sri_lankan
 * Repaired/improved wikipedia-extract and wikipedia-image parsing code
 * Added id and type validation
 * Nextobjects now requests ways too
 * Do not request nextobjects with access=private
 * Select only one next object if there are more than one with the same name
 * Added install script
 * Variable application name
 * Improved error logging
 * Added relation support to API

#### Frontend improvements

 * Removed information and download pages
 * Added HTML-embed feature
 * Added locate-me button
 * Added link to Keepright
 * Updated OpenLayers to new version with multitouch support and kinetic dragging
 * Added beergarden detail
 * Improved behaviour of search
 * Changed method to get permalink to popups
 * Added translations
 * Added translation of noscript
 * Various improvements related to panorama feature
 * Removed panorama feature temporarily
 * Added -ms-linear-gradient, new format of -webkit-linear-gradient
 * Using thumbnails to improve performance
 * Changed extdetails image size for faster access
 * Added feature to give only id and type URL-parameters, lat and lon are added by a database request
 * Change mouse to pointer when hovering markers in embed mode

### Bugfixes

#### Backend bugfixes

 * Fixed problems with opening hours parsing
 * Some bugfixes of import/update process
 * Improved backend performance
 * Fixed translation of smoking=yes
 * Fixed bug in database timestamp file
 * Fixed ID offset problem of relations
 * Repaired extdetails URL-parameter
 * Various bugfixes concerning osm-object-type conversions
 * Fixed wrong object type of centroids

#### Frontend bugfixes

 * Some CSS style improvements
 * Fixed enter key in Firefox
 * Fixed bug in keypress event
 * Fixed link to Potlatch
 * Fixed problems with searching by GET-parameter
 * Fixed problems with setting bounded parameter
 * Fixed problems with setting startposition
 * Fixed problems with zooming in after clicking on a search result
 * Fixed bug with selecting bounds after search
 * Fixed problem with permalink to extdetails
 * Fixed problem with z-index of the map
 * Fixed some problems of fullscreen and panorama feature
 * Fixed bug with showing nextobjects: when showing next objects east of a poi, the map zoomed out to the whole world


## 6.0.6 (10.04.2011)

### Improvements

#### Frontend improvements

 * Improved behaviour of loading bar and failed details requests

### Bugfixes

#### Backend bugfixes

 * Fixed problems with update process


## 6.0.5 (10.04.2011)

### Improvements

#### Frontend improvements

 * Improved behaviour of loading bar and failed details requests

### Bugfixes

#### Backend bugfixes

 * Fixed problems with update process


## 6.0.4 (09.04.2011)

### Improvements

#### Backend improvements

 * Added some translations strings
 * Improved selection of cuisine=*
 * Improved parsing of openinghours
 * Simplified source code
 * Improved selection of images by wikipedia

#### Frontend improvements

 * Added popup offset

### Bugfixes

#### Backend bugfixes

 * Fixed problems with timezone offset
 * Fixed problems with showing near objects

#### Frontend bugfixes

 * Minor changes of searchoptions


## 6.0.3 (07.04.2011)

### Improvements

#### Backend improvements

 * modified update script, so even objects with only an image=* are shown


## 6.0.2 (06.04.2011)

### Bugfixes

#### Frontend bugfixes

 * Fixed problem with closing images in fullscreen mode
 * Fixed problems with popups that are displayed at clustered points; fixed problem with closing these popups and list of names


## 6.0.1 (05.04.2011)

### Bugfixes

#### Backend bugfixes

 * Fixed problems with conversion between olm and osm object types

#### Frontend bugfixes

 * Fixed problems in behaviour after clicking on a search result
 * Popups are not shown if there is no content to display in popups


## 6.0 (04.04.2011)

### Improvements

#### Backend improvements

 * New backend with database that contains preprocessed data for faster requests
 * Added french translation
 * Added some tag translations
 * Cleaned and simplified code
 * Improved parsing of openinghours
 * Improved performance
 * Added parsing of service_times=*
 * Fixed problems with getting the wikipedia extract
 * Nextobjects considers also parkings mapped as ways
 * If no image=* is set, the first image from the related wikipedia article is used
 * Added url GET parameters: "q" for search request (for example needed to set OLM as search engine in some browsers), "lang" to force a language
 * Open API to be used by other applications

#### Frontend improvements

 * New brighter design with better support by Internet Explorer
 * Improved selection of search result descriptions
 * Mobilephone number is also shown in the popup
 * Added resetbutton for search box
 * Asynchronous requests to improve performance and prevent browser from freezing
 * Points are clustered and no differentiation between tags any more
 * Improved behaviour and design of search-related messages
 * Stars of stars=* are shown as graphics in extdetails
 * Accuracy is considered by browser geolocation API to set start position of the map
 * New feature to search only in current map frame
 * Improved fullscreen mode of images
 * Search results are serially numbered and shown on the map
 * Removed animation of sidebar to keep the correct positioning of the map
 * After search requests the map extent is selected to show all results in the current map frame

### Bugfixes

#### Frontend bugfixes

 * Fixed some problems with geolocation by IP


## 5.2 (15.12.2010)

### Improvements

#### Backend improvements

 * Improved parsing code for getting the wikipedia extract
 * Improved format of addresses without housenumber or street
 * Improved openinghours parsing code: fixed errors of day intervals not ending on sunday, days separated with comma, time intervals that also cover the next day

#### Frontend improvements

 * www and http are removed from links


## 5.1 (30.11.2010)

### Improvements

#### Backend improvements

 * Improved opening hours parsing
 * Improved parsing of wikipedia extract

### Bugfixes

#### Backend bugfixes

 * Some database connections were not closed properly
 * Fixed problems with selecting the name in user's language

#### Frontend bugfixes

 * Fixed correct design of "hide-sidebar-button" in webkit
 * Fixed appearance of loading bar in wrong zoomlevels


## 5.0 (28.11.2010)

### Improvements

#### Backend improvements

 * Local copy of OpenLayers
 * Improved selection of wikipedia language
 * Improved selection of name in user's language
 * Protection against SQL-injections
 * Points are cached in json-tiles
 * Only points which are rendered by mapnik in the current zoom level are shown
 * Better parsing of openinghours, translation of abbreviations
 * Relations are displayed
 * Improved performance of database requests
 * Cleaned up code
 * Improved error handling of geolocation API
 * Optimized performance
 * Timestamp of last update considers user's offset
 * Added an indicator that shows whether a poi is currently open or not
 * Mobilephone numbers with tag phone:mobile=* are displayed
 * All points are shown in one layer, even points with no wikipedia or website but a phone number
 * Show more details related to a point (extdetails) in the sidebar, e.g. the first part of the related wikipedia article, a related image linked with image=* or the next busstop or parking
 * Due to possible copyright problems only images from wikimedia commons are shown

#### Frontend improvements

 * Modified style of markers
 * Too long links are displayed shorted in popups
 * Housename tagged with addr:housename=* is shown in the extdetails
 * Removed gap between footer and margin
 * Added multi-language support of OpenLayers
 * New hillshading background layer
 * The scaleline now considers the map projections and fits to the current map
 * If a searchresult is clicked, the map smoothly pans to this position
 * New close-button in popups
 * New design of searchbar and searchresults
 * The searchbox increases its size when hovered or focussed
 * Modified style of searchbox
 * Modified layout of popups
 * Searchbutton is integrated in searchbox
 * Background color of map is identical to color of empty tiles
 * Button to load more search results
 * Loading bar that displays when the points are loaded
 * The user can hide the searchbar by clicking on the margin of it
 * By clicking on such a next object like the next busstop, the map pans that both points are visible in the current map selection
 * Full-translated user interface, most matching language is used
 * If the browser does not support geolocation API, the start location is set by user's IP

### Bugfixes

#### Backend bugfixes

 * Fixed problems with details of relations

#### Frontend bugfixes

 * Repaired transparency of searchbar


## 4.4 (31.08.2010)

### Improvements

#### Backend improvements

 * Added user statistics


## 4.3 (13.08.2010)

### Improvements

#### Frontend improvements

 * Added CSS3 animations for Opera users


## 4.2.4 (07.08.2010)

### Improvements

#### Frontend bugfixes

 * Fixed some mistakes in the docs


## 4.2.3 (03.08.2010)

### Improvements

#### Backend bugfixes

 * Fixed problems with selecting a name in user's language


## 4.2.2 (16.07.2010)

### Improvements

#### Frontend improvements

 * Searchbar shows a scrollbar if needed

### Bugfixes

#### Backend bugfixes

 * Fixed error with output of emails

#### Frontend bugfixes

 * Fixed bug in Safari and other Webkit browsers that searchbar was slided in too early


## 4.2.1 (06.07.2010)

### Improvements

#### Backend improvements

 * Improved parsing of openinghours

### Bugfixes

#### Frontend bugfixes

 * Some corrections on infopage and tag documentation


## 4.2 (03.07.2010)

### Improvements

#### Backend improvements

 * Added some errors exceptions
 * Translation of linked wikipediaarticles depending on browser settings
 * Using names in other language to translate poi's names

#### Frontend improvements

 * Popups are opened only on click
 * Message when the user has to zoom in to see markers

### Bugfixes

#### Backend bugfixes

 * Fixed encoding problems with some wikipedia links
 * Fixed problems with linked paragraphs of wikipedia articles


## 4.1 (23.06.2010)

### Improvements

#### Frontend improvements

 * Link to osm.org object details


## 4.0 (22.06.2010)

### Improvements

#### Backend improvements

 * New hstore-database as data backend
 * Improved message of last database update
 * Translate wikipedia links into user's most preferred language
 * Fixed encoding problems in popups
 * Improved performance

#### Frontend improvements

 * Edit-links to Potlatch and JOSM
 * New permalink feature to link to specific popups
 * Improved popup-behaviour

### Bugfixes

#### Frontend bugfixes

 * Fixed bug with transparency of searchbar in Webkit


## 3.7.4 (10.04.2010)

### Bugfixes

#### Backend bugfixes

 * Fixed bug with wrong "_" in linked URLs


## 3.7.3 (08.04.2010)

### Bugfixes

#### Frontend bugfixes

 * Removed HTML-codes from popups


## 3.7.2 (08.04.2010)

### Improvements

#### Frontend improvements

 * New wikipedia icon


## 3.7.1 (04.04.2010)

### Improvements

#### Frontend improvements

 * Removed HTML entities from popups

### Bugfixes

#### Frontend bugfixes

 * Fixed bug when more than one popup was opened


## 3.7 (03.04.2010)

### Improvements

#### Frontend improvements

 * Loading image
 * Changed popup behaviour to behaviour in OLM version 2


## 3.6 (01.04.2010)

### Improvements

#### Frontend improvements

 * CSS 3 animations
 * New design of searchbox and searchbar


## 3.5.2 (27.02.2010)

### Improvements

#### Backend improvements

 * Search engine optimization


## 3.5.1 (26.02.2010)

### Bugfixes

#### Frontend bugfixes

 * Fixed problems with geolocation API


## 3.5 (21.02.2010)

### Bugfixes

#### Frontend bugfixes

 * Optimized for Internet Explorer 8


## 3.4 (18.02.2010)

### Improvements

#### Backend improvements

 * Show timestamp of last update


## 3.3 (17.02.2010)

### Improvements

#### Frontend improvements

 * Added user locating with geolocation API


## 3.2.1 (17.02.2010)

### Bugfixes

#### Backend bugfixes

 * Fixed problems with "ß" in wikipedia links


## 3.2 (15.02.2010)

### Improvements

#### Frontend improvements

 * Added search feature using Nominatim

### Bugfixes

#### Backend bugfixes

 * Fixed encoding problems with wikipedialinks


## 3.1 (05.02.2010)

### Improvements

#### Frontend improvements

 * Added button linked with OpenStreetBugs

### Bugfixes

#### Frontend bugfixes

 * Fixed minor bugs


## 3.0.3 (04.02.2010)

### Bugfixes

#### Frontend bugfixes

 * Fixed problems with opening links in new tabs/windows


## 3.0.2 (31.01.2010)

### Improvements

#### Frontend improvements

 * Changed data structure of poi details
 * Changed style of popup-content


## 3.0.1 (30.01.2010)

### Bugfixes

#### Frontend bugfixes

 * Removed HTML entities


## 3.0 (29.01.2010)

### Improvements

#### Backend improvements

 * Using database of poi-tools project now
 * More information in popups

### Bugfixes

#### Backend bugfixes

 * Fixed impreciseness of positions


## 2.0.1 (18.01.2010)

### Improvements

#### Backend improvements

 * Show the timestamp of the last update

### Bugfixes

#### Backend bugfixes

 * Fixed some minor bugs


## 2.0 (16.01.2010)

### Improvements

#### Backend improvements

 * New version with mysql database backend
 * Dynamic data requests


## 1.0 (01.01.2010)

### Created the project
