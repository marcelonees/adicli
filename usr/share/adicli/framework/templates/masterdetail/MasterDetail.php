<?php
/**
 * {CLASS} Master/Detail
 * @author <your name here>
 */
class {CLASS} extends {PARENT_CLASS}
{
    protected $form; // form
    protected $detail_list;
    
    /**
     * Page constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        ##INIT_METHODS##
        // creates the form
        $this->form = new BootstrapFormBuilder('form_{ACTIVE_RECORD_MASTER}');
        $this->form->setFormTitle('{ACTIVE_RECORD_MASTER}');
        
        // master fields
##MASTER_FIELD[0]##

        // detail fields
        $detail_uniqid = new THidden('detail_uniqid');
        $detail_{PRIMARY_KEY_DETAIL} = new THidden('detail_{PRIMARY_KEY_DETAIL}');
##DETAIL_FIELD[0]##

        if (!empty(${PRIMARY_KEY}))
        {
            ${PRIMARY_KEY}->setEditable(FALSE);
        }
        
        // master fields
##MASTER_FIELD[1]##
        
        // detail fields
        $this->form->addContent( ['<h4>Details</h4><hr>'] );
        $this->form->addFields( [$detail_uniqid] );
        $this->form->addFields( [$detail_{PRIMARY_KEY_DETAIL}] );
        
##DETAIL_FIELD[1]##

        $add = TButton::create('add', [$this, 'onDetailAdd'], 'Register', 'fa:plus-circle green');
        $add->getAction()->setParameter('static','1');
        $this->form->addFields( [], [$add] );
        
        $this->detail_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->detail_list->setId('{ACTIVE_RECORD_DETAIL}_list');
        $this->detail_list->generateHiddenFields();
        $this->detail_list->style = "min-width: 700px; width:100%;margin-bottom: 10px";
        
        // items
        $this->detail_list->addColumn( new TDataGridColumn('uniqid', 'Uniqid', 'center') )->setVisibility(false);
        $this->detail_list->addColumn( new TDataGridColumn('{PRIMARY_KEY_DETAIL}', 'Id', 'center') )->setVisibility(false);
##DETAIL_FIELD[2]##

        // detail actions
        $action1 = new TDataGridAction([$this, 'onDetailEdit'] );
        $action1->setFields( ['uniqid', '*'] );
        
        $action2 = new TDataGridAction([$this, 'onDetailDelete']);
        $action2->setField('uniqid');
        
        // add the actions to the datagrid
        $this->detail_list->addAction($action1, _t('Edit'), 'fa:edit blue');
        $this->detail_list->addAction($action2, _t('Delete'), 'far:trash-alt red');
        
        $this->detail_list->createModel();
        
        $panel = new TPanelGroup;
        $panel->add($this->detail_list);
        $panel->getBody()->style = 'overflow-x:auto';
        $this->form->addContent( [$panel] );
        
        $this->form->addAction( 'Save',  new TAction([$this, 'onSave'], ['static'=>'1']), 'fa:save green');
        $this->form->addAction( 'Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // create the page container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    
    /**
     * Clear form
     * @param $param URL parameters
     */
    public function onClear($param)
    {
        $this->form->clear(TRUE);
    }
    
    /**
     * Add detail item
     * @param $param URL parameters
     */
    public function onDetailAdd( $param )
    {
        try
        {
            $this->form->validate();
            $data = $this->form->getData();
            
            /** validation sample
            if (empty($data->fieldX))
            {
                throw new Exception('The field fieldX is required');
            }
            **/
            
            $uniqid = !empty($data->detail_uniqid) ? $data->detail_uniqid : uniqid();
            
            $grid_data = [];
            $grid_data['uniqid'] = $uniqid;
            $grid_data['{PRIMARY_KEY_DETAIL}'] = $data->detail_{PRIMARY_KEY_DETAIL};
##DETAIL_FIELD[3]##
            
            // insert row dynamically
            $row = $this->detail_list->addItem( (object) $grid_data );
            $row->id = $uniqid;
            
            TDataGrid::replaceRowById('{ACTIVE_RECORD_DETAIL}_list', $uniqid, $row);
            
            // clear detail form fields
            $data->detail_uniqid = '';
            $data->detail_{PRIMARY_KEY_DETAIL} = '';
##DETAIL_FIELD[4]##
            
            // send data, do not fire change/exit events
            TForm::sendData( 'form_{ACTIVE_RECORD_MASTER}', $data, false, false );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());
            new TMessage('error', $e->getMessage());
        }
    }
    
    /**
     * Edit detail item
     * @param $param URL parameters
     */
    public static function onDetailEdit( $param )
    {
        $data = new stdClass;
        $data->detail_uniqid = $param['uniqid'];
        $data->detail_{PRIMARY_KEY_DETAIL} = $param['{PRIMARY_KEY_DETAIL}'];
##DETAIL_FIELD[5]##
        
        // send data, do not fire change/exit events
        TForm::sendData( 'form_{ACTIVE_RECORD_MASTER}', $data, false, false );
    }
    
    /**
     * Delete detail item
     * @param $param URL parameters
     */
    public static function onDetailDelete( $param )
    {
        // clear detail form fields
        $data = new stdClass;
        $data->detail_uniqid = '';
        $data->detail_{PRIMARY_KEY_DETAIL} = '';
##DETAIL_FIELD[8]##
        
        // send data, do not fire change/exit events
        TForm::sendData( 'form_{ACTIVE_RECORD_MASTER}', $data, false, false );
        
        // remove row
        TDataGrid::removeRowById('{ACTIVE_RECORD_DETAIL}_list', $param['uniqid']);
    }
    
    /**
     * Load Master/Detail data from database to form
     */
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('{DATABASE}');
            
            if (isset($param['key']))
            {
                $key = $param['key'];
                
                $object = new {ACTIVE_RECORD_MASTER}($key);
                $items  = {ACTIVE_RECORD_DETAIL}::where('{JOIN_FIELD}', '=', $key)->load();
                
                foreach( $items as $item )
                {
                    $item->uniqid = uniqid();
                    $row = $this->detail_list->addItem( $item );
                    $row->id = $item->uniqid;
                }
                $this->form->setData($object);
                TTransaction::close();
            }
            else
            {
                $this->form->clear(TRUE);
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }
    
    /**
     * Save the Master/Detail data from form to database
     */
    public function onSave($param)
    {
        try
        {
            // open a transaction with database
            TTransaction::open('{DATABASE}');
            
            $data = $this->form->getData();
            $this->form->validate();
            
            $master = new {ACTIVE_RECORD_MASTER};
            $master->fromArray( (array) $data);
            $master->store();
            
            {ACTIVE_RECORD_DETAIL}::where('{JOIN_FIELD}', '=', $master->{PRIMARY_KEY})->delete();
            
            if( $param['{ACTIVE_RECORD_DETAIL}_list_{FIRST_FIELD}'] )
            {
                foreach( $param['{ACTIVE_RECORD_DETAIL}_list_{FIRST_FIELD}'] as $key => $item_id )
                {
                    $detail = new {ACTIVE_RECORD_DETAIL};
##DETAIL_FIELD[7]##
                    $detail->{JOIN_FIELD} = $master->{PRIMARY_KEY};
                    $detail->store();
                }
            }
            TTransaction::close(); // close the transaction
            
            TForm::sendData('form_{ACTIVE_RECORD_MASTER}', (object) ['id' => $master->{PRIMARY_KEY}]);
            
            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'));
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback();
        }
    }
}
