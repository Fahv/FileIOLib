<?php
/**
* A short and simple library to handle file io.
*
*
* The MIT License (MIT)
*
* Copyright (c) 2013 Fahv
*
* Permission is hereby granted, free of charge, to any person obtaining a copy of
* this software and associated documentation files (the "Software"), to deal in
* the Software without restriction, including without limitation the rights to
* use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
* the Software, and to permit persons to whom the Software is furnished to do so,
* subject to the following conditions:
* 
* The above copyright notice and this permission notice shall be included in all
* copies or substantial portions of the Software.
* 
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
* FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
* COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
* IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
* CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/


/**
* Class for the different file open modes.
*/

final class MODE{
	const Read = "r";
	const ReadPlus = "r+";
	const WriteBegin = "w";
	const WriteBeginPlus = "w+";
	const WriteEnd = "a";
	const WriteEndPlus ="a+";
	
	private function __construct() {
		
	}
}

/**
* Provides a simple IO interface, using an oop approach.
*
*/

class FileIO{
	private $fileName;
	private $file;
	private	$fileSize;
	private $fileContent;
	
	
	/**
	 * Opens the file with what ever mode is given.
	 * 
	 * $fileName is the filename starting with the folder location. Ie "/FileIOLib/test.txt"
	 * $mode the mode that we want the file to be opened.
	 * 
	 * @return nothing if everything works
	 * @return echos error and dies
	 * 
	 */
	public function init($fileName,$mode){
		$this->fileName = $_SERVER['DOCUMENT_ROOT'].$fileName;
		
		$this->file = fopen($this->fileName,$mode);
		if($this->file == false){
			echo "error opening file";
			die;
		}
		$this->clearCache();
		$this->fileSize = filesize($this->fileName);
		
		$this->fileContent = fread($this->file,$this->fileSize);
	}
	
	/**
	 * 
	 * Reads the whole contents of the file into $fileContent
	 * 
	 * @return echos on error
	 */
	public function read(){
		rewind($this->file);
		if($this->file){
			$this->fileContent = fread($this->file,$this->fileSize);
			if($this->fileContent == false)
			{
				echo "Error Reading File";
			}
		} else{
			echo "Error Reading File";
		}		
	}
	
	/**
	 * 
	 * Writes to the file
	 * 
	 * $content is the content that is to be written
	 * 
	 * @return the number of bytes written
	 */
	public function write($content){
		if($this->file){
			$written = fwrite($this->file,$content);
			$this->clearCache();
			$this->fileSize = filesize($this->fileName);
			return $written;
		}
	}
	
	/**
	 * Closes the file handle
	 */
	public function close(){
		fclose($this->file);
	}
	
	/**
	 * Returns $fileContent
	 */
	public function getContent(){
		return $this->fileContent;
	}
	/**
	 * Returns $fileSize
	 */
	public function getFileSize(){
		return $this->fileSize;
	}
	
	private function clearCache(){
		clearstatcache();
	}
	
}
?>
