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
    public function __construct($param)
    {
        parent::__construct();
        
        ##INIT_METHODS##
        $this->form = new BootstrapFormBuilder('form_{ACTIVE_RECORD_MASTER}View');
        $this->form->setFormTitle('{ACTIVE_RECORD_MASTER}');
        // $this->form->addHeaderActionLink('Editar', new TAction(['{ACTIVE_RECORD_MASTER}Form', 'onEdit'],['key'=>$param['id']]), 'far:edit blue');
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%'; 
        // $container->add(new TXMLBreadCrumb('menu.xml', '{ACTIVE_RECORD_MASTER}List'));
        $container->add($this->form);

        parent::add($container);
    }
    
    /**
     * onEdit
     */
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('{DATABASE}');
            $master_object = new {ACTIVE_RECORD_MASTER}($param['key']);
            
##MASTER_FIELD[0]##

##MASTER_FIELD[1]##

##MASTER_FIELD[2]##
            
            $this->detail_list = new BootstrapDatagridWrapper( new TDataGrid );
            $this->detail_list->style = 'width:100%';
            $this->detail_list->disableDefaultClick();
            
##DETAIL_FIELD[0]##
            
            $this->detail_list->createModel();
            
            $items = {ACTIVE_RECORD_DETAIL}::where('{JOIN_FIELD}', '=', $master_object->{PRIMARY_KEY})->load();
            $this->detail_list->addItems($items);
            
            $panel = new TPanelGroup('Itens', '#f5f5f5');
            $panel->add($this->detail_list);
            
            $this->form->addContent([$panel]);
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}
