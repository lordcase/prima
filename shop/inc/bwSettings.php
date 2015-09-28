<?php

define('BW_APPLICATION', "Príma Wellness");

define('BW_DEBUG', false);
define('BW_DEBUG_SQLDUMP', BW_DEBUG);

define('BW_DEFAULT_LANGUAGE', 'hu');


//
// settings for bwDatabase
//

define('_DATABASE_ERROR', 'Mûvelet sikertelen. Adatbázis elérési hiba lépett fel. Ha ez a hiba fennáll, vegye fel a kapcsolatot a rendszeradminisztrátorral.');

// Elsõre jó ötletnek tûnt.
//define('BW_DB_SERVER', '62.112.193.230');
define('BW_DB_SERVER', 'localhost');

//define('BW_DB_USER', 'anaiz');
//define('BW_DB_PASSWORD', '');
//define('BW_DB_DATABASE', 'anaiz');

//define('BW_DB_USER', 'cbafitness');
//define('BW_DB_PASSWORD', 'sHU73cbX');
//define('BW_DB_DATABASE', 'cbafitness');

define('BW_DB_USER', 'cbafitnesssql');
define('BW_DB_PASSWORD', 'ieD4hioz');
define('BW_DB_DATABASE', 'cbafitnessdb');


define('TBL_USER', 'cba_user');
define('TBL_VISIT', 'cba_visit');
define('TBL_LOG', 'cba_log');

define('TBL_GUESTBOOK', 'cba_guestbook');
define('TBL_GUESTBOOK_EVENT', 'cba_guestbook_event');

define('TBL_INSTRUCTOR', 'cba_instructor');
define('TBL_CLASSTYPE', 'cba_classtype');
define('TBL_CLASS', 'cba_class');
define('TBL_STATUS', 'cba_status');
define('TBL_ARTICLE', 'cba_article');

//
// settings for bwSession
//

define('BW_SESSION_USERID', 'bwUserID');


define('BW_CLIENT', 'Príma Wellness');
define('BW_WEBPAGE', 'http://shop.primawellness.hu');
define('BW_EMAIL', 'cbafitness@cbafitness.hu');



?>
