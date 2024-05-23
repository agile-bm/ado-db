<?php

include_once('adodb-connection-manager.inc.php');
include_once('adodb.inc.php');
include_once('adodb-active-record.inc.php');

$host = "localhost";
$port = "3306";
$user = "root";
$password = "";
$db = "db_modulus_wh_test";        

ADODB_Connection_Manager::Init(2, 2, '', '');
ADODB_Connection_Manager::AddConnection(
    'customer',
    'mysqli',
    $host,
    $port, 
    $user, 
    $password,
    $db,
    1
);

$conn = &ADODB_Connection_Manager::GetConnection('customer');

class ClsDalUser extends ADODB_Active_Record{
    var $_dbat = 'customer'; var $_table = 'cmn_user';
}


// // Insert one
//pkUserID
//fldUserName
//fldDisplayName
//fldEmail
//fkPhotoID
//fldDisable
// $objDalUser = new ClsDalUser();
// $objDalUser->fldUserName = "test.adodb.2";
// $objDalUser->fldPassword = "81dc9bdb52d04dc20036dbd8313ed055";
// $objDalUser->fldDisplayName = "Test Adodb";
// $objDalUser->fldEmail = "user@mail.com";
// $objDalUser->fkPhotoID = null;
// $objDalUser->fldDisabled = 0;
// $rslt = $objDalUser->Save();
// var_dump($rslt);

// // Insert Bulk with bulk query
// $strSQL = "INSERT INTO cmn_user VALUES (NULL, 'test.adodb.3', 'Test Adodb 3', 'user@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 0, NULL), (NULL, 'test.adodb.4', 'Test Adodb 4', 'user@mail.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL, 0, NULL) ";
// if ($conn) {
//     $rslt = $conn->Execute($strSQL);
//     var_dump($rslt);
// }


// // Load one 
// $objDalUser = new ClsDalUser(); 
// $rslt = $objDalUser->Load('pkUserID = ?', [5]);
// if ($rslt) {
//     print("Loaded Successfully");
//     var_dump($objDalUser);
// } else {
//     print("Failed to load");
// }


// // Load Set with find
// $objDalUser = new ClsDalUser(); 
// $arrData = $objDalUser->Find('fldDisplayName LIKE ? ', ['%ahmed%']);
// print("Existing data");
// var_dump($arrData);

// // Load set with connection Function GetArray, GetAssoc, GetOne, GetCol
// if ($conn) {
//     $arrResult = $conn->GetArray('SELECT * FROM cmn_user WHERE fldDisplayName LIKE ?', ['%ahmed%']);
//     print("Array values \n");
//     var_dump($arrResult);
//     $arrResult = $conn->GetAssoc('SELECT * FROM cmn_user WHERE fldDisplayName LIKE ?', ['%ahmed%']);
//     print("Assoc values \n");
//     var_dump($arrResult);
//     $arrResult = $conn->GetOne('SELECT pkUserID FROM cmn_user WHERE fldDisplayName LIKE ?', ['%ahmed%']);
//     print("One values \n");
//     var_dump($arrResult);
//     $arrResult = $conn->GetCol('SELECT pkUserID FROM cmn_user WHERE fldDisplayName LIKE ?', ['%ahmed%']);
//     print("Col values \n");
//     var_dump($arrResult);
// }

// // Transaction
if ($conn) {
    $conn->StartTrans();
    $objDalUser = new ClsDalUser();
    $objDalUser->fldUserName = "test.adodb.5";
    $objDalUser->fldPassword = "81dc9bdb52d04dc20036dbd8313ed055";
    $objDalUser->fldDisplayName = "Test Adodb 5";
    $objDalUser->fldEmail = "user@mail.com";
    $objDalUser->fkPhotoID = null;
    $objDalUser->fldDisabled = 0;
    $rslt = $objDalUser->Save();
    if (!$rslt) {
        $conn->CompleteTrans(false);
        print("Failed to save user \n");
        die();
    }
    $intUserID = $objDalUser->pkUserID;
    $strSQL = "INSERT INTO cmn_user_user_level VALUES ($intUserID, 66), ($intUserID, 70)";
    $rslt = $conn->Execute($strSQL);
    if (!$rslt) {
        $conn->CompleteTrans(false);
        print("Failed to add user level to user \n");
        die();
    }
    $conn->CompleteTrans(true);

}