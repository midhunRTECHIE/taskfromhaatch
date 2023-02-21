<?php

class Calculate
{
    private $postData;

    public function __construct()
    {
        $this->postData = isset($_POST['data']) ? $_POST['data'] : null;
    }

    public function start()
    {
        
        if (empty($this->postData) ) {

            $response = ["status"=>1,"code"=> 400,"message"=>"Empty data not allowed"];
            echo json_encode($response);
            die();

        } else {

            $string = $this->postData;
            $result = null;
            //check is post data contains operational values
            if (preg_match('/[\/+*-]/', $string))
            {
                //split values for operation
                $arr = preg_split("/[\/+*-]/", $string);

                //validate data
                if (is_numeric($arr[0]) && is_numeric($arr[1]))
                {

                    preg_match("/^[0-9\s\+]{1,22}$/", $string) ? $result = $arr[0] + $arr[1] : null;
                
                    preg_match("/^[\/0-9\s]{1,22}$/", $string) ? $result = $arr[0] / $arr[1] : null;
                    
                    preg_match("/^[0-9\s\*]{1,22}$/", $string) ? $result = $arr[0] * $arr[1] : null;
    
                    preg_match("/^[0-9\s\-]{1,22}$/", $string) ? $result = $arr[0] - $arr[1] : null;
                
                    //throw exception else case
                } else {
                    throw new Exception();
                }
                //response strucure
                $response = [
                    "status"=>1,
                    "code"=> !empty($result) ? 200: 400,
                    "message"=> !empty($result) ? "Success": "Please use single operation at a time",
                    "data"=>$result
                ];
                echo json_encode($response);
                die();
            } else {
                throw new Exception();
            }

        }
    }
}

$register = new Calculate();
if (!empty($_POST))
{
    
    try {
        $register->start();
    }
    //catch exception
    catch(Exception $e) {
        $response = ["status"=>1,"code"=> 200,"data"=> 0];
        echo json_encode($response);
        die();
    }
}

?>