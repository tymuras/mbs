<?php
$config = array (
  'debug' => 0,
  'App' => 
  array (
    'base' => false,
    'baseUrl' => false,
    'dir' => 'app',
    'webroot' => 'webroot',
    'www_root' => 'M:\\xampp\\htdocs\\mbs\\app\\webroot\\',
    'encoding' => 'UTF-8',
  ),
  'Error' => 
  array (
    'handler' => 'ErrorHandler::handleError',
    'level' => 24575,
    'trace' => true,
  ),
  'Exception' => 
  array (
    'handler' => 'ErrorHandler::handleException',
    'renderer' => 'ExceptionRenderer',
    'log' => true,
  ),
  'Session' => 
  array (
    'defaults' => 'php',
  ),
  'Security' => 
  array (
    'salt' => 'DYhG93b0qyJfIsdsdxfs2guVoUubWwvniR2G0FgaC9mi',
    'cipherSeed' => '56565656',
  ),
  'Acl' => 
  array (
    'classname' => 'DbAcl',
    'database' => 'default',
  ),
  'Dispatcher' => 
  array (
    'filters' => 
    array (
      0 => 'AssetDispatcher',
      1 => 'CacheDispatcher',
    ),
  ),
);