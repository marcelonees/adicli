<?php
/**
 * {CLASS} Master/Detail
 * @author <your name here>
 */
class {CLASS} extends {PARENT_CLASS}
{
    protected $form;
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
        $this->form = new BootstrapFormBuilder('form_{ACTIVE_RECORD}');
        $this->form->setFormTitle('{ACTIVE_RECORD}');
        
        $this->fieldlist = new TFieldList;
        $this->fieldlist->width = '100%';
        $this->fieldlist->enableSorting();
        
        // add field list to the form
        $this->form->addContent( [$this->fieldlist] );
        
##DETAIL_FIELD[0]##

##DETAIL_FIELD[1]##

##DETAIL_FIELD[2]##

##DETAIL_FIELD[3]##
        
        $this->fieldlist->addHeader();
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addCloneAction();
        
        // create an action button (save)
        $this->form->addAction( 'Save', new TAction([$this, 'onSave']), 'fa:save blue');
        
        // create the page container
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
        parent::add($container);
    }
    
    /**
     * Clear form
     */
    public function onClear($param)
    {
    }
    
    /**
     * Save the {ACTIVE_RECORD}
     */
    public static function onSave($param)
    {
        try
        {
            TTransaction::open('{DATABASE}');
            
            if( !empty($param['list_{FIRST_FIELD}']) AND is_array($param['list_{FIRST_FIELD}']) )
            {
                foreach( $param['list_{FIRST_FIELD}'] as $row => ${FIRST_FIELD})
                {
                    if (!empty(${FIRST_FIELD}))
                    {
                        $detail = new {ACTIVE_RECORD};
##DETAIL_FIELD[4]##
                        $detail->store();
                    }
                }
            }
            
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
