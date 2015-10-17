<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\ApiController;

class apiTest extends TestCase
{
	protected $rootFolder;
	protected $rootContent;
	protected $sub1Content;
	protected $sub2Content;

	private function createTestFilesInFolder($folder) {
		$filesCreated = array();
		$folder = trim($folder, "\\") . "\\";
		for ($i=1;$i<=4;$i++) {
			$thisFile = $folder . "file_$i.test";
			if (!file_exists($thisFile)) {
				$file = fopen($thisFile, "w") or die("Unable to open file!");
				fclose($file);	
			}
			array_push($filesCreated, $thisFile);
		}
		return $filesCreated;
	}
	private function createTestFolderInFolder($folder) {
		$folderCreated = array();
		$folder = trim($folder, "\\") . "\\";
		for ($i=1;$i<=4;$i++) {
			$thisFolder = $folder . "folder_$i";
			if (!file_exists($thisFolder))
				mkdir($thisFolder);
			array_push($folderCreated, $thisFolder);
		}
		return $folderCreated;
	}
	private function aggregrateFolderContent($files, $folders) {
		$result = array();
		foreach ($files as $file) {
			$thisEntity = array('name' => basename($file), 'type' => ApiController::TYPE_FILE);
			array_push($result, $thisEntity);
		}
		foreach ($folders as $folder) {
			$thisEntity = array('name' => basename($folder), 'type' => ApiController::TYPE_FOLDER);
			array_push($result, $thisEntity);	
		}
		return $result;
	}
	private function isExistsInFilesList($fileList, $file) {
		foreach($fileList as $fileInList) {
			if ($file['name'] == $fileInList->name && $file['type'] == $fileInList->type) {
				return true;
			}
		}
		return false;
	}

	public function setUp() {
		parent::setUp();
		$this->rootFolder = trim(Config::get('app.BROWSE_URL'), "\\") . "\\";
		$rootFiles = $this->createTestFilesInFolder($this->rootFolder);
		$folders = $this->createTestFolderInFolder($this->rootFolder);
		$this->rootContent = $this->aggregrateFolderContent($rootFiles, $folders);
		//var_dump($this->rootContent);
		

		$subFolders = $this->createTestFolderInFolder($folders[0]);
		$subFiles = $this->createTestFilesInFolder($folders[0]);
		$this->sub1Content = $this->aggregrateFolderContent($subFiles, $subFolders);
		$subsubFiles = $this->createTestFilesInFolder($subFolders[0]);
		$this->sub2Content = $this->aggregrateFolderContent($subsubFiles, array());
		
	}
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_api_should_return_atleast_all_created_file_in_root_folder()
    {
    	$response = $this->call('GET', '/browse')->getContent();
    	$responseObject = json_decode($response);
    	foreach ($this->rootContent as $key => $value) {
    		$this->assertTrue($this->isExistsInFilesList($responseObject, $value));
    	}
    }
    public function test_api_should_return_atleast_all_created_file_in_folder_1()
    {
    	$response = $this->call('GET', '/browse', array('folder' => 'folder_1'))->getContent();
    	$responseObject = json_decode($response);
    	//var_dump($this->sub1Content);
    	foreach ($this->sub1Content as $key => $value) {
    		$this->assertTrue($this->isExistsInFilesList($responseObject, $value));
    	}
    }
    public function test_api_should_return_atleast_all_created_file_in_folder_1_folder_1()
    {
    	$response = $this->call('GET', '/browse', array('folder' => 'folder_1\\folder_1'))->getContent();
    	$responseObject = json_decode($response);
    	foreach ($this->sub2Content as $key => $value) {
    		$this->assertTrue($this->isExistsInFilesList($responseObject, $value));
    	}
    }
}
