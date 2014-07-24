<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Administrator
 * Date: 4/11/2556
 * Time: 16:11 น.
 * To change this template use File | Settings | File Templates.
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        //check สถานะ login
        $this->Authentication_model->checkSignIn();
    }

    private $pathUpload = "";

    function index()
    {
        if ($_POST) {
            $folderID = @$_POST['folder_id'];
            $pathUpload = @$_POST['path_upload'];
            $fileType = @$_POST['file_type'];
            $strFolderName = $pathUpload . $folderID;
            $strFolderName = 'uploads/';
            //check path แล้วสร้าง folder
            $result = $this->createFolder($strFolderName);

            //ตั้งชื่อใหม่ date-time-fileType-fileName.xxx
//        $fileName = pathinfo($_FILES['userfile']['name']);
//            $file_param_name = 'imagefile';
            $file_param_name = 'file';
            $fileName = @$_FILES[$file_param_name]['name'];
            $fileName = str_replace(' ', '_', $fileName);
            $newName = date("Ymd") . "-" . date('His') . "-$fileType-" . $fileName;
            $_FILES[$file_param_name]['name'] = $newName;

            //กำหนดชนิดไฟล์
            //$allowedTypes = $fileType == "1" ? "doc|docx|xls|xlsx|pdf" : 'gif|jpg|png';
            $allowedTypes = "*";

//        if (!is_dir($strFolderName)) {
//            echo "Path fail";
//        } else {
            //$config['upload_path'] = $strFolderName;
            $config['allowed_types'] = $allowedTypes;
            $config['max_size'] = '2048';
            $config['max_width'] = '2048';
            $config['max_height'] = '2048';

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            /*if (!$this->upload->do_upload()) {
                $error = array('error' => $this->upload->display_errors());

                $this->load->view('upload_form', $error);
            } else {
                $data = array('upload_data' => $this->upload->data());

                $this->load->view('upload_success', $data);
            }*/
            if (!$this->upload->do_upload()) {
                echo $error = $this->upload->display_errors();
            } else {
                $data = $this->upload->data();
                //$result = move_uploaded_file($data['full_path'], $targetFile);
                //echo $data['file_name'];

                echo $newName;
                //update path file
                /*$this->load->model('Client_model');
                if ($fileType == "1"){
                    $result = $this->Client_model->updatePathFiles($folderID, $newName);
                    if (!$result) {
                        echo "update path files fail";
                    }
                }else {
                    $result = $this->Client_model->updatePathImage($folderID, $newName);
                    if (!$result) {
                        echo "update path image fail";
                    }
                }*/

//            }
            }
        }
    }

    function multi()
    {
        if ($_POST) {
            //    specify upload directory - storage
            //    for reconstructed uploaded files
            //session_start();

            //$DS = DIRECTORY_SEPARATOR;
            $tempUpload = 'uploads/tmp/';

            //
            //    specify stage directory - temporary storage
            //    for uploaded partitions
            $pathUpload = 'uploads/';
            //
            //    retrieve request parameters
            $file_param_name = 'file';
            $file_name = @$_FILES[$file_param_name]['name'];
            $file_id = $_POST['fileId'];
            $partition_index = $_POST['partitionIndex'];
            $partition_count = $_POST['partitionCount'];
            $file_length = $_POST['fileLength'];

            //
            //    the $client_id is an essential variable,
            //    this is used to generate uploaded partitions file prefix,
            //    because we can not rely on 'fileId' uniqueness in a
            //    concurrent environment - 2 different clients (applets)
            //    may submit duplicate fileId. thus, this is responsibility
            //    of a server to distribute unique clientId values
            //    (or other variable, for example this could be session id)
            //    for instantiated applets.
            $file_type = explode('.', $file_name);
            $file_type = $file_type[strlen($file_type) - 1];
            $file_name = str_replace(' ', '_', $file_name);
            $newName = date("Ymd") . "-" . date('His') . "-$file_type-" . $file_name;
            //$client_id = $_SESSION['userName'] . "." . $file_name;
            $client_id = $newName;
            $client_id = $this->Helper_model->utf8_to_tis620($client_id);

            //
            //    move uploaded partition to the staging folder
            //    using following name pattern:
            //    ${clientId}.${fileId}.${partitionIndex}
            $source_file_path = $_FILES[$file_param_name]['tmp_name'];
            $target_file_path = $pathUpload . $client_id . "." . $file_id .
                "." . $partition_index;
            if (!move_uploaded_file($source_file_path, $target_file_path)) {
                echo "Error:Can't move uploaded file";
                return;
            }
            /*

            //
            //    check if we have collected all partitions properly
            $all_in_place = true;
            $partitions_length = 0;
            for ($i = 0; $all_in_place && $i < $partition_count; $i++) {
                $partition_file = $pathUpload . $client_id . "." . $file_id . "." . $i;
                if (file_exists($partition_file)) {
                    $partitions_length += filesize($partition_file);
                } else {
                    $all_in_place = false;
                }
            }

            //
            //    issue error if last partition uploaded, but partitions validation failed
            if ($partition_index == $partition_count - 1 &&
                (!$all_in_place || $partitions_length != intval($file_length))
            ) {
                echo "Error:Upload validation error";
                return;
            }$all_in_place = false;

            //
            //    reconstruct original file if all ok
            if ($all_in_place) {

                //$file = $tempUpload . $client_id . "." . $file_id;
                //$file = $tempUpload . "importcsv.csv";
                $filePath = $tempUpload . $_POST['fileName'];

                if (file_exists($filePath)) {
                    //$file_ext = get_extension($_POST[ 'fileName' ]);
                    $duplicate_filename = TRUE;
                    $i = 0;
                    while ($duplicate_filename) {
                        $filename_data = explode(".", $_POST['fileName']);
                        $new_filename = $filename_data[0] . "_" . $i . "." . $filename_data[1];
                        $at = "$tempUpload" . $new_filename . "";
                        if (file_exists($at)) {
                            ;
                            $i++;
                        } else {
                            $duplicate_filename = FALSE;
                        }
                    }
                    $file = $at;
                } else {
                    $file = $tempUpload . $_POST['fileName'];
                }

                $file_handle = fopen($file, 'a');
                for ($i = 0; $all_in_place && $i < $partition_count; $i++) {
                    //
                    //    read partition file
                    $partition_file = $pathUpload . $client_id . "." . $file_id . "." . $i;
                    $partition_file_handle = fopen($partition_file, "rb");
                    $contents = fread($partition_file_handle, filesize($partition_file));
                    fclose($partition_file_handle);
                    //
                    //    write to reconstruct file
                    fwrite($file_handle, $contents);
                    //
                    //    remove partition file
                    unlink($partition_file);
                }
                fclose($file_handle);
                //  File is done the filename is $_POST[ 'fileName' ]
                unlink($file);
            }*/
        }
        $this->load->view('cms/upload/multi');
    }

    function fileManager()
    {
        $this->load->view('cms/upload/file_manager');
    }

    function deleteImage()
    {
        $post = $this->input->post();
        if ($post) {
            extract($post); //echo $path;exit;
            $result = $this->Upload_model->deleteFile($path);
            if ($result) {
                echo "delete success";
            } else {
                echo "delete fail";
            }
        }
        exit();
    }

    function run()
    {
        $post = $this->input->post();
        if ($post) {
            extract($post);
            $result = $this->Constant_model->runScript(@$script);
            echo "<pre>";
            var_dump($result);
            echo "</pre>";
        }
        $data = array(
            'script' => @$script
        );
        $this->load->view('cms/run_sql', $data);
    }
}
