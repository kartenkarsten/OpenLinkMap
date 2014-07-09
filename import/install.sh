#!/bin/bash

# OpenLinkMap Copyright (C) 2010 Alexander Matheisen
# This program comes with ABSOLUTELY NO WARRANTY.
# This is free software, and you are welcome to redistribute it under certain conditions.
# See http://wiki.openstreetmap.org/wiki/OpenLinkMap for details.


# ATTENTION: DO NOT RUN THIS SCRIPT! You have to change paths and modify parameters to your own environment!
# This install script is written for CentOS. It may be necessary to change it for using on other linux distributions.

PROJECTPATH=/home/www/sites/194.245.35.149/site/olm


# install necessary software
yum install gzip zlib zlib-devel postgresql-server postgresql-libs postgresql postgresql-common postgis geoip GeoIP geoip-devel GeoIP-devel php-pecl-geoip php-php-gettext wget

pecl install geoip

# add extension=geoip.so to php.ini


if [ ! -e /usr/share/GeoIP ]; then
	mkdir /usr/share/GeoIP
fi
cd /usr/share/GeoIP
# clean up first so we unpack the latest one, and not the first one ever downloaded
rm -Rf /usr/share/GeoIP/GeoIP.dat.g*
rm -Rf /usr/share/GeoIP/GeoLiteCity.dat.g*
# Since they seem to block based on user agents of curl/wget, keep them happy with some mac user agent, if not you will get 404
# country
wget --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.112 Safari/534.30"  http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz
gunzip GeoIP.dat.gz
# cities
wget --user-agent="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_6_8) AppleWebKit/534.30 (KHTML, like Gecko) Chrome/12.0.742.112 Safari/534.30"  http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz
gunzip GeoLiteCity.dat.gz
mv GeoLiteCity.dat GeoIPCity.dat


echo "Compiling tools"
wget -O - http://m.m.i24.cc/osmupdate.c | cc -x c - -o osmupdate
wget -O - http://m.m.i24.cc/osmfilter.c | cc -x c - -o osmfilter
wget -O - http://m.m.i24.cc/osmconvert.c | cc -x c - -lz -o osmconvert


echo "Installing osmosis"
if [ -d osmosis ] ; then
	# cleaning old stuff
	rm -Rf osmosis
fi
mkdir -p osmosis
cd osmosis
wget -O - http://bretth.dev.openstreetmap.org/osmosis-build/osmosis-latest.tgz | tar xz
cd ..


# set up database
su postgres
createuser olm


createdb -E UTF8 -O olm olm
createlang plpgsql olm
psql -d olm -f /usr/share/pgsql/contrib/postgis-64.sql
psql -d olm -f /usr/share/pgsql/contrib/postgis-1.5/spatial_ref_sys.sql
psql -d olm -f /usr/share/pgsql/contrib/hstore.sql
psql -d olm -f /usr/share/pgsql/contrib/_int.sql

echo "ALTER TABLE geometry_columns OWNER TO olm; ALTER TABLE spatial_ref_sys OWNER TO olm;"  | psql -d olm
echo "ALTER TABLE geography_columns OWNER TO olm;"  | psql -d olm


createdb -E UTF8 -O olm nextobjects
createlang plpgsql nextobjects

psql -d nextobjects -f /usr/share/pgsql/contrib/postgis-64.sql
psql -d nextobjects -f /usr/share/pgsql/contrib/postgis-1.5/spatial_ref_sys.sql
psql -d nextobjects -f /usr/share/pgsql/contrib/hstore.sql
psql -d nextobjects -f /usr/share/pgsql/contrib/_int.sql

echo "ALTER TABLE geometry_columns OWNER TO olm; ALTER TABLE spatial_ref_sys OWNER TO olm;"  | psql -d nextobjects
echo "ALTER TABLE geography_columns OWNER TO olm;"  | psql -d nextobjects


# database olm
echo "CREATE TABLE nodes (id bigint, tags hstore);" | psql -d olm
echo "SELECT AddGeometryColumn('nodes', 'geom', 4326, 'POINT', 2);" | psql -d olm
echo "CREATE INDEX geom_index_nodes ON nodes USING GIST(geom);" | psql -d olm
echo "CLUSTER nodes USING geom_index_nodes;" | psql -d olm
echo "CREATE INDEX id_index_nodes ON nodes (id);" | psql -d olm
echo "CLUSTER nodes USING id_index_nodes;" | psql -d olm
echo "CREATE INDEX tag_index_nodes ON nodes USING GIST (tags);" | psql -d olm
echo "CLUSTER nodes USING tag_index_nodes;" | psql -d olm

echo "CREATE TABLE ways (id bigint, tags hstore);" | psql -d olm
echo "SELECT AddGeometryColumn('ways', 'geom', 4326, 'POINT', 2);" | psql -d olm
echo "CREATE INDEX geom_index_ways ON ways USING GIST(geom);" | psql -d olm
echo "CLUSTER ways USING geom_index_ways;" | psql -d olm
echo "CREATE INDEX id_index_ways ON ways (id);" | psql -d olm
echo "CLUSTER ways USING id_index_ways;" | psql -d olm
echo "CREATE INDEX tag_index_ways ON ways USING GIST (tags);" | psql -d olm
echo "CLUSTER ways USING tag_index_ways;" | psql -d olm

