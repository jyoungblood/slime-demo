<?php

  $GLOBALS['site_title'] = 'Tabula Rasa';
  $GLOBALS['site_code'] = 'TR';
  $GLOBALS['site_domain'] = 'example.com';

  $GLOBALS['locals'] = [
    'year' => date('Y'),
    'site_title' => $GLOBALS['site_title'],
    'site_code' => $GLOBALS['site_code'],
    'site_domain' => $GLOBALS['site_domain'],
    'auth' => @$GLOBALS['auth'],
    'user_id' => @$GLOBALS['user_id'],
    'is_admin' => @$GLOBALS['is_admin'],
  ];

  // $GLOBALS['settings']['database'] = [
  //   'host' => 'localhost',
  //   'name' => 'db_name',
  //   'user' => 'db_user',
  //   'password' => 'db_pw'
  // ];

  // $GLOBALS['settings']['mailgun'] = [
  //   'api_key' => 'key-123456789456123000',
  //   'domain' => 'notifications.example.com'
  // ];

  // $GLOBALS['settings']['templates'] = [
  //   'path' =>  'pages',
  //   'extension' => 'hbs'
  // ];

  // date_default_timezone_set('America/Chicago');

  // error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

?>