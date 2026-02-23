<?php
/**
 * {CLASS} Form
 * @author <your name here>
 */
class {CLASS} extends {PARENT_CLASS}
{
    protected $form; // form
    private $embedded;
    

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct($param, $embedded = false)
    {
        parent::__construct();
    
        $this->embedded = $embedded;

        if (!$this->embedded) {
            parent::setTargetContainer('adianti_right_panel');
        }


        ##INIT_METHODS##
        // creates the form
        $this->form = new BootstrapFormBuilder('form_{ACTIVE_RECORD}');
        // $this->form->setFormTitle('{ACTIVE_RECORD}');

        if (!$this->embedded) {
            $this->form->setFormTitle('{ACTIVE_RECORD}');
            $this->form->addHeaderActionLink(_t('Close'),   new TAction([__CLASS__, 'onClose'], ['static' => '1']), 'fa:times red');
            $this->form->addActionLink(_t('Close'),         new TAction([__CLASS__, 'onClose'], ['static' => '1']), 'fa:times red');
        } else {
            $this->form->addActionLink(_t('Back'), new TAction(array('{ACTIVE_RECORD}List', 'onReload')),  'fa:arrow-alt-circle-left blue');
        }


        ##FORM_SETUP##
##FORM_FIELDS##

        if (!empty(${PRIMARY_KEY}))
        {
            ${PRIMARY_KEY}->setEditable(FALSE);
        }
        $system_user_id->setEditable(FALSE);
        $login->setEditable(FALSE);
        $created_at->setEditable(FALSE);
        $updated_at->setEditable(FALSE);
        
        $system_user_id->setSize('100%');
        $login->setSize('100%');
        $created_at->setSize('100%');
        $updated_at->setSize('100%');

        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:save');
        $btn->class = 'btn btn-sm btn-primary';
        //$this->form->addActionLink(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
    	// $this->form->addActionLink(_t('Back'), new TAction(array('{ACTIVE_RECORD}List', 'onReload')),  'fa:arrow-alt-circle-left blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
        parent::add($container);
    }

    /**
     * Save form data
     * @param $param Request
     */
    public function onSave( $param )
    {
        try
        {
            TTransaction::open('{DATABASE}'); // open a transaction
            
            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/
            
            $this->form->validate(); // validate form data
            $data = $this->form->getData(); // get form data as array
            
            $object = new {ACTIVE_RECORD};  // create an empty object
            $object->fromArray( (array) $data); // load the object with data
            $object->store(); // save the object
            
            // get the generated {PRIMARY_KEY}
            $data->{PRIMARY_KEY} = $object->{PRIMARY_KEY};
            
            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction
            
            TToast::show('info', AdiantiCoreTranslator::translate('Record saved'), 'top right', 'far:check-circle');
            $this->onClose();

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(TRUE);
    }
    
    /**
     * Load object to form data
     * @param $param Request
     */
    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open('{DATABASE}'); // open a transaction
                $object = new {ACTIVE_RECORD}($key); // instantiates the Active Record
                $this->form->setData($object); // fill the form
                TTransaction::close(); // close the transaction
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Closes window
     */
    public static function onClose()
    {
        TScript::create("Template.closeRightPanel()");
    }

}
