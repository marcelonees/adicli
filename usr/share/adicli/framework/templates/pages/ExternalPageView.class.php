<?php
class ExternalPageView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $iframe = new TElement('iframe');
        $iframe->id = "iframe_external";
        $iframe->src = "{path}";
        $iframe->frameborder = "0";
        $iframe->scrolling = "yes";
        $iframe->width = "100%";
        $iframe->height = "700px";
        
        parent::add($iframe);
    }
}
