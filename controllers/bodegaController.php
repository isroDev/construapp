<?php
header("Content-Type: text/html; charset=utf-8");
include("db_connection.php");
require 'vendor/autoload.php';
session_start();
mysqli_set_charset($db_conn, 'utf8');
if (isset($_POST["action"]) && $_POST["action"] == "generate_barcode") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $itm_code = $_POST["itmcode"];
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        $code2 = '';
        foreach (str_split($itm_code) as $key => $c) {
            $code2 .= $c;
            if (count(str_split($itm_code)) != $key)
                $code2 .= ' ';
        }

        $barcode = "data:image/png;base64,".base64_encode($generator->getBarcode($itm_code, "C128"));
        $response["barcode"]    =   $barcode;
        $response["code"]       =   $code2;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_units") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $response["login"]  =   true;
        $sql            =   "SELECT U.UNIT_ID UNIT_ID, initcap(U.UNIT_DESC)  DESCRIPTION  FROM MAT_UNITS U";
        $result         =   mysqli_query($db_conn,  $sql);
        while ($row      =   mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if ($row) {
                $list[]    =   $row;
            }
        }
        $response["units_list"]         =       $list;
        $sql                            =       "SELECT COALESCE((MAX(MAT_ID)), 1000) + 1 AS MATERIAL_ID FROM MATERIALS";
        $result                         =       mysqli_query($db_conn,  $sql);
        $row                            =       mysqli_fetch_array($result, MYSQLI_ASSOC);
        $response["MATERIAL_ID"]        =       $row["MATERIAL_ID"];
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_main") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $response["login"]  =   true;
        $sql            =   "SELECT M.ID MAIN_ID, initcap(M.DESCRIPTION) DESCRIP FROM MAT_MAIN M ";
        $result         =   mysqli_query($db_conn,  $sql);
        $list;
        while ($row      =   mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $list[]     =       $row;
        }
    }
    $response["list"] = $list;
    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "register-material") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {

        $sql            =   "INSERT INTO MATERIALS(MAT_ID, MAT_NAME, UNIT_ID, ITMCODE, MAIN_ID, OPENING_STK) VALUES(" . $_POST["material_ID"] . ", '" . $_POST["material_name"] . "', " . $_POST["unit_ID"] . ", '" . $_POST["itmcode"] . "', " . $_POST["main_ID"] . ", ".$_POST["opn_stk"].")";
        $result         =   mysqli_query($db_conn,  $sql);
        if ($result) {
            $response["status"] = true;
        } else {
            $response["status"] = false;
        }
    }
    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_materials") {

    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {

        $sql            =   "SELECT M.ITMCODE ITMCODE, initcap(C.DESCRIPTION) CATEGORY,  initcap(MAT_NAME) MATERIAL_NAME, U.UNIT_DESC UNIT, M.OPENING_STK OPN_STK FROM MATERIALS M, MAT_MAIN C, MAT_UNITS U WHERE M.MAIN_ID = C.ID AND M.UNIT_ID = U.UNIT_ID";
        $result         =   mysqli_query($db_conn,  $sql);
        $materials_list;
        while ($row      =   mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $materials_list[]     =   $row;
        }
        $response["materials_list"]  = $materials_list;
    }
    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "get_users") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $sql            =   "SELECT USER_ID ID, initcap(NAME) USER_NAME FROM USERS WHERE ROLE_ID IN (10, 11, 14, 4)";
        $result         =   mysqli_query($db_conn,  $sql);
        $users;
        while ($row      =   mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $users[]     =       $row;
        }
    }
    $response["users"] = $users;
    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_unattached_modules") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $user_ID        =   $_POST["user_ID"];
        $sql            =   "SELECT ID AS MODULE_ID, initcap(NAME) MODULE_NAME FROM MODULES WHERE ID NOT IN (SELECT MODULE_ID FROM USER_MODULES WHERE USER_ID = " . $user_ID . ")";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);

        if ($count > 0) {
            $modules;
            while ($row      =   mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $modules[]     =       $row;
            }
            $response["modules"]                =   $modules;
        }
        $sql_query              =   "SELECT UM.ID ID, U.USER_ID USER_ID,U.NAME NAME, UM.MODULE_ID MODULE_ID, M.NAME MODULE_NAME, DATE_FORMAT(UM.ENT_DATE, '%d-%m-%Y %H:%i:%s') ENT_DATE, CASE WHEN UM.ACTIVE_STATUS = 'A' THEN 'Activa' ELSE 'Inactivo' END AS STATUS FROM USER_MODULES UM, MODULES M, USERS U WHERE UM.MODULE_ID = M.ID AND UM.USER_ID = U.USER_ID AND UM.USER_ID = " . $user_ID;
        $stmt                   =   mysqli_query($db_conn,  $sql_query);
        $modules_count          =   mysqli_num_rows($stmt);
        if ($modules_count > 0) {
            $user_modules;
            while ($r      =   mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                $user_modules[]     =       $r;
            }
            $response["user_modules"]           =   $user_modules;
        }
    }



    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "attach_module_user") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $user_ID        =   $_POST["user_ID"];
        $module_ID      =   $_POST["module_ID"];
        $sql            =   "INSERT INTO USER_MODULES(USER_ID, MODULE_ID, ACTIVE_STATUS, ENT_DATE) VALUES(" . $user_ID . ", " . $module_ID . ",'A', CURRENT_TIMESTAMP)";
        $result         =   mysqli_query($db_conn,  $sql);
        if ($result) {
            $response["status"]     =   true;
        }
        if (!$result) {
            $response["status"]     =   false;
        }
    }
    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_constructions") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {

        $sql            =   "SELECT C.CONSTRUCTION_ID ID, initcap(C.CONST_NAME) CONSTRUCTION_NAME FROM CONSTRUCTION C";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        if ($count > 0) {
            $list;
            while ($row      =   mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $list[]      =   $row;
            }
        }
        $response["constructions"]         =       $list;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "deactivate_module") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {

        $sql            =   "UPDATE USER_MODULES SET ACTIVE_STATUS = 'N' WHERE ID =".$_POST["Id"];
        $result         =   mysqli_query($db_conn,  $sql);
        if ($result) 
        {
            $response["status"] = true;
             
        }
        if (!$result) 
        {
            $response["status"] = false;
             
        }
    }

    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "delete_usermodule") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {

        $sql            =   "DELETE FROM USER_MODULES  WHERE ID =".$_POST["Id"];
        $result         =   mysqli_query($db_conn,  $sql);
        if ($result) 
        {
            $response["status"] = true;
             
        }
        if (!$result) 
        {
            $response["status"] = false;
             
        }
    }

    echo (json_encode($response));
}
