<?php
    header("Content-Type:application/json");
    function sendMessage($message = null, $success = 0){
        echo json_encode([
                "message"=>$message,
                'success'=>$success
        ]);
        exit;
    }

    function isEmpty($valiables = []){
        if(empty($valiables)){
            sendMessage("Null function", false);
        }else{
            if (!is_array($valiables)) {
                if (empty($valiables)) {
                    sendMessage("$valiables must not be null");
                }
            } else {
                foreach ($valiables as $v){
                    if(empty($v)){
                        sendMessage("$v must not be null");
                    }
                } 
            }
            
        }
    }

    function add_delete_file($path = null, $action = null){
        isEmpty([ $path , $action ]);
        $directory = dirname($path);
        switch($action){
            case 'delete':
                unlink($path)?sendMessage('Your file has been deleted',true):sendMessage('We can not delete this file',false);
                break;
            case 'add':
                
                if(!is_dir($directory)){
                    mkdir($directory,0777,true);
                }
                
                if(!file_exists($path)){
                    file_put_contents($path,'');
                    sendMessage("Your file has been created: $path \n", true);
                }else{
                    sendMessage("File already exists: $path \n", false);
                }    




                break;
            default:
               sendMessage("Create any action");
               break;
        }
    }
    $message = '';$success = '';
    if(isset($_POST['request'])){
        $request = $_POST['request']??'';
        if(preg_match("/^(create file )(.+){3,}$/",$request) ){
            $path = str_replace("create file ", '', $request);
            add_delete_file("../../".$path, 'add');
        }
        elseif(preg_match("/^(delete file )(.+){3,}$/",$request) ){
            $path = str_replace("delete file ", '', $request);
            add_delete_file("../../".$path, 'delete');
        }else{
            sendMessage("Request Something", false);
        }
    }else{
        sendMessage("Bad Request", false);
    }
?>