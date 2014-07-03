#!/bin/bash

# OpenLinkMap Copyright (C) 2010 Alexander Matheisen
# This program comes with ABSOLUTELY NO WARRANTY.
# This is free software, and you are welcome to redistribute it under certain conditions.
# See http://wiki.openstreetmap.org/wiki/OpenLinkMap for details.


# path to the project directory
PROJECTPATH=/home/www/sites/194.245.35.149/site/olm
# directory where the planet file and other data files are stored, can be equal to PROJECTPATH
DATAPATH=/home/www/sites/194.245.35.149/site/olm/import
PATH="$PATH:$DATAPATH/bin"
PATH="$PATH:$PROJECTPATH/import/bin/osm2pgsql"
export JAVACMD_OPTIONS=-Xmx4800M

cd $DATAPATH

echo "Started processing at $(date)"

# download planet file if not existing
echo "Getting planet file if necessary"
echo ""
if [ ! -f old.pbf ]; then
	echo "Planet file not existing, now downloading it"
	wget http://planet.openstreetmap.org/pbf/planet-latest.osm.pbf
	mv planet-latest.osm.pbf old.pbf
fi
echo ""


# update planet file
echo "Updating planet file"
echo ""
osmupdate old.pbf new.pbf --max-merge=5 --hourly --drop-author -v
rm old.pbf
mv new.pbf old.pbf
osmdate=`osmconvert old.pbf --out-timestamp | tr '[TZ]' ' ' | sed 's/ *$//g'`
date -u -d "$osmdate" +%s > timestamp
echo ""


# convert planet file
echo "Converting planet file"
echo ""
osmconvert old.pbf --drop-relations --out-o5m >temp.o5m
echo ""


# filter planet file
echo "Filtering planet file"
echo ""
osmfilter temp.o5m --keep="wikipedia= wikipedia:*= contact:phone= website= url= phone= fax= email= addr:email= image= url:official= contact:website= addr:phone= phone:mobile= contact:mobile= addr:fax= contact:email= contact:fax= image:panorama= opening_hours=" --out-o5m >temp-olm.o5m

osmfilter temp.o5m --keep="amenity=bus_station highway=bus_stop railway=station railway=halt railway=tram_stop amenity=parking highway=platform railway=platform public_transport=platform" --out-o5m >temp-nextobjects.o5m
rm temp.o5m
echo ""


# create centroids, remove not-node elements
echo "Creating centroids, removing elements"
echo ""
osmconvert temp-olm.o5m --all-to-nodes --object-type-offset=2000000000000000 --max-objects=150000000 --out-o5m >temp.o5m
rm temp-olm.o5m
osmfilter temp.o5m --drop-relations --drop-ways --keep-nodes="wikipedia= wikipedia:*= contact:phone= website= url= phone= fax= email= addr:email= image= url:official= contact:website= addr:phone= phone:mobile= contact:mobile= addr:fax= contact:email= contact:fax= image:panorama= opening_hours=" --out-o5m >temp-olm.o5m
rm temp.o5m
osmconvert temp-olm.o5m --fake-lonlat --fake-author --out-pbf >temp.pbf
rm temp-olm.o5m
osmosis-0.42/bin/osmosis --rb file="temp.pbf" --s --wb file="old-olm.pbf" omitmetadata="true"
rm temp.pbf
osmconvert old-olm.pbf --drop-author --out-osm >old-olm.osm
rm old-olm.pbf

osmconvert temp-nextobjects.o5m --all-to-nodes --object-type-offset=2000000000000000 --max-objects=150000000 --out-o5m >temp.o5m
rm temp-nextobjects.o5m
osmfilter temp.o5m --drop-relations --drop-ways --keep-nodes="amenity=bus_station highway=bus_stop railway=station railway=halt railway=tram_stop amenity=parking highway=platform railway=platform public_transport=platform" --out-o5m >temp-nextobjects.o5m
rm temp.o5m
osmconvert temp-nextobjects.o5m --fake-lonlat --fake-author --out-pbf >temp.pbf
rm temp-nextobjects.o5m
osmosis-0.42/bin/osmosis --rb file="temp.pbf" --s --wb file="old-nextobjects.pbf" omitmetadata="true"
rm temp.pbf
osmconvert old-nextobjects.pbf --drop-author --out-osm >old-nextobjects.osm
rm old-nextobjects.pbf
echo ""


# importing in database
echo "Importing in database"
echo ""
php import.php
osmconvert old-olm.osm --drop-author --out-o5m >old-olm.o5m
rm old-olm.osm
osmconvert old-nextobjects.osm --drop-author --out-o5m >old-nextobjects.o5m
rm old-nextobjects.osm
echo ""

echo "Finished processing at $(date)."
