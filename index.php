<?php
require_once("src/fileIO.php");

echo "<h3>File Test</h3>";
$file = new FileIO();
$file->init($_SERVER['DOCUMENT_ROOT']."/FileIOLib/test.txt",MODE::WriteBeginPlus,false);
echo "Information After Init<br /> Contents of file (should be empty):".$file->getContent()."<br />Filesize: ".$file->getFileSize()."<br />";
echo "Number of Bytes written to file: ".$file->write("This is a test")."<br />";
echo "After Write File Size: ".$file->getFileSize()."<br />";
$file->read();
echo "Read: ".$file->getContent()."<br />";
$file->close();
echo "File Closed: <br />";

$url_location = "http://api.eve-marketdata.com/api/item_prices2.txt?char_name=demo&type_ids=34,12068&region_ids=10000002&buysell=s";
echo "<h3>URL Test</h3>";
$url = new FileIO();
$url->init($url_location,MODE::Read,true);
echo "Information After Init<br /> Contents of url:<br />".$url->getContent()."<br />";
$url->close();
?>
