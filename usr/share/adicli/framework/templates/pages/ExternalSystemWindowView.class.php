<?php
class ExternalSystemWindowView extends TWindow
{
    public function __construct()
    {
        parent::__construct();
        parent::setTitle('ExternalSystemWindowView');
        parent::setSize(0.8, 650);
        
        $iframe = new TElement('iframe');
        $iframe->id = "iframe_external";
        $iframe->src = "{path}";
        $iframe->frameborder = "0";
        $iframe->scrolling = "yes";
        $iframe->width = "100%";
        $iframe->height = "600px";
        
        parent::add($iframe);
    }
}
