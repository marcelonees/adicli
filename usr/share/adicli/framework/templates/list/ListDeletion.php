<?php
/**
 * {CLASS} Record selection
 * @author <your name here>
 */
class {CLASS} extends TPage
{
    protected $form;     // search form
    protected $datagrid; // listing
    protected $pageNavigation;
    
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
        $this->form = new BootstrapFormBuilder('form_search_{ACTIVE_RECORD}');
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
        $column_{PRIMARY_KEY}->setTransformer([$this, 'formatRow'] );
        
        // creates the datagrid actions
        $action1 = new TDataGridAction([$this, 'onSelect'], ['{PRIMARY_KEY}' => '{{PRIMARY_KEY}}', 'register_state' => 'false']);
        //$action1->setUseButton(TRUE);
        $action1->setButtonClass('btn btn-default');
                
        // add the actions to the datagrid
        $this->datagrid->addAction($action1, 'Select', 'far:square fa-fw black');
        
        // create the datagrid model
        $this->datagrid->createModel();
        
        // create the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        $panel = new TPanelGroup;
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);
        $panel->addHeaderActionLink( _t('Delete'), new TAction([$this, 'deleteSelected']), 'far:trash-alt red' );
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add($panel);
        
        parent::add($container);
    }
    
    /**
     * Save the object reference in session
     */
    public function onSelect($param)
    {
        // get the selected objects from session 
        $selected_objects = TSession::getValue(__CLASS__.'_delete_objects');
        
        TTransaction::open('{DATABASE}');
        $key = $param['{PRIMARY_KEY}'];
        if (isset($selected_objects[ $key ]))
        {
            unset($selected_objects[ $key ]);
        }
        else
        {
            $selected_objects[ $key ] = $key;
        }
        TSession::setValue(__CLASS__.'_delete_objects', $selected_objects); // put the array back to the session
        TTransaction::close();
        
        // reload datagrids
        $this->onReload( func_get_arg(0) );
    }
    
    /**
     * Highlight the selected rows
     */
    public function formatRow($value, $object, $row)
    {
        $selected_objects = TSession::getValue(__CLASS__.'_delete_objects');
        
        if ($selected_objects)
        {
            if (in_array( (int) $value, array_keys( $selected_objects ) ) )
            {
                $row->style = "background: #abdef9";
                
                $button = $row->find('i', ['class'=>'far fa-square fa-fw black'])[0];
                if ($button)
                {
                    $button->class = 'far fa-check-square fa-fw black';
                }
            }
        }
        
        return $value;
    }
    
    /**
     * Delete selected records
     */
    public static function deleteSelected()
    {
		try
		{
			$selected_objects = TSession::getValue(__CLASS__.'_delete_objects');
			
			if ($selected_objects)
			{
				TTransaction::open('{DATABASE}');
				foreach ($selected_objects as $id)
				{
					$object = {ACTIVE_RECORD}::find($id);
					if ($object)
					{
						$object->delete();
					}
				}
				TTransaction::close();
				
				new TMessage('info', 'Records deleted', new TAction([__CLASS__, 'onReload']));
			}
			TSession::setValue(__CLASS__.'_delete_objects', []);
		}
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
}
