<?php
class SidePageView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        parent::setTargetContainer('adianti_right_panel');
        
        // create the HTML Renderer
        $this->html = new THtmlRenderer('app/resources/page_sample.html');
        
        // replace the main section variables
        $this->html->enableSection('main');
        
        parent::add($this->html);          
    }
}
