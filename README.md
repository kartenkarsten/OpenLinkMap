OpenLinkMap - A map showing additional information based on OpenStreetMap.
==========================================================================

OpenLinkMap Copyright (C) 2010 Alexander Matheisen (Rurseekatze) <alexandermatheisen@ish.de> or <info@openlinkmap.org>
This program comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it under certain conditions.
See http://wiki.openstreetmap.org/wiki/OpenLinkMap for details.
Website: http://www.openlinkmap.org/


Requirements:
* See http://wiki.openstreetmap.org/wiki/OpenLinkMap


Download:
* Clone Github repository with latest version: git clone git://github.com/rurseekatze/OpenLinkMap.git
* Latest version on Github: https://github.com/rurseekatze/OpenLinkMap/archive/master.zip
* Older (and stable versions): http://wiki.openstreetmap.org/wiki/OpenLinkMap#Download


Wikipage:
* http://wiki.openstreetmap.org/wiki/OpenLinkMap


Installation:
* Copy all files and folders into a webserver directory
* Run manually the install script import/install.sh - it might not run correctly on every distribution/platform and has no error exceptions
* After successful installation, modify paths and parameters in every file and run import/import.sh
* Add a cronjob to run import/update.sh (daily seems to be a good frequency)

ATTENTION: The included binaries can only be used on i386 Linux systems. If you use other systems, you have to compile the programs for your environment.
