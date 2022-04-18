<?php
class ContainerWindowView extends TWindow
{
    private $form;
    
    function __construct()
    {
        parent::__construct();
        parent::setTitle('Window');
        
        // with: 500, height: automatic
        parent::setSize(500, null); // use 0.6, 0.4 (for relative sizes 60%, 40%)
        
        // create the HTML Renderer
        $this->html = new THtmlRenderer('app/resources/page_sample.html');
        
        // replace the main section variables
        $this->html->enableSection('main');
        
        parent::add($this->html);            
    }
}
