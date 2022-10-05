<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
   "NAME" => "Веб-сервис",
   "DESCRIPTION" => "Веб-сервис",
   "CACHE_PATH" => "Y",
   "PATH" => array(
      "ID" => "service",
      "CHILD" => array(
         "ID" => "webservice",
         "NAME" => "Веб-сервис"
      )
   ),
);
?>