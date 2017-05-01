<?php
    // connect your database here first 
    // 

    // Actual code starts here 
	require_once("config.php");
	require_once("functions.php");

    $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = 'ombre_db' 
        AND ENGINE = 'MyISAM'";

    $rs = query($sql);
	confirm($rs);

    while($row = fetch_array($rs))
    {
        $tbl = $row[0];
        $sql = "ALTER TABLE `$tbl` ENGINE=INNODB";
        confirm(query($sql));
    }
?>