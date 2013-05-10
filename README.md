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


License:

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.


This project contains also code/data from other projects:

* The icon is taken from the Oxygen-Iconset, available under GNU LGPLv3: http://www.oxygen-icons.org/
* osmfilter
    * http://wiki.openstreetmap.org/wiki/Osmfilter
    * Author: Markus Weber
    * available under GNU GPLv3
* osmconvert
    * http://wiki.openstreetmap.org/wiki/Osmconvert
    * Author: Markus Weber
    * available under GNU GPLv3
* osmupdate
    * http://wiki.openstreetmap.org/wiki/Osmupdate
    * Author: Markus Weber
    * available under GNU GPLv3
* OpenLayers
    * http://openlayers.org/
    * available under 2-clause BSD License (FreeBSD)
* Osmosis
    * https://github.com/openstreetmap/osmosis
    * available under 2-clause BSD License (FreeBSD)

ATTENTION: The included binaries can only be used on i386 Linux systems. If you use other systems, you have to compile the programs for your environment.
