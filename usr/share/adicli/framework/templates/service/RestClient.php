<?php
// load object by id
$location = '{URL}/rest.php';
$parameters = array();
$parameters['class'] = '{ACTIVE_RECORD}Service';
$parameters['method'] = 'load';
$parameters['id'] = '1';
$url = $location . '?' . http_build_query($parameters);
var_dump( json_decode( file_get_contents($url) ) );


// load object by id that does not exist
$location = '{URL}/rest.php';
$parameters = array();
$parameters['class'] = '{ACTIVE_RECORD}Service';
$parameters['method'] = 'load';
$parameters['id'] = '100';
$url = $location . '?' . http_build_query($parameters);
var_dump( json_decode( file_get_contents($url) ) );


// save a new object
$location = '{URL}/rest.php';
$parameters = array();
$parameters['class'] = '{ACTIVE_RECORD}Service';
$parameters['method'] = 'store';
$parameters['data'] = ['name' => 'Bento Goncalves', 'state_id' => '1' ];
$url = $location . '?' . http_build_query($parameters);
var_dump( json_decode( file_get_contents($url) ) );


// update an new object
$location = '{URL}/rest.php';
$parameters = array();
$parameters['class'] = '{ACTIVE_RECORD}Service';
$parameters['method'] = 'store';
$parameters['data'] = ['name' => 'Bento Goncalves ok', 'state_id' => '1', 'id' => 6 ];
$url = $location . '?' . http_build_query($parameters);
var_dump( json_decode( file_get_contents($url) ) );


// delete an object by id
$location = '{URL}/rest.php';
$parameters = array();
$parameters['class'] = '{ACTIVE_RECORD}Service';
$parameters['method'] = 'delete';
$parameters['id'] = '6';
$url = $location . '?' . http_build_query($parameters);
var_dump( json_decode( file_get_contents($url) ) );


// load all objects using pagination, and filter
$location = '{URL}/rest.php';
$parameters = array();
$parameters['class'] = '{ACTIVE_RECORD}Service';
$parameters['method'] = 'loadAll';
$parameters['limit'] = '3';
$parameters['order'] = 'name';
$parameters['direction'] = 'desc';
$parameters['filters'] = [ ['state_id', '=', 1] ];
$url = $location . '?' . http_build_query($parameters);
var_dump( json_decode( file_get_contents($url) ) );


// delete all objects using pagination, and filter
$location = '{URL}/rest.php';
$parameters = array();
$parameters['class'] = '{ACTIVE_RECORD}Service';
$parameters['method'] = 'deleteAll';
$parameters['filters'] = [ ['id', '>', 5], ['state_id', '=', '1']];
$url = $location . '?' . http_build_query($parameters);
var_dump( json_decode( file_get_contents($url) ) );
