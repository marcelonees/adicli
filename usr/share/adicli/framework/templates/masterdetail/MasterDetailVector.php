<?php
/**
 * {CLASS} Master/Detail
 * @author <your name here>
 */
class {CLASS} extends {PARENT_CLASS}
{
    protected $form; // form
    protected $fieldlist;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct($param)
    {
        parent::__construct($param);
        
        ##INIT_METHODS##
        // creates the form
        $this->form = new BootstrapFormBuilder('form_{ACTIVE_RECORD_MASTER}');
        $this->form->setFormTitle('{ACTIVE_RECORD_MASTER}');
        
        // master fields
##MASTER_FIELD[0]##

        // sizes
##MASTER_FIELD[1]##

        if (!empty(${PRIMARY_KEY}))
        {
            ${PRIMARY_KEY}->setEditable(FALSE);
        }
        
        // add form fields to the form
##MASTER_FIELD[2]##
        
        
        // detail fields
        $this->fieldlist = new TFieldList;
        $this->fieldlist-> width = '100%';
        $this->fieldlist->enableSorting();

##DETAIL_FIELD[0]##

##DETAIL_FIELD[1]##

##DETAIL_FIELD[2]##

##DETAIL_FIELD[3]##
        
        $this->form->addFields( [new TFormSeparator('{ACTIVE_RECORD_DETAIL}') ] );
        $this->form->addFields( [$this->fieldlist] );
        
        // create actions
        $this->form->addAction( _t('Save'),  new TAction( [$this, 'onSave'] ),  'fa:save green' );
        $this->form->addAction( _t('Clear'), new TAction( [$this, 'onClear'] ), 'fa:eraser red' );
        
        // create the page container
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    /**
     * Executed whenever the user clicks at the edit button da datagrid
     */
    function onEdit($param)
    {
        try
        {
            TTransaction::open('{DATABASE}');
            
            if (isset($param['key']))
            {
                $key = $param['key'];
                
                $object = new {ACTIVE_RECORD_MASTER}($key);
                $this->form->setData($object);
                
                $items  = {ACTIVE_RECORD_DETAIL}::where('{JOIN_FIELD}', '=', $key)->load();
                
                if ($items)
                {
                    $this->fieldlist->addHeader();
                    foreach($items  as $item )
                    {
                        $detail = new stdClass;
##DETAIL_FIELD[5]##
                        $this->fieldlist->addDetail($detail);
                    }
                    
                    $this->fieldlist->addCloneAction();
                }
                else
                {
                    $this->onClear($param);
                }
                
                TTransaction::close(); // close transaction
	    }
	    else
            {
                $this->onClear($param);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * Clear form
     */
    public function onClear($param)
    {
        $this->fieldlist->addHeader();
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addCloneAction();
    }
    
    /**
     * Save the {ACTIVE_RECORD_MASTER} and the {ACTIVE_RECORD_DETAIL}'s
     */
    public static function onSave($param)
    {
        try
        {
            TTransaction::open('{DATABASE}');
            
            $id = (int) $param['{PRIMARY_KEY}'];
            $master = new {ACTIVE_RECORD_MASTER};
            $master->fromArray( $param);
            $master->store(); // save master object
            
            // delete details
            {ACTIVE_RECORD_DETAIL}::where('{JOIN_FIELD}', '=', $master->{PRIMARY_KEY})->delete();
            
            if( !empty($param['list_{FIRST_FIELD}']) AND is_array($param['list_{FIRST_FIELD}']) )
            {
                foreach( $param['list_{FIRST_FIELD}'] as $row => ${FIRST_FIELD})
                {
                    if (!empty(${FIRST_FIELD}))
                    {
                        $detail = new {ACTIVE_RECORD_DETAIL};
                        $detail->{JOIN_FIELD} = $master->{PRIMARY_KEY};
##DETAIL_FIELD[4]##
                        $detail->store();
                    }
                }
            }
            
            $data = new stdClass;
            $data->{PRIMARY_KEY} = $master->{PRIMARY_KEY};
            TForm::sendData('form_{ACTIVE_RECORD_MASTER}', $data);
            TTransaction::close(); // close the transaction
            
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}
