<?php

// boot
// ----

// this is the boot module for BunnyWeb. must be called for every BW page first.

// Copyright 2007 anaiz
// http://www.anaiz.hu
// info@anaiz.hu
// all rights reserved


// if BW_APPLICATION is not defined, all BW modules should die.
//define('BW_APPLICATION', 'CBA Fitness');

//define('ONLINE_VASARLAS_SZUNETEL', 'online_vasarlas_szunetel');

global $database;
global $log;

// bwSettings : default settings
require_once('inc/bwSettings.php');

error_reporting(E_ERROR);


// bwPostget : $POST and $GET objects
require_once('inc/bwPostget.php');

// bwDatabase : $database object
require_once('inc/bwDatabase.php');

// this is still BETA:
// -----------------------------------------------------
require_once('inc/bwComponent.php');
require_once('inc/bwDataset.php');
require_once('inc/bwLog.php');
// -----------------------------------------------------

// bwSession : $session object
require_once('inc/bwSession.php');

// bwStatus: $status object
require_once('inc/bwStatus.php');

// bwMeta: $meta object
require_once('inc/bwMeta.php');

// bwStatLog: $statLog object
require_once('inc/bwStatLog.php');



?>