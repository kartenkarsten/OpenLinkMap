#!/bin/bash

# OpenLinkMap Copyright (C) 2010 Alexander Matheisen
# This program comes with ABSOLUTELY NO WARRANTY.
# This is free software, and you are welcome to redistribute it under certain conditions.
# See http://wiki.openstreetmap.org/wiki/OpenLinkMap for details.


# working directory, please change
cd /home/www/sites/194.245.35.149/site/import
PATH="$PATH:/home/www/sites/194.245.35.149/site/import/bin"
export JAVACMD_OPTIONS=-Xmx2800M


# update planet file, ~ 50 min
echo "Updating planet file"
echo ""
date -u +%s > timestamp_tmp
osmupdate old.pbf new.pbf --max-merge=2 --hourly --drop-author -v
rm old.pbf
mv new.pbf old.pbf
echo ""


# convert planet file, ~ 25 min
echo "Converting planet file"
echo ""
osmconvert old.pbf --out-o5m >temp.o5m
echo ""


# filter planet file, ~ 35 min
echo "Filtering planet file"
echo ""
osmfilter temp.o5m --keep="wikipedia= wikipedia:*= contact:phone= website= url= phone= fax= email= addr:email= image= url:official= contact:website= addr:phone= phone:mobile= contact:mobile= addr:fax= contact:email= contact:fax= image:panorama= opening_hours=" --out-o5m >temp-olm.o5m

osmfilter temp.o5m --keep="amenity=bus_station highway=bus_stop railway=station railway=halt railway=tram_stop amenity=parking highway=platform railway=platform" --out-o5m >temp-nextobjects.o5m
rm temp.o5m
echo ""


# create centroids, remove not-node elements, ~ 2 min
echo "Creating centroids, removing elements"
echo ""
osmconvert temp-olm.o5m --all-to-nodes --max-objects=90000000 --out-o5m >temp.o5m
rm temp-olm.o5m
osmfilter temp.o5m --drop-relations --drop-ways --keep-nodes="wikipedia= wikipedia:*= contact:phone= website= url= phone= fax= email= addr:email= image= url:official= contact:website= addr:phone= phone:mobile= contact:mobile= addr:fax= contact:email= contact:fax= image:panorama= opening_hours=" --out-o5m >temp-olm.o5m
rm temp.o5m
osmconvert temp-olm.o5m --fake-lonlat --fake-author --out-pbf >temp.pbf
rm temp-olm.o5m
osmosis-0.42/bin/osmosis --rb file="temp.pbf" --s --wb file="olm.pbf" omitmetadata="true"
rm temp.pbf
osmconvert olm.pbf --drop-author --out-o5m >olm.o5m
rm olm.pbf

osmconvert temp-nextobjects.o5m --all-to-nodes --max-objects=90000000 --out-o5m >temp.o5m
rm temp-nextobjects.o5m
osmfilter temp.o5m --drop-relations --drop-ways --keep-nodes="amenity=bus_station highway=bus_stop railway=station railway=halt railway=tram_stop amenity=parking highway=platform railway=platform" --out-o5m >temp-nextobjects.o5m
rm temp.o5m
osmconvert temp-nextobjects.o5m --fake-lonlat --fake-author --out-pbf >temp.pbf
rm temp-nextobjects.o5m
osmosis-0.42/bin/osmosis --rb file="temp.pbf" --s --wb file="nextobjects.pbf" omitmetadata="true"
rm temp.pbf
osmconvert nextobjects.pbf --drop-author --out-o5m >nextobjects.o5m
rm nextobjects.pbf
echo ""


# generate diffs, ~ 2 min
echo "Generate diffs"
echo ""
osmconvert old-olm.o5m olm.o5m --diff-contents >olm.o5c
rm old-olm.o5m
mv olm.o5m old-olm.o5m

osmconvert old-nextobjects.o5m nextobjects.o5m --diff-contents >nextobjects.o5c
rm old-nextobjects.o5m
mv nextobjects.o5m old-nextobjects.o5m
echo ""


# updating of database by diffs, ~ 2 min
echo "Updating of database"
echo ""
php update.php
rm olm.o5c
rm nextobjects.o5c
# ADDED FOR OPENRAILWAYMAP
../orm/import/update.sh
# END
rm timestamp
mv timestamp_tmp timestamp
echo ""
