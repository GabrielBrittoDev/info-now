<?php

//$route->get('/post/', 'ErrorController@index');
//$route->get('/', 'HomeController@index');
$route->get('/user', 'UserController@create');
$route->post('/user', 'UserController@store');
$route->get('/home', 'HomeController@index');
