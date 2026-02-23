<?php
/**
 * {CLASS} Listing
 * @author <your name here>
 */
class {CLASS} extends TPage
{
    private $form; // form
    private $datagrid; // listing
    private $pageNavigation;
    private $formgrid;
    private $loaded;
    private $deleteButton;
    
    /**
     * Class constructor
     * Creates the page, the form and the listing
     */
    public function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new BootstrapFormBuilder('form_search_{ACTIVE_RECORD}');
        $this->form->setFormTitle('{ACTIVE_RECORD}');
        
##FORM_FIELDS##
        
        // keep the form filled during navigation with session data
        $this->form->setData( TSession::getValue(__CLASS__ . '_filter_data') );
        
        // add the search form actions
        $btn = $this->form->addAction(_t('Find'), 	new TAction([$this, 'onSearch']), 	'fa:search');
        $btn->class = 'btn btn-sm btn-primary';
        $this->form->addActionLink(_t('New'), 		new TAction(['{EDIT_ACTION}', 		'onEdit']), 	'fa:plus green');
	$this->form->addActionLink('Limpar Filtro',	new TAction([$this,                     'onClear']),   	'fa:filter red');
        
        // creates a Datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->datatable = 'true';
        $this->datagrid->disableDefaultClick();
        // $this->datagrid->enablePopover('Popover', 'Hi <b> {name} </b>');
        
##LIST_COLUMNS##


        $column_system_user_id->setTransformer(function ($value) {
            if ($value) {
                // return strtok(SystemUser::findInTransaction('permission', $value)->name, ' ');
                TTransaction::open('permission');
                $usuario = new SystemUser($value);
                $label   = strtok($usuario->name, ' ');
                $tooltip = $usuario->name;
                TTransaction::close();

                $div        = new TElement('span');
                $div->title = $tooltip;
                $div->add($label);
                return $div;                  
            }
        });

        $column_created_at->setTransformer(function ($value, $object, $row) {
            if ($value) {
                  $date = new DateTime($value);
                  return $date->format('d/m/Y H:i');
            }
        });

        $column_updated_at->setTransformer(function ($value, $object, $row) {
            if ($value) {
                  $date = new DateTime($value);
                  return $date->format('d/m/Y H:i');
            }
        });

        $action_edit = new TDataGridAction(['{EDIT_ACTION}', 'onEdit'], ['{PRIMARY_KEY}'=>'{{PRIMARY_KEY}}']);
        $action_delete = new TDataGridAction([$this, 'onDelete'], ['{PRIMARY_KEY}'=>'{{PRIMARY_KEY}}']);
        
        // $this->datagrid->addAction($action_edit, _t('Edit'),   'far:edit blue');
        // $this->datagrid->addAction($action_delete ,_t('Delete'), 'far:trash-alt red');
        
        $action_edit->setLabel('Editar');
        $action_edit->setImage('far:edit blue');

        $action_delete->setLabel('Excluir');
        $action_delete->setImage('far:trash-alt red');

        $action_group = new TDataGridActionGroup('', 'fa:th');
        $action_group->addHeader('Opções');
        $action_group->addAction($action_edit);
        $action_group->addAction($action_delete);
        $this->datagrid->addActionGroup($action_group);

        // create the datagrid model
        $this->datagrid->createModel();
        
        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());
        $this->pageNavigation->enableCounters();
 
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
    
    /**
     * Inline record editing
     * @param $param Array containing:
     *              key: object ID value
     *              field name: object attribute to be updated
     *              value: new attribute content 
     */
    public function onInlineEdit($param)
    {
        try
        {
            // get the parameter $key
            $field = $param['field'];
            $key   = $param['key'];
            $value = $param['value'];
            
            TTransaction::open('{DATABASE}'); // open a transaction with database
            $object = new {ACTIVE_RECORD}($key); // instantiates the Active Record
            $object->{$field} = $value;
            $object->store(); // update the object in the database
            TTransaction::close(); // close the transaction
            
            $this->onReload($param); // reload the listing
            new TMessage('info', "Record Updated");
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * Register the filter in the session
     */
    public function onSearch()
    {
        // get the search form data
        $data = $this->form->getData();
        
        // clear session filters
##FILTER_SEARCHS##
        
        // fill the form with data again
        $this->form->setData($data);
        
        // keep the search data in the session
        TSession::setValue(__CLASS__ . '_filter_data', $data);
        
        $param = array();
        $param['offset']    =0;
        $param['first_page']=1;
        $this->onReload($param);
    }
    
    /**
     * Load the datagrid with data
     */
    public function onReload($param = NULL)
    {
        try
        {
            // open a transaction with database '{DATABASE}'
            TTransaction::open('{DATABASE}');
            
            // creates a repository for {ACTIVE_RECORD}
            $repository = new TRepository('{ACTIVE_RECORD}');
            $limit = {LIMIT};
            // creates a criteria
            $criteria = new TCriteria;
            
            // default order
            if (empty($param['order']))
            {
                $param['order'] = '{PRIMARY_KEY}';
                $param['direction'] = 'asc';
            }
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            
##SESSION_FILTERS##
            
            // load the objects according to criteria
            $objects = $repository->load($criteria, FALSE);
            
            if (is_callable($this->transformCallback))
            {
                call_user_func($this->transformCallback, $objects, $param);
            }
            
            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }
            
            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);
            
            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit
            
            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * Ask before deletion
     */
    public static function onDelete($param)
    {
        // define the delete action
        $action = new TAction([__CLASS__, 'Delete']);
        $action->setParameters($param); // pass the key parameter ahead
        
        // shows a dialog to the user
        new TQuestion(AdiantiCoreTranslator::translate('Do you really want to delete ?'), $action);
    }
    
    /**
     * Delete a record
     */
    public static function Delete($param)
    {
        try
        {
            $key=$param['key']; // get the parameter $key
            TTransaction::open('{DATABASE}'); // open a transaction with database
            $object = new {ACTIVE_RECORD}($key, FALSE); // instantiates the Active Record
            $object->delete(); // deletes the object from the database
            TTransaction::close(); // close the transaction
            
            $pos_action = new TAction([__CLASS__, 'onReload']);
            new TMessage('info', AdiantiCoreTranslator::translate('Record deleted'), $pos_action); // success message
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }
    
    /**
     * method show()
     * Shows the page
     */
    public function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
        }
        parent::show();
    }

    /**
     * onClear
     * Clears the Search Form session vars
     */
    public function onClear()
    {
        try {
            $this->form->clear();
            TSession::setValue(__CLASS__ . '_items', array());
            $this->onSearch();
        } catch (exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
}
