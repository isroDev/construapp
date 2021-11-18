<?php

session_start();
include("db_connection.php");
include("functions.php");


if (isset($_POST["action"]) && $_POST["action"] == "get_user") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $sql            =   "SELECT * FROM USERS WHERE  USER_ID = '" . $_SESSION["USER_ID"] . "'";
        $result         =   mysqli_query($db_conn,  $sql);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $sql            =   "SELECT UPPER(ROLE_DESCRIPTION) AS ROLE_DESC FROM USER_ROLES WHERE  ROLE_ID = " . $row["ROLE_ID"];
        $result         =   mysqli_query($db_conn,  $sql);
        $role           =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count          =   mysqli_num_rows($result);
        $row["USER_ROLE"]       =   $role["ROLE_DESC"];
        if ($count == 1) {
            $response["login"]       =   true;
            $response["user"]        =   $row;
        } else {
            $response["login"]       =   false;
        }
    } else {
        $response["login"]       =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_supplier_data") {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $sql            =   "SELECT initcap(NAME) NAME FROM USERS WHERE  USER_ID = '" . $_POST["supplier_ID"] . "'";
        $result         =   mysqli_query($db_conn,  $sql);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $count          =   mysqli_num_rows($result);

        if ($count == 1) {
            $response["login"]       =   true;
            $response["user"]        =   $row;
        } else {
            $response["login"]       =   false;
        }
    } else {
        $response["login"]       =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "check_login") {
    $response;
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $response["login"]       =   true;
    } else {
        $response["login"]           =  false;
    }




    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "check_password") {

    $response;
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        if (isset($_POST["password"]) && $_POST["password"] != "") {
            $entered_password = $_POST["password"];
            if ($entered_password == $_SESSION["user"]["USER_PASSWORD"]) {
                $response["status"]  = true;
            } else {
                $response["status"]  = false;
            }
        }
        $response["login"]       =   true;
    } else {
        $response["login"]           =  false;
    }




    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "login") {
    $email          =   mysqli_real_escape_string($db_conn, $_POST["email"]);
    $pass           =   mysqli_real_escape_string($db_conn, $_POST["password"]);

    $sql            =   "SELECT * FROM USERS WHERE UPPER(EMAIL) = UPPER('" . $email . "') AND USER_PASSWORD = '" . $pass . "'";
    $result         =   mysqli_query($db_conn,  $sql);
    $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count          =   mysqli_num_rows($result);

    if ($count == 1) {
        $response["login"]       =   true;
        $response["user_role"]   =  $row["ROLE_ID"];
        $_SESSION["user"]        =  $row;
        $_SESSION["USER_ID"]     =  $row["USER_ID"];
        $_SESSION["EMAIL"]       =  $row["EMAIL"];
    } else {
        $response["login"]       =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_constructions") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT C.CONSTRUCTION_ID  CONSTRUCTION_ID, C.CONST_NAME  C_NAME FROM construction C";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_construction;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["CONS_ID"]      =   $row["CONSTRUCTION_ID"];
            $c["NAME"]         =   ucwords(strtolower($row["C_NAME"]));
            $lov_construction[] =   $c;
        }
        $response["lov_const"]          =   $lov_construction;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_rut") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT U.USER_ID ID, U.RUT RUT  FROM USERS U WHERE U.ROLE_ID  = 14";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_ruts;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["ID"]      =   $row["ID"];
            $c["RUT"]     =   $row["RUT"];
            $lov_ruts[] =   $c;
        }
        $response["lov_rut"]          =   $lov_ruts;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }
        $query              =   "SELECT U.USER_ID ID, U.RUT RUT  FROM USERS U WHERE U.ROLE_ID  IN(10, 11)";
        $stmt               =   mysqli_query($db_conn,  $query);
        $total              =   mysqli_num_rows($stmt);
        $lov_rut_to;
        if($total > 0)
        {
            while($r =  mysqli_fetch_array($stmt, MYSQLI_ASSOC)) {
                $x["ID"]      =   $r["ID"];
                $x["RUT"]     =   $r["RUT"];
                $lov_rut_to[] =   $x;
            }
        }
        $response["lov_rut_request_to"]          =   $lov_rut_to;
        echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_suppliers") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT U.USER_ID ID, initcap(U.RUT) RUT  FROM USERS U WHERE U.ROLE_ID = 13";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_ruts;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["ID"]      =   $row["ID"];
            $c["RUT"]     =   $row["RUT"];
            $lov_ruts[] =   $c;
        }
        $response["lov_rut"]          =   $lov_ruts;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_Receipt_Data") {
    if (isset($_SESSION["USER_ID"])) {
        $receipt_ID     =   $_POST["receipt_ID"];
        $sql            =   "SELECT initcap(U.NAME) AS NAME  FROM receipt_frm_sup_mst R, USERS U WHERE R.RECEIVER = U.USER_ID AND R.RECEIPT_ID = " . $receipt_ID;
        $result         =   mysqli_query($db_conn,  $sql);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $receipt["RECEIVER_NAME"]          =   $row["NAME"];
        $sql            =   "SELECT initcap(U.NAME) AS NAME  FROM receipt_frm_sup_mst R, USERS U WHERE R.SUPPLIER_ID = U.USER_ID AND R.RECEIPT_ID = " . $receipt_ID;
        $result         =   mysqli_query($db_conn,  $sql);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $receipt["SUPPLIER_NAME"]          =   $row["NAME"];
        $sql            =   "SELECT R.MATERIAL_DOC AS MAT_DOC, R.TIPO_DOC  AS TIPO_DOC  FROM receipt_frm_sup_mst R WHERE  R.RECEIPT_ID = " . $receipt_ID;
        $result         =   mysqli_query($db_conn,  $sql);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $receipt["MATERIAL_DOC"]            =   $row["MAT_DOC"];
        $receipt["TIPO_DOC"]                =   $row["TIPO_DOC"];
        $sql                            =       "SELECT D.MATERIAL_ID AS ID, initcap(M.MAT_NAME) NAM FROM receipt_frm_sup_det D, materials M WHERE D.MATERIAL_ID = M.MAT_ID AND D.FK_RECEIPT_ID =" . $receipt_ID;
        $result                         =       mysqli_query($db_conn,  $sql);
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $receipt["materials"][]     = $row;
        }
        // $receipt["RECEIVER_NAME"]       =       $row["RECEIVER_NAME"];
        $response["receipt"]            =       $receipt;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_Rut_Requesters") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT DISTINCT R.REQUESTED_BY ID,  U.RUT RUT  FROM USERS U,  REQUEST R WHERE U.USER_ID = R.REQUESTED_BY AND R.REQ_STATUS = 'A'";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["ID"]            =   $row["ID"];
            $c["RUT"]           =    $row["RUT"];
            $lov[]     =   $c;
        }
        $response["lov"]        =   $lov;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_Rut_Issuers") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT DISTINCT D.DELIVER_BY USER_ID, U.RUT RUT FROM DELIVERY_MST D, USERS U WHERE U.USER_ID = D.DELIVER_BY";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["ID"]            =       $row["USER_ID"];
            $c["RUT"]           =       $row["RUT"];
            $lov[]     =   $c;
        }
        $response["lov"]        =   $lov;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_requests_of_user") {
    if (isset($_SESSION["USER_ID"]) && $_POST["user_id"] != "") {
        $sql            =   "SELECT REQUEST_ID ID FROM REQUEST WHERE REQUESTED_BY = " . $_POST["user_id"] . " AND REQ_STATUS = 'A' AND REQUEST_ID NOT IN (SELECT REQUEST_ID FROM DELIVERY_MST )";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["ID"]            =   $row["ID"];

            $lov[]              =   $c;
        }
        $response["lov"]        =   $lov;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_deliveries_List") {
    if (isset($_SESSION["USER_ID"]) && $_POST["user_id"] != "") {
        $sql            =   "SELECT ID FROM DELIVERY_MST WHERE DELIVERED_TO = " . $_POST["user_id"] . "";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["ID"]            =   $row["ID"];

            $lov[]              =   $c;
        }
        $response["lov"]        =   $lov;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_supervisors") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT U.USER_ID AS SUP_ID, initcap(U.NAME) AS SUP_NAME FROM USERS U WHERE U.ROLE_ID = 11 AND  U.USER_ID !=" . $_SESSION["USER_ID"];
        if(isset($_SESSION["USER_ID"]) && $_SESSION["user"]["ROLE_ID"] == 10)
        {
            $sql            =   "SELECT U.USER_ID AS SUP_ID, initcap(U.NAME) AS SUP_NAME FROM USERS U WHERE U.ROLE_ID IN  (11, 4) AND  U.USER_ID !=" . $_SESSION["USER_ID"];

        }
        if(isset($_SESSION["USER_ID"]) &&  ($_SESSION["user"]["ROLE_ID"] == 11 || $_SESSION["user"]["ROLE_ID"] == 4))
        {
            $sql            =   "SELECT U.USER_ID AS SUP_ID, initcap(U.NAME) AS SUP_NAME FROM USERS U WHERE U.ROLE_ID = 14 AND  U.USER_ID != " . $_SESSION["USER_ID"];

        }
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_supervisors;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["SUP_ID"]            =   $row["SUP_ID"];
            $c["SUP_NAME"]          =   ucwords(strtolower($row["SUP_NAME"]));
            $lov_supervisors[]     =   $c;
        }
        $response["lov_supervisor"]          =   $lov_supervisors;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_materials") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT M.MAT_ID MAT_ID, M.ITMCODE ITMCODE, M.MAT_NAME NAME, initcap(U.UNIT_DESC) UNIT FROM  MATERIALS M, MAT_UNITS U WHERE M.UNIT_ID = U.UNIT_ID";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_materials;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["ID"]            =   $row["ITMCODE"];
            $c["NAME"]          =   ucwords(strtolower($row["NAME"]));
            $lov_materials[]     =   $c;
        }
        $response["lov_materials"]          =   $lov_materials;
        $response["login"]      =   true;
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_lovs") {
    if (isset($_SESSION["USER_ID"])) {
        $sql            =   "SELECT C.CONSTRUCTION_ID  CONSTRUCTION_ID, C.CONST_NAME  C_NAME FROM construction C";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_construction;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["CONS_ID"]      =   $row["CONSTRUCTION_ID"];
            $c["NAME"]         =   ucwords(strtolower($row["C_NAME"]));
            $lov_construction[] =   $c;
        }
        $sql            =   "SELECT U.USER_ID USER_ID, U.NAME NAM FROM USERS U WHERE U.ROLE_ID = 11";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_supervisors;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["SUPERVISOR_ID"]      =   $row["USER_ID"];
            $c["SUPERVISOR_NAME"]    =   ucwords(strtolower($row["NAM"]));;
            $lov_supervisors[] =   $c;
        }

        $response["lov_const"]          =   $lov_construction;
        $response["lov_supervisor"]     =   $lov_supervisors;
        $sql            =   "SELECT * FROM USERS WHERE USER_ID =" . $_SESSION["USER_ID"];
        $result         =   mysqli_query($db_conn,  $sql);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        if ($row) {
            $response["user"]   =   $row;
            $response["login"] = true;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "add-request") {
    if (isset($_SESSION["USER_ID"])) {
        $req_type                   =       "E";
        $req_title                  =       $_POST["title"];
        $req_desc                   =       $_POST["description"];
        $req_importance             =       $_POST["importance"];
        $cons_id                    =       $_POST["construction_ID"];
        $req_to                     =       $_POST["reqto_ID"];
        $materials                  =       $_POST["materials"];
        $request_status             =       "P";
        $request_to_role            =       GetUserRole($req_to);
        if($request_to_role["ROLE_ID"] == 4)
        {
            $request_status = "A";


        }

        $sql = 'INSERT INTO REQUEST (REQUESTED_BY, REQUEST_TO, CONSTRUCTION_ID,REQ_DATE,REQ_STATUS,REQ_TITLE,REQ_DESCRIP ,REQUEST_TYPE, REQ_IMPORTANCE)
                VALUES(' . $_SESSION["USER_ID"] . ', ' . $req_to . ',  ' . $cons_id . ', NOW(), "'.$request_status.'", "' . $req_title . '", "' . $req_desc . '", "' . $req_type . '" , "' . $req_importance . '")';
        $retval = mysqli_query($db_conn, $sql);
        $request_id     =   mysqli_insert_id($db_conn);
        $response["request"]    =   true;
        if ($retval) {
            foreach ($materials as $mat) {
                $sql = 'INSERT INTO REQUEST_DET(R_ID, MATERIAL_ID, UNIT, AMOUNT) VALUES(' . $request_id . ', ' . $mat[0] . ',  "' . $mat[3] . '", ' . $mat[2] . ')';
                $retval = mysqli_query($db_conn, $sql);
                if (!$retval) {
                    $response["error"]      =   true;
                    $response["request"]    =   false;
                }
            }
        } else {
            $response["request"]    =   false;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "material_delivery") {
    if (isset($_SESSION["USER_ID"])) {
        $request_ID           =     $_POST["request_ID"];
        $deliver_to           =     $_POST["delivered_to"];
        $sql                  =     'INSERT INTO DELIVERY_MST (ENT_DATE, DELIVER_BY, REQUEST_ID, DELIVERED_TO, VIEWER) VALUES(NOW(), ' . $_SESSION["USER_ID"] . ',' . $request_ID . ', ' . $deliver_to . ', "' . $_POST["viewer"] . '")';
        $retval               =     mysqli_query($db_conn, $sql);
        $deliver_ID           =     mysqli_insert_id($db_conn);
        $materials            =     $_POST["materials"];
        $response["error"]    =     false;
        if ($retval) {
            foreach ($materials as $mat) {
                $sql        =       'INSERT INTO DELIVERY_DET(FK_DELIVER_ID, MATERIAL_ID, AMOUNT, UNIT) VALUES(' . $deliver_ID . ', ' . $mat[0] . ',  ' . $mat[2] . ', "' . $mat[3] . '")';
                $retval     =       mysqli_query($db_conn, $sql);
                if (!$retval) {
                    $response["error"]      =   true;
                }
            }
            if ($response["error"] == true) {
                $sql        =       'DELETE FROM DELIVERY_DET WHERE FK_DELIVER_ID = ' . $deliver_ID;
                $retval     =       mysqli_query($db_conn, $sql);
                $sql        =       'DELETE FROM DELIVERY_MST WHERE ID = ' . $deliver_ID;
                $retval     =       mysqli_query($db_conn, $sql);
            }
        } else {
            $response["error"]      =   true;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "material_return") {
    if (isset($_SESSION["USER_ID"])) {

        $deliver_ID              =   $_POST["deliver_ID"];
        $sql = 'INSERT INTO RETURN_MST (DELIVER_ID, RETURN_DT,RETURN_BY, OBSERVATION) VALUES(' . $deliver_ID . ' , NOW(), ' . $_SESSION["USER_ID"] . ', "' . $_POST["observation"] . '")';
        $retval = mysqli_query($db_conn, $sql);
        $return_ID     =   mysqli_insert_id($db_conn);
        $materials = $_POST["materials"];
        $response["error"]      =   false;
        if ($retval) {
            foreach ($materials as $mat) {
                $sql = 'INSERT INTO RETURN_DET(FK_RETURN_ID, MATERIAL_ID, UNIT, AMOUNT, COND) VALUES(' . $return_ID . ', ' . $mat[0] . ',  "' . $mat[2] . '", ' . $mat[4] . ', "' . $mat[5] . '")';
                $retval = mysqli_query($db_conn, $sql);
                if (!$retval) {
                    $response["error"]      =   true;
                }
            }
        } else {
            $response["error"]      =   true;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "material_return_supplier") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"] = true;
        $receipt_ID     =   $_POST["receipt_number"];
        $receipt;
        if ($receipt_ID) {
            $sql            =   "SELECT * FROM RECEIPT_FRM_SUP_MST WHERE RECEIPT_ID = " . $receipt_ID;
            $result         =   mysqli_query($db_conn,  $sql);
            $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
            if ($row) {
                $receipt =  $row;
            }
        }

        $sql = 'INSERT INTO RETURN_SUP_MST (RETURN_TO, RETURN_BY, RETURN_DT, MATERIAL_DOC, UNIT_DOC, DOCUMENT_NAME) VALUES(' . $receipt["SUPPLIER_ID"] . ',' . $_SESSION["USER_ID"] . ' , NOW(), "' . $receipt["MATERIAL_DOC"] . '", "' . $receipt["TIPO_DOC"] . '", "' . basename($_FILES['Fichier1']['name']) . '")';
        $retval = mysqli_query($db_conn, $sql);
        $return_ID     =   mysqli_insert_id($db_conn);
        $materials = json_decode($_POST["materials"]);
        $response["error"]      =   false;
        $response["status"]     =   true;
        if ($retval) {
            $folder                     =       "../uploads/" . $return_ID . "/";
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            move_uploaded_file($_FILES['Fichier1']['tmp_name'], $folder . basename($_FILES['Fichier1']['name']));
            foreach ($materials as $mat) {
                $sql = 'INSERT INTO RETURN_SUP_DET(FK_RETURN_ID, MATERIAL_ID, AMOUNT, UNIT) VALUES(' . $return_ID . ', ' . $mat[0] . ',  ' . $mat[2] . ', "' . $mat[3] . '")';
                $retval = mysqli_query($db_conn, $sql);
                if (!$retval) {
                    $response["error"]      =   true;
                    $response["status"]     =   false;
                }
            }
        } else {
            $response["status"]     =   false;
            $response["error"]      =   true;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "request_to_warehouse") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]   =   true;
        $construction_ID     =   $_POST["constructionList"];
        $apply_For           =   $_POST["applyfor"];
        $sql                 =  'INSERT INTO WAREHOUSE_REQ_MST (CONST_ID, REQUEST_BY, REQUESTER_TYPE, OBSERVATION, REQ_DT) VALUES(' . $construction_ID . ',' . $_SESSION["USER_ID"] . ',"' . $apply_For . '","' . $_POST["description"] . '" , NOW())';
        $retval              =   mysqli_query($db_conn, $sql);
        $request_ID          =   mysqli_insert_id($db_conn);
        $materials           =   json_decode($_POST["materials"]);
        $response["error"]   =   false;
        $response["status"]  =   true;
        if ($retval) {
            foreach ($materials as $mat) {
                $sql = 'INSERT INTO WAREHOUSE_REQ_DET(FK_REQUEST_ID, MATERIAL_ID, UNIT, AMOUNT) VALUES(' . $request_ID . ', ' . $mat[0] . ',  "' . $mat[3] . '", ' . $mat[2] . ')';
                $retval = mysqli_query($db_conn, $sql);
                if (!$retval) {
                    $response["error"]      =   true;
                    $response["status"]     =   false;
                }
            }
        } else {
            $response["status"]     =   false;
            $response["error"]      =   true;
        }
    } else {

        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_requests") {
    
    $user_role      =   $_SESSION["user"]["ROLE_ID"];
    // if the user is bodega central like the main store to get all requests entered
    if ($user_role   ==  14) {
        $sql            =   "SELECT REQUEST_ID REQ_ID, CASE WHEN R.REQUEST_TYPE = 'E' THEN 'Entrega De Material' ELSE 'Others' END AS REQ_TYPE,REQ_APPLICANT REQ_APP ,  CASE  WHEN R.REQ_STATUS = 'P' THEN 'Pending' WHEN R.REQ_STATUS = 'A' THEN 'Approved' WHEN R.REQ_STATUS = 'C' THEN 'Canceled' END AS REQ_STATUS,REQ_DATE REQ_DATE,  CASE  WHEN R.REQ_IMPORTANCE = 'N' THEN 'Normal' WHEN R.REQ_IMPORTANCE = 'U' THEN 'Urgente' END AS REQ_IMP,  U.NAME NAME FROM REQUEST R, USERS U  WHERE  R.REQUESTED_BY  =  U.USER_ID ";
    }
    // if the user is supervisor
    if (($user_role   ==  11) || ($user_role   ==  4)) {
        $sql            =   "SELECT REQUEST_ID REQ_ID, CASE WHEN R.REQUEST_TYPE = 'E' THEN 'Entrega De Material' ELSE 'Others' END AS REQ_TYPE,REQ_APPLICANT REQ_APP ,  CASE  WHEN R.REQ_STATUS = 'P' THEN 'Pending' WHEN R.REQ_STATUS = 'A' THEN 'Approved' WHEN R.REQ_STATUS = 'C' THEN 'Canceled' END AS REQ_STATUS,REQ_DATE REQ_DATE,  CASE  WHEN R.REQ_IMPORTANCE = 'N' THEN 'Normal' WHEN R.REQ_IMPORTANCE = 'U' THEN 'Urgente' END AS REQ_IMP,  U.NAME NAME FROM REQUEST R, USERS U  WHERE  R.REQUESTED_BY  =  U.USER_ID   AND REQUEST_TO = " . $_SESSION["USER_ID"];
    }
    // if user is bodeguero see only his requests
    if ($user_role == 10) {
        $sql            =   "SELECT REQUEST_ID REQ_ID, CASE WHEN R.REQUEST_TYPE = 'E' THEN 'Entrega De Material' ELSE 'Others' END AS REQ_TYPE,REQ_APPLICANT REQ_APP , CASE WHEN R.REQ_STATUS = 'P' THEN 'Pending' WHEN R.REQ_STATUS = 'A' THEN 'Approved'  WHEN R.REQ_STATUS = 'C' THEN 'Canceled' END AS REQ_STATUS,REQ_DATE REQ_DATE, CASE  WHEN R.REQ_IMPORTANCE = 'N' THEN 'Normal' WHEN R.REQ_IMPORTANCE = 'U' THEN 'Urgente' END AS REQ_IMP,  U.NAME NAME FROM REQUEST R, USERS U WHERE  R.REQUESTED_BY  =  U.USER_ID AND REQ_STATUS IN ('P', 'A') AND REQUESTED_BY = " . $_SESSION["USER_ID"];
    }

    if (isset($_POST["importance"]) && $_POST["importance"] != "") {
        $sql .= "AND R.REQ_IMPORTANCE ='" . $_POST["importance"] . "'";
    }
    if (isset($_POST["const_id"]) && $_POST["const_id"] != "") {
        $sql .= "AND R.CONSTRUCTION_ID =" . $_POST["const_id"] . "";
    }
    if (isset($_POST["req_to"]) && $_POST["req_to"] != "") {
        $sql .= "AND R.REQUEST_TO =" . $_POST["req_to"] . "";
    }
    if (isset($_POST["req_by"]) && $_POST["req_by"] != "") {
        $sql .= "AND R.REQUESTED_BY =" . $_POST["req_by"] . "";
    }
    if ((isset($_POST["from_dt"]) && $_POST["from_dt"] != "") && (isset($_POST["to_dt"]) && $_POST["to_dt"] != "")) {
        $sql .= "AND R.REQ_DATE >= '" . $_POST["from_dt"] . "' AND R.REQ_DATE <= '" . $_POST["to_dt"] . "'";
    }

    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $requests_list;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $request["REQ_ID"]              =       $row["REQ_ID"];
        $request["REQ_TYPE"]            =       $row["REQ_TYPE"];
        $request["NAME"]                =       ucwords(strtolower($row["NAME"]));
        $request["REQ_STATUS"]          =       $row["REQ_STATUS"];
        $request["REQ_DATE"]            =       $row["REQ_DATE"];
        $request["REQ_IMPORTANCE"]      =       $row["REQ_IMP"];
        $requests_list[]                =       $request;
    }


    echo (json_encode($requests_list));
}
if (isset($_POST["action"]) && $_POST["action"] == "get-materials") {
    $sql            =   "SELECT R.MATERIAL_ID ID, M.MAT_NAME NAME, R.AMOUNT AMOUNT,  initcap(U.UNIT_DESC) UNIT FROM REQUEST_DET R, MATERIALS M, MAT_UNITS U
                            WHERE M.ITMCODE = R.MATERIAL_ID
                            AND M.UNIT_ID = U.UNIT_ID
                            AND R.R_ID = " . $_POST["request_ID"];
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $materials_list;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $request["ID"]              =       $row["ID"];
        $request["MATERIAL"]        =       ucwords(strtolower($row["NAME"]));
        $request["AMOUNT"]          =       ucwords(strtolower($row["AMOUNT"])) . "  " . ucwords(strtolower($row["UNIT"]));
        $materials_list[]           =       $request;
    }
    $response["materials"] = $materials_list;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "request_approve") {
    $status     =   $_POST["status"];
    if ($status == "A") {
        $sql            =   "UPDATE REQUEST SET REQ_STATUS = 'A', APPROVAL_DT = NOW(), APPROVED_BY = " . $_SESSION["USER_ID"] . " WHERE REQUEST_ID =" . $_POST["request_ID"];
    }
    if ($status == "R") {
        $sql            =   "UPDATE REQUEST SET REQ_STATUS = 'R', APPROVAL_DT = NOW(), APPROVED_BY = " . $_SESSION["USER_ID"] . " WHERE REQUEST_ID =" . $_POST["request_ID"];
    }
    $stmt         =   mysqli_query($db_conn,  $sql);
    if ($stmt) {
        $response["status"] = true;
    }
    if (!$stmt) {
        $response["status"] = false;
    }


    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_request_data") {
    $sql            =   "SELECT R.REQUEST_ID ID, U.NAME NAME, U.RUT RUT, initcap(UR.ROLE_DESCRIPTION) DESIGNATION, R.REQ_TITLE TITLE, R.REQ_DESCRIP DESCRIPTION, R.REQUEST_TO REQ_TO, CASE  
                            WHEN REQ_IMPORTANCE = 'N' THEN 'Normal'
                            ELSE 'Urgente' END AS REQ_IMP 
                            FROM REQUEST R, USERS U, USER_ROLES UR WHERE  R.REQUESTED_BY =   U.USER_ID AND U.ROLE_ID = UR.ROLE_ID   AND R.REQUEST_ID =" . $_POST["request_ID"];
    $result         =   mysqli_query($db_conn,  $sql);
    $request        =   mysqli_fetch_array($result, MYSQLI_ASSOC);
    $sql            =   "SELECT U.NAME SUPERVISOR FROM USERS U WHERE  USER_ID =" . $request["REQ_TO"];
    $result         =   mysqli_query($db_conn,  $sql);
    $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
    $request["REQ_TO_NAME"]     =   $row["SUPERVISOR"];
    $sql                            =       "SELECT D.MATERIAL_ID ID, initcap(M.MAT_NAME) AS NAM FROM materials M, request_det D WHERE M.ITMCODE = D.MATERIAL_ID AND  D.R_ID  = " . $_POST["request_ID"];
    $result                         =       mysqli_query($db_conn,  $sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $request["materials"][]     = $row;
    }
    $response["request"]    =   $request;


    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_delivery_data") {
    $sql                            =       "SELECT D.MATERIAL_ID ID, initcap(M.MAT_NAME) AS NAM FROM materials M, DELIVERY_DET D WHERE M.MAT_ID = D.MATERIAL_ID AND  D.FK_DELIVER_ID  = " . $_POST["deliver_ID"];
    $result                         =       mysqli_query($db_conn,  $sql);
    $delivery;
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $delivery["materials"][]     = $row;
    }
    $response["delivery"]    =   $delivery;


    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_receipt_det") {
    $sql                            =       "SELECT * FROM RECEIPT_MST_INV WHERE ID = " . $_POST["receipt_ID"];
    $result                         =       mysqli_query($db_conn,  $sql);
    $receipt                        =       mysqli_fetch_array($result, MYSQLI_ASSOC);
    $sql                            =       "SELECT U.NAME SUPPLIER FROM USERS U WHERE  USER_ID = " . $receipt["RECEIPT_FRM"];
    $result                         =       mysqli_query($db_conn,  $sql);
    $row                            =       mysqli_fetch_array($result, MYSQLI_ASSOC);
    $receipt["SUPPLIER_NAME"]       =       $row["SUPPLIER"];
    $sql                            =       "SELECT U.NAME RECEIVER_NAME FROM USERS U WHERE  USER_ID = " . $receipt["RECEIPT_BY"];
    $result                         =       mysqli_query($db_conn,  $sql);
    $row                            =       mysqli_fetch_array($result, MYSQLI_ASSOC);
    $receipt["RECEIVER_NAME"]       =       $row["RECEIVER_NAME"];
    $sql                            =       "SELECT D.MATERIAL_ID ID, initcap(M.MAT_NAME) NAME, CONCAT(D.AMOUNT,' ', D.UNIT) AS AMOUNT FROM receipt_det_inv D, materials M WHERE D.MATERIAL_ID = M.MAT_ID AND FK_RECEIPT_ID = " . $receipt["ID"];
    $result                         =       mysqli_query($db_conn,  $sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $receipt["materials"][]     = $row;
    }
    // $receipt["RECEIVER_NAME"]       =       $row["RECEIVER_NAME"];
    $response["receipt"]            =       $receipt;


    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "material_receive_inv") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]          =       true;
        $material_receipt_from      =       $_POST["receipt_from"];
        $materials                  =       json_decode($_POST["materials"]);
        $fileName                   =       $_FILES['image_material']['name'];
        $sql                        =       'INSERT INTO RECEIPT_MST_INV (RECEIPT_BY, RECEIPT_FRM, RECEIPT_DT, IMG) VALUES(' . $_SESSION["USER_ID"] . ', ' . $material_receipt_from . ', NOW(), "' . $fileName . '" )';
        $retval                     =       mysqli_query($db_conn, $sql);
        $receipt_ID                 =       mysqli_insert_id($db_conn);
        $folder                     =       "../material_Images/" . $receipt_ID . "/";

        if (isset($_FILES["image_material"]["name"])) {
            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
            }
            move_uploaded_file($_FILES["image_material"]["tmp_name"], $folder . $fileName);
        }
        if ($retval) {
            foreach ($materials as $mat) {
                $sql    =   'INSERT INTO RECEIPT_DET_INV (FK_RECEIPT_ID, MATERIAL_ID, UNIT, AMOUNT) VALUES(' . $receipt_ID . ', ' . $mat[0] . ',  "' . $mat[3] . '", ' . $mat[2] . ')';
                $stmt   =   mysqli_query($db_conn, $sql);
                if (!$stmt) {
                    $response["error"]              =   true;
                    $response["receipt_status"]     =   false;
                }
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "material_receive_supplier") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]          =       true;
        $response["status"]         =       true;
        $material_receipt_from      =       $_POST["supplier_List"];
        $material_doc               =       $_POST["doc_number"];
        $tipo_doc                   =       $_POST["type_document"];
        $obsercation                =       $_POST["observation"];
        $materials                  =       json_decode($_POST["materials"]);
        $sql                        =       'INSERT INTO RECEIPT_FRM_SUP_MST (SUPPLIER_ID, MATERIAL_DOC, TIPO_DOC, OBSERVATION, RECEIVER, ENT_DATE) VALUES(' . $material_receipt_from . ', "' . $material_doc . '", "' . $tipo_doc . '","' . $obsercation . '",' . $_SESSION["USER_ID"] . ', NOW())';
        $retval                     =       mysqli_query($db_conn, $sql);
        $receipt_ID                 =       mysqli_insert_id($db_conn);
        if ($retval) {
            foreach ($materials as $mat) {
                $sql = 'INSERT INTO RECEIPT_FRM_SUP_DET (FK_RECEIPT_ID, MATERIAL_ID, AMOUNT, UNIT) VALUES(' . $receipt_ID . ', "' . $mat[0] . '",  ' . $mat[2] . ', "' . $mat[3] . '")';
                $retval = mysqli_query($db_conn, $sql);
                if (!$retval) {
                    $response["error"]              =   true;
                    $response["status"]             =   false;
                }
            }
        } else {
            $response["status"]    =   false;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_receipts") {
    $sql            =   "SELECT M.ID ID,M.RECEIPT_DT DT,  U.NAME SUPPLIER_NAME   FROM RECEIPT_MST_INV M, USERS U WHERE M.RECEIPT_FRM = U.USER_ID";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $receipts_List;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $request["ID"]              =       $row["ID"];
        $request["DATE"]            =       $row["DT"];
        $request["NAME"]            =       ucwords(strtolower($row["SUPPLIER_NAME"]));
        $receipts_List[]            =       $request;
    }
    $response["receipts"] = $receipts_List;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_Receipts_List") {
    $sql            =   "SELECT R.RECEIPT_ID ID FROM receipt_frm_sup_mst R ORDER BY R.RECEIPT_ID";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $receipts_List;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $receipt["ID"]              =       $row["ID"];
        $receipts_List[]            =       $receipt;
    }
    $response["receipts"] = $receipts_List;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_material_values") {
    if ($_POST["material_ID"] != "" && $_POST["request_ID"] != "") {
        $sql            =   "SELECT R.MATERIAL_ID ID, initcap(M.MAT_NAME) AS NAM, R.AMOUNT REQ_AMOUNT, R.UNIT UNIT  FROM request_det R, materials M WHERE R.MATERIAL_ID = M.ITMCODE AND R.MATERIAL_ID  =" . $_POST["material_ID"] . " AND R_ID = " . $_POST["request_ID"];
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $mat["ID"]      =   $row["ID"];
        $mat["NAME"]    =   $row["NAM"];
        $mat["REQ_AMOUNT"]      =   $row["REQ_AMOUNT"];
        $mat["UNIT"]            =   $row["UNIT"];
        $total_receipt          =    Material_STK($_POST["material_ID"]);
        $total_issued           =    Total_Material_Issued($_POST["material_ID"]);
        $mat["STK"]             =   intval($total_receipt["RECEIPT_QTY"]) - intval($total_issued["ISSUED_QTY"]);
        $response["material"]   =   $mat;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_deliver_values") {
    if ($_POST["material_ID"] != "" && $_POST["deliver_ID"] != "") {
        $sql            =   "SELECT R.MATERIAL_ID ID, initcap(M.MAT_NAME) AS NAM, FORMAT(SUM(R.AMOUNT), 2) AS  DEL_AMOUNT, R.UNIT UNIT  FROM DELIVERY_DET R, materials M WHERE R.MATERIAL_ID = M.ITMCODE AND R.MATERIAL_ID  =" . $_POST["material_ID"] . " AND FK_DELIVER_ID = " . $_POST["deliver_ID"];
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $row            =   mysqli_fetch_array($result, MYSQLI_ASSOC);
        $mat["ID"]      =   $row["ID"];
        $mat["NAME"]    =   $row["NAM"];
        $mat["DEL_AMOUNT"]      =   $row["DEL_AMOUNT"];
        $mat["UNIT"]            =   $row["UNIT"];
        $response["material"]   =   $mat;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_inventory_stock") {
    if(isset($_SESSION["USER_ID"]) && $_SESSION["user"]["ROLE_ID"]  == 14)
    {
        $sql            =   "SELECT R.MATERIAL_ID ITMCODE, initcap(M.MAT_NAME) MATERIAL_NAME, SUM(R.AMOUNT) TOTAL_RECEIPT, M.OPENING_STK OPENING_STK,  initcap(U.UNIT_DESC) UNIT,  'RECEIPT_SUP' FROM RECEIPT_FRM_SUP_DET R, MATERIALS M, MAT_UNITS U 
                             WHERE R.MATERIAL_ID = M.ITMCODE
                             AND M.UNIT_ID = U.UNIT_ID
                             GROUP BY  ITMCODE";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $materials;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $r["ITMCODE"]                    =          $row["ITMCODE"];
            $receipt_inv                     =          Material_STK($row["ITMCODE"]);
            $r["MATERIAL_NAME"]              =          $row["MATERIAL_NAME"];
            $r["TOTAL_RECEIPT"]              =          intval($row["TOTAL_RECEIPT"]) + intval($receipt_inv["RECEIPT_QTY"]);
            $r["OPENING_STK"]                =          $row["OPENING_STK"];
            $r["UNIT"]                       =          $row["UNIT"];
            $total_material_issued           =          Total_Material_Issued($row["ITMCODE"]);
            $total_issued                    =          0;
            if(isset($total_material_issued) && sizeof($total_material_issued) > 0)
            {
                $total_issued                =          intval($total_material_issued["ISSUED_QTY"]);

            }
            $r["TOTAL_STK"]                  =          (intval($row["TOTAL_RECEIPT"]) + intval($row["OPENING_STK"]) + intval($receipt_inv["RECEIPT_QTY"]) - $total_issued);            
            $materials[]                     =          $r;
        }

    }
    if(isset($_SESSION["USER_ID"]) && $_SESSION["user"]["ROLE_ID"] == 10)
    {
        $sql            =   "SELECT D.FK_DELIVER_ID DELIVERY_ID, D.MATERIAL_ID ITMCODE, initcap(M.MAT_NAME) MATERIAL_NAME ,SUM(D.AMOUNT) RECEIPT_QTY, initcap(U.UNIT_DESC) UNIT   
                                FROM DELIVERY_DET D, MATERIALS M, MAT_UNITS U
                                WHERE D.MATERIAL_ID = M.ITMCODE
                                AND M.UNIT_ID = U.UNIT_ID
                                GROUP BY D.MATERIAL_ID";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $materials;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $r["ITMCODE"]                    =          $row["ITMCODE"];
            $r["MATERIAL_NAME"]              =          $row["MATERIAL_NAME"];
            $r["TOTAL_RECEIPT"]              =          intval($row["RECEIPT_QTY"]);
            $r["OPENING_STK"]                =          0;
            $r["UNIT"]                       =          $row["UNIT"];
            $r["TOTAL_STK"]                  =          intval($row["RECEIPT_QTY"]);
            $materials[]                     =          $r;
        }

    }
    
    $response["data"] = $materials;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_stock_total_supplier") {
    $sql            =   "SELECT R.MATERIAL_ID ITMCODE, initcap(M.MAT_NAME) MATERIAL_NAME, SUM(R.AMOUNT) TOTAL_RECEIPT, M.OPENING_STK OPENING_STK,  initcap(U.UNIT_DESC) UNIT,  'RECEIPT_SUP' FROM RECEIPT_FRM_SUP_DET R, MATERIALS M, MAT_UNITS U 
                            WHERE R.MATERIAL_ID = M.ITMCODE
                            AND M.UNIT_ID = U.UNIT_ID
                            GROUP BY  ITMCODE";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $materials;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $r["ITMCODE"]                    =          $row["ITMCODE"];
        $r["MATERIAL_NAME"]              =          $row["MATERIAL_NAME"];
        $r["TOTAL_RECEIPT"]              =          $row["TOTAL_RECEIPT"];
        $r["OPENING_STK"]                =          $row["OPENING_STK"];
        $r["UNIT"]                       =          $row["UNIT"];
        $r["TOTAL_STK"]                  =          intval($row["TOTAL_RECEIPT"]) + intval($row["OPENING_STK"]);
        $materials[]                     =          $r;
    }
    $response["data"] = $materials;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_material_details") {
    $material_ID    =    $_POST["material_ID"];
    $receipt_ID     =    $_POST["receipt_ID"];
    $sql            =    "SELECT  D.MATERIAL_ID ID , initcap(M.MAT_NAME) As NAME, FORMAT(D.AMOUNT, 2) AS QTY, D.UNIT AS UNIT  FROM receipt_frm_sup_det D, materials M WHERE M.MAT_ID = D.MATERIAL_ID AND D.FK_RECEIPT_ID = " . $receipt_ID . " AND D.MATERIAL_ID = " . $material_ID . "";
    $result         =    mysqli_query($db_conn,  $sql);
    $count          =    mysqli_num_rows($result);
    $row            =    mysqli_fetch_array($result, MYSQLI_ASSOC);
    $response["data"] = $row;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && ($_POST["action"] == "import-materials") && !empty($_FILES["materials_csv"]["name"])) {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $response["login"] = true;
        $allowed_ext    =   array("csv");
        $temp           =   explode(".", $_FILES["materials_csv"]["name"]);
        $extension      =   end($temp);
        $entries_error  =   array();
        if (in_array($extension, $allowed_ext)) {
            $file_data  =   fopen($_FILES["materials_csv"]["tmp_name"], "r");
            fgetcsv($file_data);
            while ($row      =   fgetcsv($file_data)) {
                $sql                            =       'INSERT INTO RECEIPT_MST_INV (RECEIPT_BY, RUT_SUP, RECEIPT_DT) VALUES(' . $_SESSION["USER_ID"] . ', "' . $row[1] . '", NOW())';
                $retval                         =       mysqli_query($db_conn, $sql);
                if ($retval) {
                    $receipt_ID                 =       mysqli_insert_id($db_conn);
                    $query                      =       'INSERT INTO RECEIPT_DET_INV (FK_RECEIPT_ID, MATERIAL_ID, UNIT, AMOUNT) VALUES(' . $receipt_ID . ', ' . $row[2] . ',  "' . $row[3] . '", ' . $row[4] . ')';
                    $stmt                       =       mysqli_query($db_conn, $query);
                    if ($stmt) {
                        $response["status"]     =   true;
                    }
                    if (!$stmt) {
                        $response["status"]         =       false;
                        $entries_error[]            =       $row[1];
                        $query                      =       'DELETE FROM RECEIPT_MST_INV WHERE ID = ' . $receipt_ID;
                        $stmt                       =       mysqli_query($db_conn, $query);
                    }
                }
                if (!$retval) {
                    $response["status"]         =   false;
                    $entries_error[]            =   $row[1];
                }
            }
            $response["error_entries"]  =   $entries_error;
        }
    } else {
        $response["login"] = false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_deliveries") {
    $sql            =   "SELECT M.ID DEL_ID, initcap(U.NAME) DELIVER_BY, DATE_FORMAT(M.ENT_DATE, '%d-%m-%Y %H:%i:%s') DEL_DT, M.DELIVERED_TO DELIVER_TO, M.REQUEST_ID REQUEST_ID FROM DELIVERY_MST M, USERS U WHERE m.DELIVER_BY = U.USER_ID";
    $result         =   mysqli_query($db_conn,  $sql);
    $deliveries_List;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $delivery               =       $row;
        $query_name             =       "SELECT NAME FROM USERS WHERE USER_ID = " . $row["DELIVER_TO"];
        $stmt                   =       mysqli_query($db_conn,  $query_name);
        $r                      =       mysqli_fetch_array($stmt, MYSQLI_ASSOC);
        $delivery["DEL_TO_NAME"]     =       $r["NAME"];
        $deliveries_List[]      =       $delivery;
    }
    $response["deliveries"]     = $deliveries_List;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_store_materials") {
    $sql            =   "SELECT MAT_ID, initcap(MAT_NAME) AS NAME, initcap(UNIT) AS UNIT, COALESCE(OPENING_STK, 0) AS OPN_STK FROM MATERIALS";
    $result         =   mysqli_query($db_conn,  $sql);
    $list;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {

        $delivery["DEL_TO_NAME"]     =       $r["NAME"];
        $deliveries_List[]      =       $delivery;
    }
    $response["deliveries"]     = $deliveries_List;

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_user_modules") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =   true;
        $sql                    =   "SELECT * FROM MODULE_CATEGORY 
                                        WHERE C_ID IN ( 
                                        SELECT DISTINCT(M.CATEGORY_ID) CATEGORIES  
                                        FROM MODULES M 
                                        WHERE ID IN (
                                        SELECT  U.MODULE_ID FROM USER_MODULES U 
                                        WHERE U.USER_ID = ".$_SESSION["USER_ID"]."))";
        $result                 =   mysqli_query($db_conn,  $sql);
        $count                  =   mysqli_num_rows($result);
        if ($count > 0) 
        {
            $user_modules = array();
            $link;
            while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) 
            {
                $link                =   $row;
                $query                      =   "SELECT UM.MODULE_ID ID, initcap(M.NAME) MODULE_NAME, M.LINK MODULE_LINK   FROM USER_MODULES UM, MODULES M WHERE UM.MODULE_ID = M.ID AND UM.ACTIVE_STATUS = 'A' AND UM.USER_ID = ".$_SESSION["USER_ID"]." AND M.CATEGORY_ID =".$link["C_ID"];
                $stmt                       =   mysqli_query($db_conn,  $query);
                while ($r =  mysqli_fetch_array($stmt, MYSQLI_ASSOC)) 
                {
                    $link["MODULES"][]       =       $r;
                    
                
                }
                $user_modules[] = $link;
                
            }
            $response["nav_links"] = $user_modules;
            
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_material_unit") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =   true;
        $sql                    =   "SELECT M.UNIT_ID, initcap(U.UNIT_DESC) UNIT FROM MATERIALS M, MAT_UNITS U WHERE M.UNIT_ID = U.UNIT_ID AND M.ITMCODE = '".$_POST["itmcode"]."' ";
        $result                 =   mysqli_query($db_conn,  $sql);
        $count                  =   mysqli_num_rows($result);
        if ($count > 0) 
        {
            $response["status"]     =   true;
            $response["MATERIAL"]   =   mysqli_fetch_array($result, MYSQLI_ASSOC);  

        }
        else
        {
            $response["status"]     =   false;


        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_constructions_part") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =   true;
        $sql            =   "SELECT DISTINCT s.CONSTRUCTION_ID AS CONST_ID, c.CONST_NAME AS C_NAME FROM construction_stage s, construction c WHERE s.CONSTRUCTION_ID = c.CONSTRUCTION_ID";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_part;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["CONS_ID"]       = $row["CONST_ID"];
            $c["NAME"]          = ucwords(strtolower($row["C_NAME"]));
            $lov_part[] =   $c;
        }
        $response["lov_const"]          =   $lov_part;
        
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}


if (isset($_POST["action"]) && $_POST["action"] == "get_partidas") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =   true;
        $sql            =   "SELECT s.ID AS ID_P, s.CONSTRUCTION_ID AS C_ID, s.STAGE_ID AS ST_ID, s.STAGE_STATUS AS ST, 
                             s.STAGE_NOTE, c.CONST_NAME AS N_OBRA FROM CONSTRUCTION_STAGE s, CONSTRUCTION c 
                             WHERE c.CONSTRUCTION_ID = s.CONSTRUCTION_ID";
        $result         =   mysqli_query($db_conn,  $sql);
        $count          =   mysqli_num_rows($result);
        $lov_partidas;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $c["Primary"]           =   $row["ID_P"];
            $c["C_CONS"]            =   $row["C_ID"];
            $c["ID"]                =   $row["ST_ID"];
            $c["C_NAME"]            =   $row["N_OBRA"];
            $c["P_NAME"]            =   ucwords(strtolower($row["ST"]));
            $lov_partidas[]         =   $c;
        }
        $response["lov_const"]          =   $lov_partidas;
        
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}

