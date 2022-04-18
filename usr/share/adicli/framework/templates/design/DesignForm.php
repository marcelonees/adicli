<?php
/**
 * {CLASS} Registration
 * @author <your name here>
 */
class {CLASS} extends TPage
{
    private $form;
    private $datagrid;
    private $pageNavigation;
    private $loaded;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TForm('form_{ACTIVE_RECORD}');
        
        try
        {
            // TUIBuilder object
            $ui = new TUIBuilder(500,500);
            $ui->setController($this);
            $ui->setForm($this->form);
            
            // reads the xml form
            $ui->parseFile('{FORM_PATH}');
            
            // get the interface widgets
            $fields = $ui->getWidgets();
            // look for the TDataGrid object
            foreach ($fields as $name => $field)
            {
                if ($field instanceof TDataGrid)
                {
                    $this->datagrid = $field;
                    $this->pageNavigation = $this->datagrid->getPageNavigation();
                }
            }
            
            // add the TUIBuilder panel inside the TForm object
            $this->form->add($ui);
            // set form fields from interface fields
            $this->form->setFields($ui->getFields());
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
        
        // add the form to the page
        parent::add($this->form);
    }
    
##METHODS##
}
