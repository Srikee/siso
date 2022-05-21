<?php
    define("VERSION", "1.0.2");

    if( $_SERVER["HTTP_HOST"]=="siso.com" ) {
        // HOSTING
        define("URL", "https://siso.com");
        define("ROOT", "/main/");
        
        // ฐานข้อมูล
        define("HOST", "localhost");
        define("USER", "");
        define("PASS", "");
        define("DBNAME", "");

        // Line OA
        // define("CHANNEL_ACCESS_TOKEN", "YT93RD+VtiT7/NNl4c7zETiUVw9w2kOBp/FW7ckqrldCR+IANzFHWoFn2GTN8452CtKORtrwaVlekounXNwdIonBgcOxQwlBnHAei2nwsJs5ctLv0pVfPvVeyh1BqNYsXn3v7FYXYKFTPX4HNRGfHAdB04t89/1O/w1cDnyilFU=");
        // define("LIFF_ID", "1654890226-nbw4zwBy");

        // FTP for upload file
        // define("FTP_SERVER", "");
        // define("FTP_USER", "");
        // define("FTP_PASS", "");
        // define("FTP_DIR", "/path/");
        
        // Dialog Flow ยังไม่ได้ใช้งาน
        // define("DIALOGFLOW_PROJECT_ID", "psuconnect-dnkdbv");
    } else {
        // HOSTING
        define("URL", "http://localhost");
        define("ROOT", "/siso/");

        // ฐานข้อมูล
        define("HOST", "localhost");
        define("USER", "root");
        define("PASS", "");
        define("DBNAME", "db_siso");

        // Line OA
        // define("CHANNEL_ACCESS_TOKEN", "");
        // define("LIFF_ID", "");

        // FTP for upload file
        // define("FTP_SERVER", "");
        // define("FTP_USER", "");
        // define("FTP_PASS", "");
        // define("FTP_DIR", "/path/");
        
        // Dialog Flow ยังไม่ได้ใช้งาน
        // define("DIALOGFLOW_PROJECT_ID", "psuconnect-dnkdbv");
    }
    
    $GLOBAL = array(
		"ALLOW_SIZE"=>10,  // 10MB
		"ALLOW_PDF"=>array("pdf"),
        "ALLOW_IMAGE"=>array("png", "jpg", "jpeg", "gif"),
        "ALLOW_PNG_JPG"=>array("png", "jpg"),
        "ALLOW_DOC"=>array("pdf", "doc", "docx", "jpg", "png", "xls", "xlsx"),
        "SHOW"=>50,
        "PAGE_SHOW"=>7,
    );
    