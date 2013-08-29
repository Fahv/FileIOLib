

<?php
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
