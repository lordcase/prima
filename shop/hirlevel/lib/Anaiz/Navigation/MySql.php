<?php

class Navigation_MySql extends Resource_MySql {

    protected $table = 'navigation';
    
    public function install() {
        $query = "CREATE TABLE `" . $this->getTableName() . "` ( "
                . "`id` bigint(20) unsigned NOT NULL auto_increment, "
                . "`resource_type` varchar(120) NOT NULL default '', "
                . "`label` varchar(120) NOT NULL default '', "
                . "`external_url` varchar(255) NOT NULL default '', "
                . "`controller` varchar(120) NOT NULL default '', "
                . "`action` varchar(120) NOT NULL default '', "
                . "`weight` int(8) NOT NULL default '0', "
                . "`group_id` bigint(20) unsigned NOT NULL default '0', "
                . "`deleted` tinyint(4) NOT NULL default '0', "
                . " PRIMARY KEY  (`id`) "
                . " ) TYPE=MyISAM ; ";
        
        return $this->getDbAdapter()->executeQuery($query);
    }
    
}

