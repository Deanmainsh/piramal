<?php
require_once('./vendor/autoload.php');
define('SHREAD_SHEET_ID', '1VmqnJxZR-HPbYIKLBeNxnFrdg06qi1xTQ9xvtvfnku4');
define('SPREAD_SHEET_CREDENTIALS_FILE', './piramal-413405-a2d8d33bd415.json'); 
  //PATH TO JSON FILE DOWNLOADED FROM GOOGLE CONSOLE
  $json=array();
if (isset($_POST['phone']) && !empty($_POST['phone'])) {

    $name = (!empty($_POST['name']))?$_POST['name']:'';
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $meta='';
    insertData('Sheet1', [$name, $email, $phone,$meta, date("F j, Y, g:i a", time())]);
    $json['status']=true;
    $json['data']['name']= $name;
    $json['data']['email']= $email;
    $json['data']['phone']= $phone;
    $json['message']='Data Updated Successfully';

}else{
    $json['status']=false;
    $json['message']='Something Wrong';
    $json['phone']='Phone Number can`t be empty';
}
echo json_encode($json);
die;


function getClient()
{
  $client = new Google_Client();
  $client->setApplicationName('Piramal');
  $client->setScopes(Google_Service_Sheets::SPREADSHEETS);
  $client->setAuthConfig(SPREAD_SHEET_CREDENTIALS_FILE);
  $client->setAccessType('offline');
  
  return $client;
}

function insertData($range = 'Sheet1', array $data = [])
{
  // Get the API client and construct the service object.
  
    $client = getClient();
  
  $service = new Google_Service_Sheets($client);
  $valueRange = new Google_Service_Sheets_ValueRange();
   $valueRange->setValues(
    [
      'values' => $data
    ]
  );
  $conf = ["valueInputOption" => "RAW"];
  $response = $service->spreadsheets_values->append(SHREAD_SHEET_ID, $range, $valueRange, $conf);
  return $response;
}