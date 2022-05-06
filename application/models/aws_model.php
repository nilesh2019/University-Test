<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');
class Aws_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('aws_sdk');
		$this->aws_sdk->registerStreamWrapper();
	}

	public function listBuckets()
	{
		$result = $this->aws_sdk->listBuckets();
		return $result;
	}

	public function putObject($fileName, $sourceFile)
	{
		try 
		{
			return $this->aws_sdk->putObject(array(
			'Bucket'=>file_upload_s3_bucket_name(),
			'Key' =>  $fileName, 
			'SourceFile' =>	$sourceFile,
			'StorageClass' => 'REDUCED_REDUNDANCY'
			));
		}
		catch(S3Exception $e) 
		{
    			return $e->getMessage() . "\n";
		}
	}

	public function file_exists($sourceFile)
	{
		try 
		{
			if (file_exists(file_upload_s3_path().$sourceFile)) {
			    	return true;
			}
			else
			{
				return false;
			}
		}
		catch(S3Exception $e) 
		{
    			$response = $e->getMessage() . "\n";
		}

		return $response;
	}

	public function getObjectInfo($sourceFile)
	{
		try 
		{
			$info =filesize(file_upload_s3_path().$sourceFile);
		}
		catch(S3Exception $e) 
		{
    			$info = $e->getMessage() . "\n";
		}

		return $info;
	}	

	public function filesize($sourceFile)
	{
		try 
		{
			$data = filesize(file_upload_s3_path().$sourceFile);
		}
		catch(S3Exception $e) 
		{
    			$data = $e->getMessage() . "\n";
		}

		return $data;
	}	

	public function unlink($sourceFile)
	{
		try 
		{
			$data =	unlink(file_upload_s3_path().$sourceFile);
		}
		catch(S3Exception $e) 
		{
    			$data = $e->getMessage() . "\n";
		}

		return $data;
	}

}