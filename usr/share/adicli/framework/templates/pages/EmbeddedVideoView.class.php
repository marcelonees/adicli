<?php
class EmbeddedVideoView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $object = new TElement('iframe');
        $object->width       = '100%';
        $object->height      = '600px';
        $object->src         = '{path}';
        $object->frameborder = '0';
        $object->allow       = 'accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture';
        
        parent::add($object);
    }
}