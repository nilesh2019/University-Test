<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        class Example extends CI_Controller{

        public function __construct()
        {
                parent::__construct();      
                $this->load->model('aws_model');
        }

        public function index()
        {
                $result=$this->aws_model->listBuckets();
                if(!empty($result))
                {
                        foreach ($result['Buckets'] as $bucket) 
                        {
                                echo "{$bucket['Name']} - {$bucket['CreationDate']}\n";
                        }
                }
        }

        public function putObject()
        {
                echo $this->aws_model->putObject('as.png', $_SERVER['DOCUMENT_ROOT'].'uploads/as.png');
        }

        public function file_exists()
        {
                $response=$this->aws_model->file_exists('as.png');
                var_dump($response);die;
        }            

        public function filesize()
        {
                $response=$this->aws_model->filesize('as.png');
                var_dump($response);die;
        }                

        public function unlink()
        {
                $response=$this->aws_model->unlink('as.png');
                var_dump($response);die;
        }        


}
