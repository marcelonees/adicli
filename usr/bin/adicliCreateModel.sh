#!/bin/bash
# ==============================================================================
#
# Author: Marcelo Barreto Nees <marcelo.linux@gmail.com>
#
# ==============================================================================

conf_header=/usr/share/adicli/header
conf_db_engine=/usr/share/adicli/db_engine

if [ ! -e $conf_header ] || [ ! -e $conf_db_engine ] ; then

  echo "$0: Error - Some framework files not found found."
  exit 1

fi

source $conf_header
source $conf_db_engine


# ==============================================================================
#
#                             Generate Model
#
# ==============================================================================
cat <<EOF
<?php
use Adianti\Database\TRecord;

class $ACTIVE_RECORD extends TRecord
{
  const TABLENAME  = '$ACTIVE_RECORD';
  const PRIMARYKEY = '$PRIMARY_KEY';
  const IDPOLICY   = 'max'; // {max, serial}

  /**
   * Constructor method
   * @param \$id Primary key to be loaded (optional)
   */

  public function __construct(\$id = NULL)
  {
      parent::__construct(\$id);

EOF

# ==============================================================================
#
#                             Table fields
#
# ==============================================================================
echo "$db_command"|$db_connector|egrep -v '^( |$|CONSTRAINT)'|awk '{print $1,$2}'|while read field; do
  field=$(echo $field|sed -e 's/(.*//g; s/ .*//g')
  if [ "X$field" != "X" ] ; then
    echo "      parent::addAttribute('$field');"
  fi
done

cat <<EOF
  }
}
?>
EOF
