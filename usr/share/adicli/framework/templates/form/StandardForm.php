<?php
/**
 * {CLASS} Registration
 * @author <your name here>
 */
class {CLASS} extends {PARENT_CLASS}
{
    protected $form; // form
    
    use Adianti\Base\AdiantiStandardFormTrait; // Standard form methods
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        ##INIT_METHODS##
        $this->setDatabase('{DATABASE}');              // defines the database
        $this->setActiveRecord('{ACTIVE_RECORD}');     // defines the active record
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_{ACTIVE_RECORD}');
        $this->form->setFormTitle('{ACTIVE_RECORD}');
        ##FORM_SETUP##
##FORM_FIELDS##
        
        if (!empty(${PRIMARY_KEY}))
        {
            ${PRIMARY_KEY}->setEditable(FALSE);
        }
        
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
         
        // create the form actions
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:save');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'),  new TAction([$this, 'onEdit']), 'fa:eraser red');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        
        parent::add($container);
    }
}
