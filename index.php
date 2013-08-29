<?php
require_once("src/fileIO.php");

$file = new FileIO();
$file->init($_SERVER['DOCUMENT_ROOT']."/FileIOLib/test.txt",MODE::WriteBeginPlus);
echo "Information After Init<br /> Contents of file (should be empty):".$file->getContent()."<br />Filesize: ".$file->getFileSize()."<br />";
echo "Number of Bytes written to file: ".$file->write("This is a test")."<br />";
echo "After Write File Size: ".$file->getFileSize()."<br />";
$file->read();
echo "Read: ".$file->getContent()."<br />";
$file->close();
echo "File Closed: <br />";
?>
