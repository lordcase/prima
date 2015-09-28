<?
    mssql_connect('81.183.210.139:1434', 'webuser', 'honlapszerk');
    mssql_select_db('wellness');

    $res=mssql_query('execute WSP_ORAK_LEKERDEZESE \'2012-01-13\'');
                                                                    
    while($line=mssql_fetch_assoc($res))                            
        print_r($line);


//    $res = mssql_query('SELECT ID, NEV, CIM, VAROS, TELEFON1, EMAIL FROM dbo.UGYFELEK WHERE (EMAIL = \'fuzik.zsolt@cba.hu\')');
//    var_dump(mssql_fetch_assoc($res));

//    $res = mssql_query('EXECUTE WSP_FELHASZNALO_ORAI \'20429\', \'Fuzik Zsolt\'');
//    var_dump(mssql_fetch_assoc($res));

?>
