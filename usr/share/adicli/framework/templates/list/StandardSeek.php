<?php
/**
 * {CLASS} Listing
 * @author <your name here>
 */
class {CLASS} extends TWindow
{
    protected $form;
    protected $datagrid;
    protected $pageNavigation;
    protected $filterFields;
    protected $formFilters;
    protected $filterTransformers;
    protected $loaded;
    protected $limit;
    protected $operators;
    protected $order;
    protected $direction;
    protected $criteria;
    protected $transformCallback;
    
    use Adianti\base\AdiantiStandardListTrait;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        parent::setTitle( AdiantiCoreTranslator::translate('Search record') );
        parent::setSize(0.7, null);
        
        $this->setDatabase('{DATABASE}');            // defines the database
        $this->setActiveRecord('{ACTIVE_RECORD}');   // defines the active record
        $this->setDefaultOrder('{PRIMARY_KEY}', 'asc');         // defines the default order
        // parent::setCriteria($criteria) // define a standard filter

##FILTER_FIELDS##
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_{ACTIVE_RECORD}');
        //$this->form->setFormTitle('{ACTIVE_RECORD}');
        
##FORM_FIELDS##
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue('{ACTIVE_RECORD}_filter_data') );
        
        // add the search form actions
        $this->form->addAction(_t('Find'), new TAction(array($this, 'onSearch')), 'fa:search');
        
        // creates a DataGrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
##LIST_COLUMNS##
        
        // create SELECT action
        $action_select = new TDataGridAction(array($this, 'onSelect'));
        $action_select->setUseButton(TRUE);
        $action_select->setButtonClass('nopadding');
        $action_select->setLabel('');
        $action_select->setImage('fa:hand-pointer green');
        $action_select->setField('{PRIMARY_KEY}');
        $this->datagrid->addAction($action_select);
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%;margin-bottom:0;border-radius:0';
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    /**
     * Executed when the user chooses the record
     */
    public static function onSelect($param)
    {
        try
        {
            $key = $param['key'];
            TTransaction::open('{DATABASE}');
            
            // load the active record
            $object = {ACTIVE_RECORD}::find($key);
            
            // closes the transaction
            TTransaction::close();
            
            $send = new StdClass;
            $send->{ACTIVE_RECORD_LOWER}_id = $object->{PRIMARY_KEY};
            TForm::sendData('form_name_REPLACE_HERE', $send);
            
            parent::closeWindow(); // closes the window
        }
        catch (Exception $e)
        {
            $send = new StdClass;
            $send->{ACTIVE_RECORD_LOWER}_id = '';
            TForm::sendData('form_name_REPLACE_HERE', $send);
            
            // undo pending operations
            TTransaction::rollback();
        }
    }
}
