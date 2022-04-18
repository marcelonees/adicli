<?php
/**
 * {CLASS} Listing
 * @author <your name here>
 */
class {CLASS} extends TPage
{
    protected $form;     // registration form
    protected $datagrid; // listing
    protected $pageNavigation;
    protected $formgrid;
    protected $saveButton;
    
    use Adianti\base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->setDatabase('{DATABASE}');            // defines the database
        $this->setActiveRecord('{ACTIVE_RECORD}');   // defines the active record
        $this->setDefaultOrder('{PRIMARY_KEY}', 'asc');         // defines the default order
        // $this->setCriteria($criteria) // define a standard filter

##FILTER_FIELDS##
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_update_{ACTIVE_RECORD}');
        $this->form->setFormTitle('{ACTIVE_RECORD}');
        
##FORM_FIELDS##
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        $btn = $this->form->addAction(_t('Find'), new TAction([$this, 'onSearch']), 'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
##LIST_COLUMNS##
        
        $column_{EDIT_FIELD}->setTransformer( function($value, $object, $row) {
            $widget = new {COMPONENT}('{EDIT_FIELD}' . '_' . $object->id);
            $widget->setValue( $object->{EDIT_FIELD} );
            //$widget->setSize(120);
            $widget->setFormName('form_update_{ACTIVE_RECORD}');
            
            $action = new TAction( [$this, 'onSaveInline'], ['column' => '{EDIT_FIELD}' ] );
            $widget->{CHANGE_ACTION}( $action );
            return $widget;
        });
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    /**
     * Save the datagrid objects
     */
    public static function onSaveInline($param)
    {
        $name   = $param['_field_name'];
        $value  = $param['_field_value'];
        $column = $param['column'];
        
        $parts  = explode('_', $name);
        $id     = end($parts);
        
        try
        {
            // open transaction
            TTransaction::open('{DATABASE}');
            
            $object = {ACTIVE_RECORD}::find($id);
            if ($object)
            {
                $object->$column = $value;
                $object->store();
            }
            
            TToast::show('success', 'Record saved', 'bottom center', 'far:check-circle');
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            // show the exception message
            TToast::show('error', $e->getMessage(), 'bottom center', 'fa:exclamation-triangle');
        }
    }
}
