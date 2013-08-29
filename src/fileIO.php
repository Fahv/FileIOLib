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
	private $requestName;
	private $handle;
	private	$fileSize;
	private $content;
	private $url;
	
	
	/**
	 * Opens the file with what ever mode is given.
	 * 
	 * $requestName is the request starting with the folder location. Ie "/FileIOLib/test.txt"
	 * $mode the mode that we want the file to be opened.
	 * $url if this is for a url or file
	 * 
	 * @return nothing if everything works
	 * @return echos error and dies
	 * 
	 */
	public function init($requestName,$mode,$url){
		$this->requestName = $requestName;
		$this->url = $url;
		$this->handle = fopen($this->requestName,$mode);
		if($this->handle == false){
			echo "error opening request";
			die;
		}
		if($this->url == false){
			$this->clearCache();
			$this->fileSize = filesize($this->requestName);
			
			if($this->fileSize != 0){
				$this->content = fread($this->handle,$this->fileSize);
			}
		} else{
			$this->content = stream_get_contents($this->handle);	
		}
	}
	
	/**
	 * 
	 * Reads the whole contents of the file into $fileContent
	 * 
	 * @return echos on error
	 */
	public function read(){
		rewind($this->handle);
		if($this->handle){
			$this->content = fread($this->handle,$this->fileSize);
			if($this->content == false)
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
		if($this->handle){
			$written = fwrite($this->handle,$content);
			$this->clearCache();
			$this->fileSize = filesize($this->requestName);
			return $written;
		}
	}
	
	/**
	 * Closes the file handle
	 */
	public function close(){
		fclose($this->handle);
	}
	
	/**
	 * Returns $fileContent
	 */
	public function getContent(){
		return $this->content;
	}
	/**
	 * Returns $fileSize
	 */
	public function getFileSize(){
		return $this->fileSize;
	}
	/**
	 * Returns the position of the file pointer
	 */
	 public function getPointer(){
		 ftell($this->handle);
	 }
	 /**
	 * Sets the position of the file pointer
	 * Returns 0 upon success -1 otherwise
	 */
	 public function setPointer($offset){
		 fseek($this->handle,$offset);
	 }
	
	
	private function clearCache(){
		clearstatcache();
	}
	
}
?>
