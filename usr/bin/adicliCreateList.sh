#!/bin/bash
# ==============================================================================
#
# Author: Marcelo Barreto Nees <marcelo.linux@gmail.com>
#
# ==============================================================================

conf_header=/usr/share/adicli/header
conf_db_engine=/usr/share/adicli/db_engine

if [ ! -e $conf_header ] || [ ! -e $conf_db_engine ] ; then

  echo "Error: Some framework files not found found."
  exit 1

fi

source $conf_header
source $conf_db_engine

# ==============================================================================
#
#                             Generate List
#
# ==============================================================================

DATABASE=$(basename $conf_file|sed -e 's/.conf$//g')


cat <<EOF
<?php
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Wrapper\TQuickGrid;

class ${ACTIVE_RECORD}List extends TPage
{
    private \$datagrid;
    private \$loaded;

    function __construct()
    {
        parent::__construct();

        \$this->datagrid = new TQuickGrid;

EOF


# ==============================================================================
#
#                               Table Fields
#
# ==============================================================================
echo "$db_command"|$db_connector|egrep -v '^( |$|CONSTRAINT)'|awk '{print $1,$2}'|while read field type; do
  type=$(echo $type|sed -e 's/(.*//g')

  case $type in
  	varchar)
  		type_adianti="TEntry";
  	;;
  
  	datetime|timestamp)
  		type_adianti="TDate";
  	;;
  
  	*)
  		type_adianti="TEntry";
  	;;
  esac

  echo "        \$this->datagrid->addQuickColumn('$field', '$field', 'right', 200);"
done

cat <<EOF

        \$edit = new TDataGridAction(array('${ACTIVE_RECORD}Form', 'onEdit'));
        \$this->datagrid->addQuickAction('Editar', \$edit, 'id', 'ico_edit.png');
        \$this->datagrid->createModel();

        parent::add(\$this->datagrid);
    }

    public function onReload(\$param = NULL)
    {
        try {
            TTransaction::open('$DATABASE');

            \$repository = new TRepository('$ACTIVE_RECORD');
            \$criteria = new TCriteria;
            \$objects = \$repository->load(\$criteria);

            \$this->datagrid->clear();

            if(\$objects)
            {
                foreach (\$objects as \$object) {
                    \$this->datagrid->addItem(\$object);
                }
            }

            TTransaction::close();

        } catch (Exception \$e) {
            new TMessage('error', \$e->getMessage());
        }
        \$this->loaded = TRUE;
    }

    public function show()
    {
        if(!\$this->loaded)
        {
            \$this->onReload();
        }
        parent::show();
    }
}
?>
EOF
