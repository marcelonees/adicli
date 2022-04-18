<?php
class SinglePageView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        // create the HTML Renderer
        $this->html = new THtmlRenderer('app/resources/page_sample.html');
        
        // replace the main section variables
        $this->html->enableSection('main');
        
        parent::add($this->html);
    }
}
