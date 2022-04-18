<?php
class WindowPDFView extends TWindow
{
    public function __construct()
    {
        parent::__construct();
        parent::setTitle('WindowPDFView');
        parent::setSize(0.8,0.8);
        
        $object = new TElement('object');
        $object->data  = '{path}';
        $object->type  = 'application/pdf';
        $object->style = "width: 100%; height:calc(100% - 10px)";
        
        parent::add($object);
    }
}

