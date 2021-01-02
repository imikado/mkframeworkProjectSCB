<?php

/* -----------------------------------------------------------------------------------
  Auteur: Mika http://mkdevs.com
  Page: tout passe par la; c'est le moteur du site, il gere les appels aux modules/action...

  Description:
  C'est ici que vous pouvez installer ci-besoin un compteur de visite
  ----------------------------------------------------------------------------------- */

$iMicrotime = microtime(true);

//on parse le fichier ini pour trouver l'adresse de la librairie
$tIni = parse_ini_file('../conf/path.ini.php', true);
//enregistrement de l'auto loader du framework
include($tIni['path']['lib'] . '/class_root.php');

//enregistrement de l'autoloader
include($tIni['path']['plugin'] . '/sc/plugin_sc_autoload.php');
spl_autoload_register(array('plugin_sc_autoload', 'autoload'));

function tr($sTag_)
{
    return _root::getI18n()->tr($sTag_);
}

function trR($sTag_, $tReplace_)
{
    return _root::getI18n()->trR($sTag_, $tReplace_);
}

//pour gerer toutes les erreurs en exception
function exception_error_handler($errno, $errstr, $errfile, $errline)
{
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}

set_error_handler("exception_error_handler");

$oRoot = new _root();
$oRoot->setConfigVar('path', $tIni['path']);

$oRoot->addConf('../conf/mode.ini.php');
$oRoot->addConf('../conf/connexion.ini.php');
$oRoot->addConf('../conf/site.ini.php');
$oRoot->addRequest($_GET);
$oRoot->addRequest($_POST);
$oRoot->run();

if (_root::getConfigVar('site.mode') == 'dev') {
    $oDebug = new plugin_sc_debug($iMicrotime);
    echo $oDebug->display();
}