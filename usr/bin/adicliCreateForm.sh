#!/bin/bash

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
#                          Generate Quick Form
#
# ==============================================================================

pid=$$

DATABASE=$(basename $conf_file|sed -e 's/.conf$//g')

cat <<EOF
<?php

use Adianti\Base\TStandardForm;
use Adianti\Control\TAction;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Wrapper\TQuickForm;

/**
 * Constructor method
 */
class ${ACTIVE_RECORD}Form extends TStandardForm
{
    /** @var string form Form $ACTIVE_RECORD */
    protected \$form; //form

    public function __construct()
    {
        parent::__construct();

        parent::setDatabase('$DATABASE');
        parent::setActiveRecord('$ACTIVE_RECORD');

        \$this->form = new TQuickForm('form_$ACTIVE_RECORD');

EOF

echo "$db_command"|$db_connector|egrep -v '^( |$|CONSTRAINT)'|awk '{print $1,$2}'|while read field type; do

  type=$(echo $type|sed -e 's/(.*//g;')

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

  echo "        \$$field = new $type_adianti('$field');"               >> /tmp/adiantiCreateForm-Objects-$pid.txt
  echo "        \$this->form->addQuickField('$field', \$$field, 200);" >> /tmp/adiantiCreateForm-Fields-$pid.txt
  
done

cat /tmp/adiantiCreateForm-Objects-$pid.txt; echo
cat /tmp/adiantiCreateForm-Fields-$pid.txt; echo

rm -f /tmp/adiantiCreateForm-Objects-$pid.txt /tmp/adiantiCreateForm-Fields-$pid.txt

cat <<EOF
        \$this->form->addQuickAction('Salvar',
            new TAction(array(\$this, 'onSave')), 'ico_save.png');

        \$this->form->addQuickAction('Listar',
            new TAction(array('${ACTIVE_RECORD}List', 'onReload')), 'ico_datagrid.png');

        parent::add(\$this->form);
    }


    /**
     * onSave method
     */
    public function onSave()
    {
        try {
            TTransaction::open('$DATABASE');

            \$object = \$this->form->getData('$ACTIVE_RECORD');
            \$object->store();
            \$this->form->setData(\$object);
            new TMessage('info', 'Salvo com sucesso!');

            TTransaction::close();
        }
        catch (Exception \$e) {
            new TMessage('error', \$e->getMessage());
            TTransaction::rollback();
        }
    }


    /**
     * onEdit method
     * @param int $param
     */
    public function onEdit(\$param)
    {
        try {
            TTransaction::open('$DATABASE');

            \$key = \$param['key'];
            \$object = new $ACTIVE_RECORD(\$key);
            \$this->form->setData(\$object);

            TTransaction::close();
        } catch (Exception \$e) {
            new TMessage('error', \$e->getMessage());
        }
    }

}

EOF