echo "CREATE TABLE relations (id bigint, tags hstore);" | psql -d olm
echo "SELECT AddGeometryColumn('relations', 'geom', 4326, 'POINT', 2);" | psql -d olm
echo "CREATE INDEX geom_index_relations ON relations USING GIST(geom);" | psql -d olm
echo "CLUSTER relations USING geom_index_relations;" | psql -d olm
echo "CREATE INDEX id_index_relations ON relations (id);" | psql -d olm
echo "CLUSTER relations USING id_index_relations;" | psql -d olm
echo "CREATE INDEX tag_index_relations ON relations USING GIST (tags);" | psql -d olm
echo "CLUSTER relations USING tag_index_relations;" | psql -d olm

echo "GRANT all ON nodes TO olm;" | psql -d olm
echo "GRANT all ON ways TO olm;" | psql -d olm
echo "GRANT all ON relations TO olm;" | psql -d olm

echo "GRANT truncate ON nodes TO olm;" | psql -d olm
echo "GRANT truncate ON ways TO olm;" | psql -d olm
echo "GRANT truncate ON relations TO olm;" | psql -d olm

echo "ALTER TABLE nodes OWNER TO olm;" | psql -d olm
echo "ALTER TABLE ways OWNER TO olm;" | psql -d olm
echo "ALTER TABLE relations OWNER TO olm;" | psql -d olm


# database nextobjects
echo "CREATE TABLE nodes (id bigint, tags hstore);" | psql -d nextobjects
echo "SELECT AddGeometryColumn('nodes', 'geom', 4326, 'POINT', 2);" | psql -d nextobjects
echo "CREATE INDEX geom_index_nodes ON nodes USING GIST(geom);" | psql -d nextobjects
echo "CLUSTER nodes USING geom_index_nodes;" | psql -d nextobjects
echo "CREATE INDEX id_index_nodes ON nodes (id);" | psql -d nextobjects
echo "CLUSTER nodes USING id_index_nodes;" | psql -d nextobjects
echo "CREATE INDEX tag_index_nodes ON nodes USING GIST (tags);" | psql -d nextobjects
echo "CLUSTER nodes USING tag_index_nodes;" | psql -d nextobjects

echo "CREATE TABLE ways (id bigint, tags hstore);" | psql -d nextobjects
echo "SELECT AddGeometryColumn('ways', 'geom', 4326, 'POINT', 2);" | psql -d nextobjects
echo "CREATE INDEX geom_index_ways ON ways USING GIST(geom);" | psql -d nextobjects
echo "CLUSTER ways USING geom_index_ways;" | psql -d nextobjects
echo "CREATE INDEX id_index_ways ON ways (id);" | psql -d nextobjects
echo "CLUSTER ways USING id_index_ways;" | psql -d nextobjects
echo "CREATE INDEX tag_index_ways ON ways USING GIST (tags);" | psql -d nextobjects
echo "CLUSTER ways USING tag_index_ways;" | psql -d nextobjects

echo "CREATE TABLE relations (id bigint, tags hstore);" | psql -d nextobjects
echo "SELECT AddGeometryColumn('relations', 'geom', 4326, 'POINT', 2);" | psql -d nextobjects
echo "CREATE INDEX geom_index_relations ON relations USING GIST(geom);" | psql -d nextobjects
echo "CLUSTER relations USING geom_index_relations;" | psql -d nextobjects
echo "CREATE INDEX id_index_relations ON relations (id);" | psql -d nextobjects
echo "CLUSTER relations USING id_index_relations;" | psql -d nextobjects
echo "CREATE INDEX tag_index_relations ON relations USING GIST (tags);" | psql -d nextobjects
echo "CLUSTER relations USING tag_index_relations;" | psql -d nextobjects

echo "GRANT all ON nodes TO olm;" | psql -d nextobjects
echo "GRANT all ON ways TO olm;" | psql -d nextobjects
echo "GRANT all ON relations TO olm;" | psql -d nextobjects

echo "GRANT truncate ON nodes TO olm;" | psql -d nextobjects
echo "GRANT truncate ON ways TO olm;" | psql -d nextobjects
echo "GRANT truncate ON relations TO olm;" | psql -d nextobjects

echo "ALTER TABLE nodes OWNER TO olm;" | psql -d nextobjects
echo "ALTER TABLE ways OWNER TO olm;" | psql -d nextobjects
echo "ALTER TABLE relations OWNER TO olm;" | psql -d nextobjects


# access
echo "CREATE ROLE apache;" | psql -d olm

echo "GRANT SELECT ON nodes TO apache;" | psql -d nextobjects
echo "GRANT SELECT ON ways TO apache;" | psql -d nextobjects
echo "GRANT SELECT ON relations TO apache;" | psql -d nextobjects
echo "GRANT SELECT ON nodes TO apache;" | psql -d olm
echo "GRANT SELECT ON ways TO apache;" | psql -d olm
echo "GRANT SELECT ON relations TO apache;" | psql -d olm

echo "CREATE ROLE w3_user1;" | psql -d olm

echo "GRANT SELECT ON nodes TO w3_user1;" | psql -d nextobjects
echo "GRANT SELECT ON ways TO w3_user1;" | psql -d nextobjects
echo "GRANT SELECT ON relations TO w3_user1;" | psql -d nextobjects
echo "GRANT SELECT ON nodes TO w3_user1;" | psql -d olm
echo "GRANT SELECT ON ways TO w3_user1;" | psql -d olm
echo "GRANT SELECT ON relations TO w3_user1;" | psql -d olm
