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

    public function fileSizeString($sizeBytes) {
        if ($sizeBytes < 1024) {
            return "$sizeBytes B";
        }
        else if ($sizeBytes < (1024 * 1024)) {
            $kb = number_format($sizeBytes / 1024, 2). " KB";
            return $kb;
        }
        else if ($sizeBytes < (1024 * 1024 * 1024)) {
            $mb = number_format($sizeBytes / 1024 / 1024, 2). " MB";   
            return $mb;
        }
        else {
            $gb = number_format($sizeBytes / 1024 / 1024 / 1024, 2). " GB";   
            return $gb;
        }
    }

    public function browse(Request $request) {
    	$folder = $request->input('folder');
    	if (is_null($folder)) {
    		$folder = "";
    	}
        $folder = trim($folder, "\\") . "\\";
    	$rootFolder = trim(Config::get('app.BROWSE_URL'), "\\") . "\\";
    	$folderToBrowse = $rootFolder . $folder;
    	$allFiles = scandir($folderToBrowse);
    	$result = array();
    	foreach ($allFiles as $key => $file) {
            $fullPath = $folderToBrowse . $file;
    		if ($file == "." || $file == "..")
    			continue;
    		$fileType = ApiController::TYPE_FILE;
    		if (is_dir($fullPath)) {
    			$fileType = ApiController::TYPE_FOLDER;
    		}
            $modifiedTime = filectime($fullPath);
            $fileSizeStr = $fileType == ApiController::TYPE_FILE ? $this->fileSizeString(filesize($fullPath)) : "--";
    		$thisEntity = array('name' => $file, 
                'type' => $fileType,
                'date' => date ("F d Y, h:i A.", $modifiedTime),
                'size' => $fileSizeStr);
    		array_push($result, $thisEntity);
    	}
    	//return response(json_encode($result))->->header('Content-Type', "application/J");
        return response()->json($result);
    }
}
