#!/bin/bash

# ==============================================================================
#
# Author: Marcelo Barreto Nees <marcelo.linux@gmail.com>
#
# ==============================================================================

# Any subsequent(*) commands which fail will cause the shell script to exit immediately
set -e

# https://stackoverflow.com/questions/2870992/automatic-exit-from-bash-shell-script-on-error
#set -euxo pipefail

# Must be root
if [ $(whoami) != "root" ] ; then
  echo "$0: Error - You must be root to install adicli!"
  exit 1
fi


# Structure and file permissions
mkdir -p /etc/adicli/databases 
mkdir -p /usr/share/adicli

cp -R -f etc/adicli/*       /etc/adicli/
cp -R -f usr/share/adicli/* /usr/share/adicli/
cp    -f usr/bin/adicli     /usr/bin/

chown -R root:root /etc/adicli /usr/share/adicli/
chmod -R 755 /etc/adicli/      /usr/share/adicli/ /usr/bin/adicli
chmod +x /usr/bin/adicli


# adicli successfully installed
echo "adicli successfully installed!"
