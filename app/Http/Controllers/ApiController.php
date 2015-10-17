<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Config;

class ApiController extends Controller
{
	const TYPE_FILE = 0;
	const TYPE_FOLDER = 1;

    public function browse(Request $request) {
    	$folder = $request->input('folder');
    	if (is_null($folder)) {
    		$folder = "";
    	}
    	$rootFolder = trim(Config::get('app.BROWSE_URL'), "\\") . "\\";
    	$folderToBrowse = $rootFolder . $folder;
    	$allFiles = scandir($folderToBrowse);
    	$result = array();
    	foreach ($allFiles as $key => $file) {
    		if ($file == "." || $file == "..")
    			continue;
    		$fileType = ApiController::TYPE_FILE;
    		if (is_dir($rootFolder . $file)) {
    			$fileType = ApiController::TYPE_FOLDER;
    		}
    		$thisEntity = array('name' => $file, 'type' => $fileType);
    		array_push($result, $thisEntity);
    	}
    	//return response(json_encode($result))->->header('Content-Type', "application/J");
        return response()->json($result);
    }
}
