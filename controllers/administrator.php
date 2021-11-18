<?php
session_start();
include("db_connection.php");
if (isset($_POST["action"]) && $_POST["action"] == "new_construction") {
    if (isset($_SESSION["USER_ID"])) {

        $response["login"]      =   true;
        $supervisor     =   $_SESSION["USER_ID"];
        $sql = 'INSERT INTO CONSTRUCTION (CONST_NAME, SUPERVISOR, COORDINATES, ADDRESS, BUSINESS, BUS_CONDITION, QTY, START_DT, END_DT, ENT_DATE) 
                                    VALUES(UPPER("' . $_POST["construction"] . '"), ' . $_SESSION["USER_ID"] . ', "' . $_POST["coordinates"] . '", UPPER("' . $_POST["address"] . '"), UPPER("' . $_POST["business"] . '"), UPPER("' . $_POST["business_condition"] . '"), ' . $_POST["amount"] . ', "' . $_POST["start_date"] . '", "' . $_POST["end_date"] . '", NOW())';
        $retval     =   mysqli_query($db_conn, $sql);
        $const_ID   =   mysqli_insert_id($db_conn);

        if ($retval) {
            $response["error"]      =   false;
            if (isset($_FILES['img_obra']) && ($_FILES['img_obra']["name"] != "")) {
                $errors             =       array();
                $file_name          =       $_FILES['img_obra']['name'];
                $file_size          =       $_FILES['img_obra']['size'];
                $file_tmp           =       $_FILES['img_obra']['tmp_name'];
                $file_type          =       $_FILES['img_obra']['type'];
                $tmp = explode('.', $_FILES['img_obra']['name']);
                $file_ext = end($tmp);
                if ($file_size > 2097152) {
                    $response["error"]          =   true;
                    $response["error_msg"]      =   "El Tamaño Del Archivo Debe Ser Inferior a 2 Mb";
                }
                if ($response["error"] == false) {
                    $img_name = $const_ID . "." . $file_ext;
                    if (move_uploaded_file($file_tmp, "../requests/uploads/constructions/" . $img_name)) {
                        $sql        =   'UPDATE CONSTRUCTION SET IMG_NAME = "' . $img_name . '" WHERE CONSTRUCTION_ID = ' . $const_ID . '';
                        $stmt = mysqli_query($db_conn, $sql);
                        if (!$stmt) {
                            $response["error"]          =   true;
                            $response["error_msg"]      =   "Ha ocurrido Un error. Por Favor, Inténtelo De Nuevo Más Rarde";
                        }
                    } else {
                        $response["error"]          =   true;
                        $response["error_msg"]      =   "Ha ocurrido Un error. Por Favor, Inténtelo De Nuevo Más Rarde";
                        $sql        =   'DELETE FROM CONSTRUCTION WHERE CONSTRUCTION_ID = ' . $const_ID . '';
                        mysqli_query($db_conn, $sql);
                    }
                }
            }
        } else {
            $response["error"]      =   true;
            $response["error"]      =   "Ha ocurrido Un error. Por Favor, Inténtelo De Nuevo Más Rarde";
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "new_document") {
    if (isset($_SESSION["USER_ID"])) {

        $response["login"]      =   true;
        $sql = 'INSERT INTO DOCS_TABLE(DOC_NAME, ENT_TIME, ENT_DATE, DESCRIPTION, CONST_ID, UPLOADED_BY)
                                 VALUES ("' . $_POST["name"] . '", "' . $_POST["time"] . '", "' . $_POST["dt"] . '", "' . $_POST["doc_text"] . '", ' . $_POST["construction"] . ', ' . $_SESSION["USER_ID"] . ')';
        $retval     =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $response["error"]      =   false;
        } else {
            $response["error"]          =   true;
            $response["error_msg"]      =   "Ha ocurrido Un error. Por Favor, Inténtelo De Nuevo Más Rarde";
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_construction_data") {
    if (isset($_POST["const_ID"])) {

        $response["login"]      =   true;
        $sql = 'SELECT CONSTRUCTION_ID, initcap(CONST_NAME) CONST_NAME, BUSINESS business FROM CONSTRUCTION WHERE CONSTRUCTION_ID = ' . $_POST["const_ID"];
        $retval     =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_row($retval);
            $response["error"]          =   false;
            $response["construction"]   =   $row;
            
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_business_data") {
    if (isset($_POST["const_ID"])) {

        $response["login"]      =   true;
        $sql = 'SELECT BUSINESS FROM WORKER_MST WHERE CONSTRUCTION_ID = ' . $_POST["const_ID"];
        $retval     =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_row($retval);
            $response["error"]          =   false;
            $response["business"]   =   $row;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_workers") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =   true;
        $sql = "SELECT W.WORKER_ID WORKER_ID, initcap(W.WORKER_RUT) WORKER_RUT FROM WORKER_MST W";
        $retval     =   mysqli_query($db_conn, $sql);
        $workers_list;
        if ($retval) {
            while ($row  =   mysqli_fetch_array($retval)) {
                $workers_list[]     =   $row;
            }

            $response["list_workers"]       =   $workers_list;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_worker_data") {
    if (isset($_POST["worker_ID"])) {
        $response["login"]      =   true;
        $sql = "SELECT WORKER_ID, initcap(WORKER_NAME) WORKER_NAME, initcap(POST) POST, PROFILE_IMG FROM WORKER_MST WHERE WORKER_ID = " . $_POST["worker_ID"];
        $retval     =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                            =   mysqli_fetch_array($retval);
            $response["worker"]             =   $row;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "register-worker") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =       true;
        $sql                    =       'SELECT COALESCE(MAX(WORKER_ID) , 0) + 1 FROM WORKER_MST';
        $retval                 =        mysqli_query($db_conn, $sql);
        $worker_ID              =        mysqli_fetch_row($retval)[0];
        $total_files            =        count($_FILES["worker_files"]["name"]);
        $profile_name;

        if (isset($worker_ID)    && $worker_ID != "") {
            if (isset($_FILES["worker_files"])) {
                $response["status"]     =   true;
                $directory      =       "../requests/uploads/workers/" . $worker_ID . "/";
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                for ($i = 0; $i < $total_files; $i++) {
                    $file_name      =   $_FILES["worker_files"]["name"][$i];
                    if (!move_uploaded_file($_FILES["worker_files"]["tmp_name"][$i], $directory . $file_name)) {
                        $response["status"]     =   false;
                    } else {
                        $sql        =       'INSERT INTO WORKER_DET(WORKER_ID, DOC_NAME) VALUES(' . $worker_ID . ', "' . $file_name . '")';
                        $retval     =        mysqli_query($db_conn, $sql);
                    }
                }
                $profile_name       =   $_FILES["profile_photo"]["name"];
                move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $directory . $profile_name);
            }
            if ($response["status"]  == true) {

                $sql    =   "INSERT INTO WORKER_MST (WORKER_ID, CONSTRUCTION_ID, WORKER_RUT, WORKER_NAME, WORKER_LNAME, MOTHER_NAME, GENDER, EMAIL, FORECAST, REGION, COMMUNE, DT_OF_BIRTH, WORKER_TEL, AFP, EMERGENCY_CONTACT_NAME, RELATION, EMERGENCY_TEL, START_DATE, CONTRACT_TYP, WORKER_CONDITION, POST, ENT_DATE, ADDRESS, PROFILE_IMG)
                                               VALUES(" . $worker_ID . ", " . $_POST["construction"] . ", '" . $_POST["rut"] . "', '" . $_POST["name_worker"] . "', '" . $_POST["lastname_worker"] . "', '" . $_POST["worker_mother"] . "', '" . $_POST["gender"] . "', '" . $_POST["email"] . "', '" . $_POST["forecast"] . "', '" . $_POST["region"] . "', '" . $_POST["commune"] . "',  '" . $_POST["birth_date"] . "',  '" . $_POST["telephone"] . "', '" . $_POST["afp"] . "','" . $_POST["name"] . "' , '" . $_POST["relation"] . "', '" . $_POST["emergency_phone"] . "', '" . $_POST["start_date"] . "', '" . $_POST["contract_typ"] . "', '" . $_POST["condition"] . "', '" . $_POST["post"] . "', NOW(),  '" . $_POST["address"] . "', '" . $profile_name . "')";
                $stmt   =   mysqli_query($db_conn, $sql);
                if ($stmt) {
                    $response["status"]     =   true;
                }
                if (!$stmt) {
                    $response["status"]     =   false;
                }
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "obra_fine") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =       true;
        $sql                    =       'SELECT COALESCE(MAX(FINE_ID) , 0) + 1 FROM FINES_OBRA';
        $retval                 =        mysqli_query($db_conn, $sql);
        $fine_ID                =        mysqli_fetch_row($retval)[0];
        $total_files            =        count($_FILES["documents"]["name"]);
        $profile_name;

        if (isset($fine_ID)    && ($fine_ID != "")) {
            if (isset($_FILES["documents"])) {
                $response["status"]     =   true;
                $directory      =       "../requests/uploads/obra-fines/" . $fine_ID . "/";
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                for ($i = 0; $i < $total_files; $i++) {
                    $file_name      =   $_FILES["documents"]["name"][$i];
                    if (!move_uploaded_file($_FILES["documents"]["tmp_name"][$i], $directory . $file_name)) {
                        $response["status"]     =   false;
                    } else {
                        $sql        =       'INSERT INTO FINE_OBRA_DOCS(FINE_ID, DOCUMENT_NAME) VALUES(' . $fine_ID . ', "' . $file_name . '")';
                        $retval     =        mysqli_query($db_conn, $sql);
                    }
                }
            }
            if ($response["status"]  == true) {

                $sql    =   "INSERT INTO FINES_OBRA (FINE_ID, DEPARTURE, FINE_TYPE, FINE_DESC, FINE_ENTER_BY, ENT_DATE, CONSTRUCTION_ID) VALUES(" . $fine_ID . ", '" . $_POST["departure"] . "', '" . $_POST["fine_type"] . "', '" . $_POST["observation"] . "', " . $_SESSION["USER_ID"] . ", NOW(), " . $_POST["construction"] . ")";
                $stmt   =   mysqli_query($db_conn, $sql);
                if ($stmt) {
                    $response["status"]     =   true;
                }
                if (!$stmt) {
                    $response["status"]     =   false;
                }
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "worker-fine") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =        true;
        $sql                    =       'SELECT COALESCE(MAX(FINE_ID) , 0) + 1 FROM WORKER_FINES';
        $retval                 =        mysqli_query($db_conn, $sql);
        $fine_ID                =        mysqli_fetch_row($retval)[0];
        $total_files            =        count($_FILES["documents"]["name"]);

        if (isset($fine_ID)    && ($fine_ID != "")) {
            if (isset($_FILES["documents"])) {
                $response["status"]     =   true;
                $directory      =       "../requests/uploads/fines_worker/" . $fine_ID . "/";
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                for ($i = 0; $i < $total_files; $i++) {
                    $file_name      =   $_FILES["documents"]["name"][$i];
                    if (!move_uploaded_file($_FILES["documents"]["tmp_name"][$i], $directory . $file_name)) {
                        $response["status"]     =   false;
                    } else {
                        $sql        =       'INSERT INTO WORKER_FINE_DET(FINE_ID, DOCUMENT_NAME) VALUES(' . $fine_ID . ', "' . $file_name . '")';
                        $retval     =        mysqli_query($db_conn, $sql);
                    }
                }
            }
            if ($response["status"]  == true) {

                $sql    =   "INSERT INTO WORKER_FINES(FINE_ID, FINE_DATE, PLACE, FINE_TIME, REASON, APPROVAL_STATUS, FINE_BY, ENT_DATE, WORKER_ID) VALUES(" . $fine_ID . ", '" . $_POST["date"] . "', '" . $_POST["place"] . "', '" . $_POST["time"] . "', '" . $_POST["reason"] . "', 'N', " . $_SESSION["USER_ID"] . ", NOW(), " . $_POST["rut"] . ")";
                $stmt   =   mysqli_query($db_conn, $sql);
                if ($stmt) {
                    $response["status"]     =   true;
                }
                if (!$stmt) {
                    $response["status"]     =   false;
                }
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_constructions_list") {
    $sql            =   "SELECT C.CONSTRUCTION_ID ID, INITCAP(C.CONST_NAME) AS CONST_NAME, INITCAP(C.BUSINESS) BUS_NAME, INITCAP(C.BUS_CONDITION) AS BUS_CONDITION, INITCAP(C.QTY) AS AMOUNT, S.CONSTRUCTION_ID, S.STAGE_ID, S.STAGE_STATUS, C.START_DT AS ST_DATE, S.STAGE_PERCENTAGE AS PERC, S.STAGE_NOTE AS NOTE FROM CONSTRUCTION C, construction_stage S WHERE C.CONSTRUCTION_ID = S.CONSTRUCTION_ID ORDER BY 1";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $constructions;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $r["ID"]                    =       $row["ID"];
        $r["CONST_NAME"]            =       $row["CONST_NAME"];
        $r["BUS_NAME"]              =       $row["BUS_NAME"];
        $r["BUS_CONDITION"]         =       $row["BUS_CONDITION"];
        $r["AMOUNT"]                =       $row["AMOUNT"];
        $r["NOTE"]                  =       $row["NOTE"];
        $r["STAGE_STATUS"]          =       $row["STAGE_STATUS"];
        $r["PERC"]                  =       $row["PERC"];
        $constructions[]            =       $r;
    }
    $response["data"] = $constructions;
    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_workers_list") {
    $sql            =   "SELECT F.FINE_ID ID, initcap(M.WORKER_RUT) RUT,  initcap(M.WORKER_NAME) WNAME, initcap(M.WORKER_LNAME) LNAME, F.FINE_DATE DT, F.FINE_TIME TM  
                         FROM WORKER_FINES F, WORKER_MST M 
                         WHERE m.WORKER_ID   = F.WORKER_ID 
                         ORDER BY 1";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $workers;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $r["ID"]                    =       $row["ID"];
        $r["RUT"]                   =       $row["RUT"];
        $r["WNAME"]                 =       $row["WNAME"];
        $r["LNAME"]                 =       $row["LNAME"];
        $r["DATE"]                  =       $row["DT"];
        $r["TIME"]                  =       $row["TM"];
        $workers[]                  =       $r;
    }
    $response["data"] = $workers;
    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "obra_docs") {
    if (isset($_POST["construction_ID"])) {
        $response["login"]      =        true;
        $construction_ID        =        $_POST["construction_ID"];

        if (isset($construction_ID)    && ($construction_ID != "")) {
            if (isset($_FILES["documents"])) {
                $response["status"]     =   true;
                $directory      =       "../requests/uploads/obra_uploads/" . $construction_ID . "/";
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                $file_name      =   $_POST["filename"];
                if (file_exists($directory . $file_name)) {
                    $response["status"] = false;
                    $response["error_msg"] = "El archivo con este nombre ya existe, cambie el nombre";
                }

                if ($response["status"] == true) {
                    if (!move_uploaded_file($_FILES["documents"]["tmp_name"], $directory . $file_name)) {
                        $response["status"]     =   false;
                    } else {
                        $sql        =       'INSERT INTO OBRA_DOCUMENTS(OBRA_ID, FILE_NAME) VALUES(' . $construction_ID . ', "' . $file_name . '")';
                        $retval     =        mysqli_query($db_conn, $sql);
                    }
                }
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_obra_data") {
    if (isset($_POST["Id"])) {

        $Id        =        $_POST["Id"];

        if (isset($Id)    && ($Id != "")) {
            $sql            =   "SELECT CONSTRUCTION_ID ID , initcap(CONST_NAME) OBRA, COORDINATES, initcap(ADDRESS) ADDRESS, initcap(BUSINESS) BUSINESS, initcap(BUS_CONDITION) BUS_CONDITION, QTY, DATE_FORMAT(START_DT, '%d/%m/%Y') START_DT, DATE_FORMAT(END_DT, '%d/%m/%Y') END_DT, SIGNED_STATUS  FROM CONSTRUCTION  WHERE CONSTRUCTION_ID = " . $Id;
            $result         =   mysqli_query($db_conn,  $sql);
            $count          =   mysqli_num_rows($result);
            $construction   =   mysqli_fetch_array($result);
            $query_files    =   "SELECT FILE_NAME FROM OBRA_DOCUMENTS WHERE OBRA_ID = " . $Id;
            $stmt           =   mysqli_query($db_conn,  $query_files);
            $files;
            while ($row  =   mysqli_fetch_array($stmt)) {
                $f["FILE_NAME"] = $row["FILE_NAME"];
                $f["FILE_PATH"] = "../requests/uploads/obra_uploads/" . $construction["ID"] . "/" . $row["FILE_NAME"];
                $files[]        =   $f;
            }
            $construction["FILES"]  =   $files;
            $response["construction"] = $construction;
            $sql                =   "SELECT D.DOC_ID DOC_ID, initcap(D.DOC_NAME) DOC_NAME FROM DOCS_TABLE D WHERE D.CONST_ID =".$Id;
            $st                 =   mysqli_query($db_conn,  $sql);
            $count_docs         =   mysqli_num_rows($st);
            if ($count_docs > 0) {
                $sp_docs;
                while ($r  =   mysqli_fetch_array($st)) {
                    $sp_docs[] = $r;
                }
                $response["construction"]["sp_files"] = $sp_docs;
            }
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "delete_document") {

    if (isset($_POST["construction_ID"]) && isset($_POST["document_ID"])) {
        if (isset($_SESSION["USER_ID"])) {
            $response["login"]       =        true;
            $response["status"]      =        false;
            $sql            =   "SELECT * FROM OBRA_DOCUMENTS WHERE OBRA_ID = " . $_POST["construction_ID"] . " AND ID =" . $_POST["document_ID"];
            $result         =   mysqli_query($db_conn,  $sql);
            $row            =   mysqli_fetch_array($result);
            $directory      =   "../requests/uploads/obra_uploads/" . $row["OBRA_ID"] . "/" . $row["FILE_NAME"];
            if (!file_exists($directory)) {
                if (mkdir($directory, 0777, false)) {
                    // $response["status"]      =        false;
                }
            } else {
                unlink($directory);
                $sql            =   "DELETE FROM OBRA_DOCUMENTS WHERE OBRA_ID = " . $_POST["construction_ID"] . " AND ID =" . $_POST["document_ID"];
                $result         =   mysqli_query($db_conn,  $sql);
                $response["status"]      =        true;
            }
        } else {
            $response["login"]       =        false;
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "add-comment") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =       true;
        $response["status"]     =       true;
        $total_files            =       count($_FILES["files"]["name"]);
        if (isset($_FILES["files"])) {
            $sql            =       'INSERT INTO COM_DOCS_MST(COMMENT_DESC, COMMENT_BY, ENT_DATE) VALUES("' . $_POST["comment"] . '", ' . $_SESSION["USER_ID"] . ', NOW())';
            $retval         =        mysqli_query($db_conn, $sql);
            $comment_ID     =        mysqli_insert_id($db_conn);
            if ($retval) {
                $directory      =       "../requests/uploads/comments/" . $comment_ID . "/";
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
            }
            for ($i = 0; $i < $total_files; $i++) {
                $file_name      =       $_FILES["files"]["name"][$i];
                $sql            =       'INSERT INTO COM_DOCS_DET(COMMENT_ID, FILE_NAME) VALUES(' . $comment_ID . ', "' . $file_name . '")';
                $retval         =        mysqli_query($db_conn, $sql);
                if (!$retval) {
                    $response["status"]         =   false;
                    $response["error_files"][]  =   $file_name;
                } else {
                    if (!move_uploaded_file($_FILES["files"]["tmp_name"][$i], $directory . $file_name)) {
                        $response["status"]     =   false;
                    }
                }
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_all_comments") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =   true;
        $response["status"]     =   false;
        $sql_query              =   "SELECT M.COMMENT_ID COMMENT_ID, M.COMMENT_DESC COMMENT_DESC, U.NAME NAM, U.DESIGNATION DESIGNATION, M.COMMENT_BY COMMENT_BY, M.ENT_DATE ENT_DATE     FROM COM_DOCS_MST M, USERS U
                                    WHERE M.COMMENT_BY = U.USER_ID ";
        $retval                 =   mysqli_query($db_conn,  $sql_query);
        $list_comments = array();
        if ($retval) {
            while ($row =  mysqli_fetch_array($retval)) {
                $comment["C_ID"]        =       $row["COMMENT_ID"];
                $comment["C_DESC"]      =       $row["COMMENT_DESC"];
                $comment["C_BY"]        =       $row["COMMENT_BY"];
                $comment["C_ENT"]       =       date("d M Y H:i", strtotime($row["ENT_DATE"]));
                $comment["NAME"]        =       $row["NAM"];
                $comment["DESIGNATION"] =       $row["DESIGNATION"];
                $sql                    =       "SELECT * FROM COM_DOCS_DET WHERE COMMENT_ID =" . $comment["C_ID"];
                $result                 =       mysqli_query($db_conn,  $sql);
                $files;
                while ($det = mysqli_fetch_array($result)) {
                    $r["FILE_LINK"]     =   "../requests/uploads/comments/" . $det["COMMENT_ID"] . "/" . $det["FILE_NAME"];
                    $r["FILE_NAME"]     =   $det["FILE_NAME"];
                    $files[]            =   $r;
                }
                $comment["C_ATTACHMENTS"]   =   $files;
                $files = array();
                $response["status"]     =       true;
                $list_comments[]        =       $comment;
            }
            if ($list_comments) {
                $response["data"] = $list_comments;
            }
        }
    } else {
        $response["login"]      =   false;
    }
    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "update-construction") {
    if (isset($_SESSION["USER_ID"])) {

        $response["login"]      =   true;
        $sql                    =   'SELECT * FROM CONSTRUCTION WHERE CONSTRUCTION_ID =' . $_POST["construction_ID"];
        $retval                 =   mysqli_query($db_conn, $sql);
        $construction           =   mysqli_fetch_array($retval);
        $sql                    =   'UPDATE CONSTRUCTION SET CONST_NAME = UPPER("' . $_POST["construction"] . '"), COORDINATES = "' . $_POST["coordinates"] . '" , ADDRESS =  UPPER("' . $_POST["address"] . '"), BUSINESS = UPPER("' . $_POST["business"] . '"),  BUS_CONDITION = UPPER("' . $_POST["business_condition"] . '"), QTY = ' . $_POST["amount"] . ',  START_DT = "' . $_POST["start_date"] . '",  END_DT = "' . $_POST["end_date"] . '" WHERE CONSTRUCTION_ID =' . $_POST["construction_ID"];
        $retval                 =   mysqli_query($db_conn, $sql);
        $const_ID               =   $_POST["construction_ID"];
        if ($retval) {
            $response["error"]      =   false;
            if (isset($_FILES['img_obra'])) {
                $errors             =       array();
                $file_name          =       $_FILES['img_obra']['name'];
                $file_size          =       $_FILES['img_obra']['size'];
                $file_tmp           =       $_FILES['img_obra']['tmp_name'];
                $file_type          =       $_FILES['img_obra']['type'];
                $tmp                =       explode('.', $_FILES['img_obra']['name']);
                $file_ext           =       end($tmp);
                if ($file_size > 2097152) {
                    $response["error"]          =   true;
                    $response["error_msg"]      =   "El Tamaño Del Archivo Debe Ser Inferior a 2 Mb";
                }
                if ($response["error"] == false) {
                    $img_name = $const_ID . "." . $file_ext;
                    if (file_exists("../requests/uploads/constructions/" . $construction["IMG_NAME"])) {
                        unlink("../requests/uploads/constructions/" . $construction["IMG_NAME"]);
                    }
                    if (move_uploaded_file($file_tmp, "../requests/uploads/constructions/" . $img_name)) {
                        $sql        =   'UPDATE CONSTRUCTION SET IMG_NAME = "' . $img_name . '" WHERE CONSTRUCTION_ID = ' . $const_ID . '';
                        $stmt = mysqli_query($db_conn, $sql);
                        if (!$stmt) {
                            $response["error"]          =   true;
                            $response["error_msg"]      =   "Ha ocurrido Un error. Por Favor, Inténtelo De Nuevo Más Rarde";
                        }
                    } else {
                        $response["error"]          =   true;
                        $response["error_msg"]      =   "Ha ocurrido Un error. Por Favor, Inténtelo De Nuevo Más Rarde";
                    }
                }
            }
        } else {
            $response["error"]      =   true;
            $response["error"]      =   "Ha ocurrido Un error. Por Favor, Inténtelo De Nuevo Más Rarde";
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}

if (isset($_POST["action"]) && $_POST["action"] == "get_all_workers") {
    $sql            =   "SELECT W.WORKER_ID ID, initcap(W.WORKER_RUT) RUT, initcap(W.WORKER_NAME) NAM, initcap(W.WORKER_LNAME) LASTNAME, initcap(C.BUSINESS) BUSINESS, initcap(W.COMMUNE ) COMMUNE, initcap(W.POST) POST, W.START_DATE  START_DT, W.WORKER_CONDITION  AS WORKER_STATUS FROM WORKER_MST W, CONSTRUCTION C WHERE W.CONSTRUCTION_ID = C.CONSTRUCTION_ID ORDER BY W.WORKER_ID";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $workers;
    while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $workers[]            =       $row;
    }
    $response["data"] = $workers;
    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_worker_by_id") {
    if (isset($_POST["worker_ID"])) {

        $response["login"]      =   true;
        $sql                    =   'SELECT W.WORKER_ID, W.CONSTRUCTION_ID, C.BUSINESS, initcap(WORKER_RUT) RUT, initcap(WORKER_NAME) NAM, initcap(WORKER_LNAME) LAST_NAME, initcap(MOTHER_NAME) MOTHER_NAME, GENDER, initcap(EMAIL) EMAIL, initcap(FORECAST) FORECAST, initcap(COMMUNE) COMMUNE, DT_OF_BIRTH DATE_OF_BIRTH, WORKER_TEL, initcap(AFP) AFP, initcap(EMERGENCY_CONTACT_NAME) EMERGENCY_CONTACT_NAME, initcap(RELATION) RELATION, EMERGENCY_TEL, START_DATE ST_DATE, initcap(CONTRACT_TYP) CONTRACT_TYPE, WORKER_CONDITION, initcap(POST) POST, W.ADDRESS, initcap(REGION) REGION, EMERGENCY_TEL E_TEL, CASE WHEN PROFILE_IMG = "" THEN "dist/img/avatar5.png" ELSE PROFILE_IMG END AS PROFILE_IMG FROM WORKER_MST W, CONSTRUCTION C  WHERE W.CONSTRUCTION_ID = C.CONSTRUCTION_ID AND WORKER_ID = ' . $_POST["worker_ID"];
        $retval                 =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_array($retval);
            $response["error"]          =   false;
            $response["worker"]         =   $row;
            $get_docs                   =   'SELECT DOC_ID AS FILE_ID, WORKER_ID AS WORKER_ID, DOC_NAME AS FILE_NAME FROM WORKER_DET WHERE WORKER_ID =  ' . $_POST["worker_ID"];
            $stmt                       =   mysqli_query($db_conn, $get_docs);
            $files_count                =   mysqli_num_rows($stmt);
            if ($files_count != 0) {
                $worker_files;
                while ($row =   mysqli_fetch_array($stmt)) {
                    $file["FILE_ID"]        =       $row["FILE_ID"];
                    $file["WORKER_ID"]      =       $row["WORKER_ID"];
                    
                    $file["FILE_NAME"]      =       $row["FILE_NAME"];
                    $file["FILE_PATH"]      =       "uploads/workers/" . $_POST["worker_ID"] . "/" . $row["FILE_NAME"];
                    $worker_files[]         =       $file;
                }
                $response["worker"]["WORKER_FILES"]     =   $worker_files;
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "delete-file-worker") {

    if (isset($_POST["FILE_ID"]) && $_POST["FILE_ID"] != "") {
        if (isset($_SESSION["USER_ID"])) {
            $response["login"]       =        true;
            $response["status"]      =        false;
            $query_file              =        'SELECT * FROM WORKER_DET WHERE WORKER_ID = ' . $_POST["WORKER_ID"] . ' AND DOC_ID = ' . $_POST["FILE_ID"];
            $stmt                    =        mysqli_query($db_conn, $query_file);
            $file                    =        mysqli_fetch_array($stmt);
            $sql                     =        "DELETE FROM WORKER_DET WHERE WORKER_ID = " . $file["WORKER_ID"] . " AND DOC_ID =" . $file["DOC_ID"];
            $result                  =        mysqli_query($db_conn,  $sql);
            $directory               =        "../requests/uploads/workers/" . $file["WORKER_ID"] . "/" . $file["DOC_NAME"];
            if (!file_exists($directory)) {
                if (mkdir($directory, 0777, false)) {
                    $response["status"]      =        true;
                }
            } else {
                unlink($directory);
                $response["status"]      =        true;
            }
        } else {
            $response["login"]       =        false;
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "update-worker") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =       true;
        $response["status"]     =       true;
        if (isset($_FILES["worker_files"]) && $_FILES["worker_files"]["name"] != "") {
            $total_files            =       count($_FILES["worker_files"]["name"]);
        }
        $profile_name;
        if (isset($_POST["worker_ID"])    && $_POST["worker_ID"] != "") {
            if (isset($_FILES["worker_files"])  && $_FILES["worker_files"]["name"] != "") {
                $directory      =       "../requests/uploads/workers/" . $_POST["worker_ID"] . "/";
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }
                for ($i = 0; $i < $total_files; $i++) {
                    $file_name      =   $_FILES["worker_files"]["name"][$i];
                    if (!move_uploaded_file($_FILES["worker_files"]["tmp_name"][$i], $directory . $file_name)) {
                        $response["status"]     =   false;
                    } else {
                        $sql        =       'INSERT INTO WORKER_DET(WORKER_ID, DOC_NAME) VALUES(' . $_POST["worker_ID"] . ', "' . $file_name . '")';
                        $retval     =        mysqli_query($db_conn, $sql);
                    }
                }
            }
            if (isset($_FILES["profile_photo"]) && $_FILES["profile_photo"]["name"] != "") {
                $profile_name       =   $_FILES["profile_photo"]["name"];
                move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $directory . $profile_name);
                $sql    =   "UPDATE  WORKER_MST SET  PROFILE_IMG = '" . $profile_name . "' WHERE WORKER_ID =  " . $_POST["worker_ID"];
                $stmt   =   mysqli_query($db_conn, $sql);
            }
            if ($response["status"]  == true) {

                $sql    =   "UPDATE  WORKER_MST SET CONSTRUCTION_ID = " . $_POST["construction"] . ", WORKER_RUT = '" . $_POST["rut"] . "', WORKER_NAME = '" . $_POST["name_worker"] . "', WORKER_LNAME = '" . $_POST["lastname_worker"] . "', MOTHER_NAME = '" . $_POST["worker_mother"] . "', GENDER = '" . $_POST["gender"] . "', EMAIL = '" . $_POST["email"] . "', FORECAST = '" . $_POST["forecast"] . "', REGION = '" . $_POST["region"] . "', COMMUNE = '" . $_POST["commune"] . "', DT_OF_BIRTH = '" . $_POST["birth_date"] . "', WORKER_TEL = '" . $_POST["telephone"] . "', AFP = '" . $_POST["afp"] . "', EMERGENCY_CONTACT_NAME = '" . $_POST["name"] . "', RELATION = '" . $_POST["relation"] . "', EMERGENCY_TEL = '" . $_POST["emergency_phone"] . "', START_DATE = '" . $_POST["start_date"] . "', CONTRACT_TYP = '" . $_POST["contract_typ"] . "', WORKER_CONDITION = '" . $_POST["condition"] . "', POST = '" . $_POST["post"] . "', ADDRESS = '" . $_POST["address"] . "'  WHERE WORKER_ID =" . $_POST["worker_ID"];
                $stmt   =   mysqli_query($db_conn, $sql);
                if ($stmt) {
                    $response["status"]     =   true;
                }
                if (!$stmt) {
                    $response["status"]     =   false;
                }
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_fines_obra") {
    $sql            =   "SELECT C.CONSTRUCTION_ID CONST_ID, initcap(C.CONST_NAME) NAME,  F.FINE_ID FINE_ID,  initcap(F.DEPARTURE) PARTIDA, initcap(F.FINE_TYPE) TIPO_MULTA, DATE_FORMAT(F.ENT_DATE, '%d/%m/%Y') FECHA  FROM FINES_OBRA F, CONSTRUCTION C WHERE F.CONSTRUCTION_ID = C.CONSTRUCTION_ID AND C.CONSTRUCTION_ID = ".$_POST["construction_ID"];
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    if($count > 0)
    {
        $fines;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) 
        {
            $fines[]   =       $row;
        }
        $response["data"]   =   $fines;
    }
    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_fine_by_id") {
    if (isset($_POST["fine_ID"]) && isset($_SESSION["USER_ID"])) {

        $response["login"]      =   true;
        $response["status"]     =   true;
        $sql                    =   'SELECT initcap(DEPARTURE) PARTIDA, FINE_TYPE TIPO_MULTA,  FINE_DESC  REASON, CONSTRUCTION_ID FROM FINES_OBRA WHERE FINE_ID =  ' . $_POST["fine_ID"];
        $retval                 =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_array($retval);
            $response["error"]          =   false;
            $response["FINE"]           =   $row;
            $get_docs                   =   'SELECT ID AS FILE_ID, FINE_ID AS FINE_ID, DOCUMENT_NAME AS FILE_NAME FROM FINE_OBRA_DOCS WHERE FINE_ID =  ' . $_POST["fine_ID"];
            $stmt                       =   mysqli_query($db_conn, $get_docs);
            $files_count                =   mysqli_num_rows($stmt);
            if ($files_count != 0) {
                $fine_files;
                while ($row =   mysqli_fetch_array($stmt)) {
                    $file["FILE_ID"]        =       $row["FILE_ID"];
                    $file["FINE_ID"]        =       $row["FINE_ID"];
                    $file["FILE_NAME"]      =       $row["FILE_NAME"];
                    $file["FILE_PATH"]      =       "uploads/obra-fines/" . $_POST["fine_ID"] . "/" . $row["FILE_NAME"];
                    $fine_files[]           =       $file;
                }
                $response["FINE"]["FINE_FILES"]     =   $fine_files;
            }
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_construction_by_id") {
    if (isset($_POST["const_ID"])) {

        $response["login"]      =   true;
        $sql                    =   'SELECT C.CONSTRUCTION_ID ID, initcap(C.CONST_NAME) OBRA, C.COORDINATES CORDINATES, C.ADDRESS ADRESS, initcap(C.BUSINESS) BUS_NAME, initcap(C.BUS_CONDITION) BUS_CONDITION, C.QTY QTY, DATE_FORMAT(C.START_DT,"%d/%m/%Y") START_DT , DATE_FORMAT(C.END_DT,"%d/%m/%Y") END_DATE, CASE WHEN C.IMG_NAME IS NOT NULL THEN CONCAT("uploads/constructions/",C.IMG_NAME) ELSE "dist/img/default.jpg" END AS IMG_NAME FROM CONSTRUCTION C  WHERE C.CONSTRUCTION_ID =' . $_POST["const_ID"];
        $retval                 =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_array($retval);
            $response["error"]          =   false;
            $response["construction"]   =   $row;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "sign_obra") {
    if (isset($_POST["Id"])) {

        $folderPath = "../requests/uploads/constructions/signatures/";
        $image_parts = explode(";base64,", $_POST['signature']);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath . $_POST["Id"] . '.' . $image_type;
        $sql                    =   'UPDATE CONSTRUCTION SET SIGNED_STATUS = "Y" WHERE CONSTRUCTION_ID =' . $_POST["Id"];
        $retval                 =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $response["status"]         =   true;
            file_put_contents($file, $image_base64);
        }
        if (!$retval) {
            $response["status"]         =   false;
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_obra_docs") {
    $response["login"]      =        true;
    if (isset($_POST["construction_ID"])) {
        $response["login"]      =        true;
        $construction_ID        =        $_POST["construction_ID"];

        if (isset($construction_ID)    && ($construction_ID != "")) {
            $sql            =   "SELECT * FROM OBRA_DOCUMENTS WHERE OBRA_ID = " .$_POST["$construction_ID"] ;
            $result         =   mysqli_query($db_conn,  $sql);
            $count          =   mysqli_num_rows($result);
            if ($count > 0) {
                $files_list;
                while ($row  =   mysqli_fetch_array($result)) {
                    $files_list[] = $row;
                }
                $response["files"]  =   $files_list;
            }
            
            $query              =   "SELECT D.DOC_ID DOC_ID, initcap(D.DOC_NAME) DOC_NAME FROM DOCS_TABLE D WHERE D.CONST_ID =".$_POST["$construction_ID"];
            $stmt               =   mysqli_query($db_conn,  $query);
            $count_docs         =   mysqli_num_rows($stmt);
            if ($count_docs > 0) {
                $sp_docs;
                while ($r  =   mysqli_fetch_array($stmt)) {
                    $sp_docs[] = $r;
                }
                $response["sp_files"] = $sp_docs;
            }
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && ($_POST["action"] == "import-workers") && !empty($_FILES["workers_csv"]["name"])) {
    if (isset($_SESSION["USER_ID"]) && $_SESSION["USER_ID"] != "") {
        $response["login"] = true;
        $allowed_ext    =   array("csv");
        $temp           =   explode(".", $_FILES["workers_csv"]["name"]);
        $extension      =   end($temp);
        if (in_array($extension, $allowed_ext)) {
            $file_data  =   fopen($_FILES["workers_csv"]["tmp_name"], "r");
            fgetcsv($file_data);
            while ($row      =   fgetcsv($file_data)) {
                $obra_ID                =           $row[0];
                $rut                    =           $row[1];
                $name                   =           $row[2];
                $last_name              =           $row[3];
                $mother_name            =           $row[4];
                $gender                 =           $row[5];
                $email                  =           $row[6];
                $active_status          =           $row[7];
                $region                 =           $row[8];
                $communa                =           $row[9];
                $date_of_birth          =           $row[10];
                $temp                   =           explode("#", $row[11]);
                $tel                    =           end($temp);
                $address                =           $row[13];
                $e_contact_name         =           $row[14];
                $e_relation             =           $row[15];
                $temp                   =           explode("#", $row[16]);
                $e_tel                  =           end($temp);
                $start_dt               =           $row[17];
                $contract_typ           =           $row[18];
                $worker_condition       =           $row[19];
                $post                   =           $row[20];
                $forecast               =           $row[21];
                $afp                    =           $row[12];
                $sql                    =           'SELECT COALESCE(MAX(WORKER_ID) , 0) + 1 FROM WORKER_MST';
                $retval                 =           mysqli_query($db_conn, $sql);
                $worker_ID              =           mysqli_fetch_row($retval)[0];
                $sql                    =           "INSERT INTO WORKER_MST (WORKER_ID, CONSTRUCTION_ID, WORKER_RUT, WORKER_NAME, WORKER_LNAME, MOTHER_NAME, GENDER, EMAIL, FORECAST, REGION, COMMUNE, DT_OF_BIRTH, WORKER_TEL, AFP, EMERGENCY_CONTACT_NAME, RELATION, EMERGENCY_TEL, START_DATE, CONTRACT_TYP, WORKER_CONDITION, POST, ENT_DATE, ADDRESS)
                                                        VALUES(" . $worker_ID . ", " . $obra_ID . ", '" . $rut . "', '" . $name . "', '" . $last_name . "', '" . $mother_name . "', '" . $gender . "', '" . $email . "', '" . $forecast . "', '" . $region . "', '" . $communa . "',  '" . $date_of_birth . "',  '" . $tel . "', '" . $afp . "','" . $e_contact_name . "' , '" . $e_relation . "', '" . $e_tel . "', '" . $start_dt . "', '" . $contract_typ . "', '" . $worker_condition . "', '" . $post . "', NOW(),  '" . $address . "')";
                $stmt                   =           mysqli_query($db_conn, $sql);
                if (!$stmt) {
                    $response["status"]               =   false;
                    $response["failed_workers"][]     =   $rut;
                }
            }
        }
    } else {
        $response["login"] = false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_data_by_const_ID") {
    if (isset($_POST["const_ID"])) {

        $response["login"]      =   true;
        $sql = 'SELECT * FROM CONSTRUCTION WHERE CONSTRUCTION_ID = ' . $_POST["const_ID"];
        $retval     =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_array($retval);
            $response["error"]          =   false;
            $response["construction"]   =   $row;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_sp_doc") {
    if (isset($_POST["Id"]) && $_POST["Id"] != "") {

        $response["login"]      =   true;
        $sql = "SELECT D.DOC_ID ID, initcap(D.DOC_NAME) TITLE, DATE_FORMAT(D.ENT_DATE, '%d/%m/%Y') ENT_DT, D.ENT_TIME ENT_TIME, D.DESCRIPTION DESCRIP, initcap(C.CONST_NAME) CONST_NAME FROM DOCS_TABLE D, CONSTRUCTION C WHERE D.CONST_ID = C.CONSTRUCTION_ID AND D.DOC_ID = " . $_POST["Id"];
        $retval     =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_array($retval);
            $response["document"]       =   $row;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "delete_sp_Doc") {

    if (isset($_POST["document_ID"])) {
        if (isset($_SESSION["USER_ID"])) {

            $response["login"]       =        true;
            $response["status"]      =        false;
            $sql                     =        "DELETE FROM DOCS_TABLE WHERE DOC_ID  =" . $_POST["document_ID"];
            $result                  =         mysqli_query($db_conn,  $sql);
            if($result)
            {
                $response["status"]  = true;
            }
            if(!$result)
            {
                $response["status"]  = false;
            }
            
            
        } 
        else {
            $response["login"]       =        false;
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_fine_data") {

    if (isset($_POST["Id"])) {
        if (isset($_SESSION["USER_ID"])) {

            $response["login"]       =        true;
            $response["status"]      =        false;
            $sql                     =        "SELECT FB.FINE_ID FINE_ID, initcap(FB.DEPARTURE) PARTIDA, initcap(FB.FINE_TYPE) FINE_TYPE, initcap(FB.FINE_DESC) DESCRIP, initcap(C.CONST_NAME) CONST_NAME FROM FINES_OBRA FB, CONSTRUCTION C WHERE C.CONSTRUCTION_ID = FB.CONSTRUCTION_ID AND FB.FINE_ID = ".$_POST["Id"];
            $result                  =         mysqli_query($db_conn,  $sql);
            $count                   =         mysqli_num_rows($result);
            if($count > 0)
            {
                $response["status"]         =   true;
                $response["obra_fine"]      =   mysqli_fetch_array($result, MYSQLI_ASSOC);
                $sql                        =   "SELECT ID, FINE_ID, initcap(DOCUMENT_NAME) DOC_NAME FROM FINE_OBRA_DOCS WHERE FINE_ID  = ".$response["obra_fine"]["FINE_ID"];
                $result                     =   mysqli_query($db_conn,  $sql);
                $count                      =   mysqli_num_rows($result);
                if($count > 0)
                {
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
                        $response["obra_fine"]["DOCS"][]        =   $row;

                    }

                }

            }
            else
            {
                $response["status"]  = false;
            }
            
            
        } 
        else {
            $response["login"]       =        false;
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_worker_fine_data") {

    if (isset($_POST["Id"])) {
        if (isset($_SESSION["USER_ID"])) {

            $response["login"]       =        true;
            $response["status"]      =        false;
            $sql                     =         "SELECT F.FINE_ID FINE_ID, initcap(W.WORKER_NAME) WORKER_NAME, initcap(W.POST) POST, initcap(W.WORKER_RUT) WORKER_RUT, initcap(F.PLACE) LUGAR, F.REASON MOTIVO, DATE_FORMAT(F.FINE_DATE, '%d/%m/%Y') FECHA, F.FINE_TIME HORA 
                                                FROM WORKER_FINES F, WORKER_MST W
                                                WHERE F.WORKER_ID = W.WORKER_ID
                                                AND F.FINE_ID  = ".$_POST["Id"];
            $result                  =         mysqli_query($db_conn,  $sql);
            $count                   =         mysqli_num_rows($result);
            if($count > 0)
            {
                $response["status"]         =   true;
                $response["worker_fine"]    =   mysqli_fetch_array($result, MYSQLI_ASSOC);
                $sql                        =   "SELECT ID, FINE_ID, initcap(DOCUMENT_NAME) DOC_NAME FROM WORKER_FINE_DET WHERE FINE_ID  = ".$_POST["Id"];
                $result                     =   mysqli_query($db_conn,  $sql);
                $count                      =   mysqli_num_rows($result);
                if($count > 0)
                {
                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
                    {
                        $response["worker_fine"]["DOCS"][]        =   $row;

                    }

                }

            }
            else
            {
                $response["status"]  = false;
            }
            
            
        } 
        else {
            $response["login"]       =        false;
        }
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_obra_l") {
    if (isset($_POST["construction_ID"])) {
    $sql            =   "SELECT C.CONSTRUCTION_ID CONST_ID,  F.FINE_ID FINE_ID,  initcap(F.DEPARTURE) PARTIDA, initcap(F.FINE_TYPE) TIPO_MULTA, INITCAP(C.BUS_CONDITION) AS BUS_CONDITION, DATE_FORMAT(F.ENT_DATE, '%d/%m/%Y') FECHA  FROM FINES_OBRA F, CONSTRUCTION C WHERE F.CONSTRUCTION_ID = C.CONSTRUCTION_ID AND C.CONSTRUCTION_ID = ".$_POST["construction_ID"];
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    if($count > 0)
    {
        $obral;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $r["CONST_ID"]              =       $row["CONST_ID"];
        $r["PARTIDA"]               =       $row["PARTIDA"];
        $r["BUS_CONDITION"]         =       $row["BUS_CONDITION"];
        $obral[]                    =       $r;
        }
        $response["data"]   =   $obral;
        $response["login"]      =   true;
    }
    
        }else {
            $response["login"]      =   false;
        }
    
        echo (json_encode($response));
        
}

if (isset($_POST["action"]) && $_POST["action"] == "get_data_by_obra_ID") {
    if (isset($_POST["const_ID"])) {

        $response["login"]      =   true;
        $sql = 'SELECT * FROM CONSTRUCTION WHERE CONSTRUCTION_ID = ' . $_POST["const_ID"];
        $retval     =   mysqli_query($db_conn, $sql);
        if ($retval) {
            $row                        =   mysqli_fetch_array($retval);
            $response["error"]          =   false;
            $response["construction"]   =   $row;
        }
    } else {
        $response["login"]      =   false;
    }

    echo (json_encode($response));
}
if (isset($_POST["action"]) && $_POST["action"] == "get_obra_stage") {
    if (isset($_POST["construction_ID"])) {
    $sql            =   "SELECT c.CONSTRUCTION_ID AS CONST_ID, c.CONST_NAME AS NAME_C, c.SUPERVISOR, c.COORDINATES, c.ADDRESS, c.BUSINESS, c.BUS_CONDITION AS BUS_C, c.QTY, c.START_DT, c.END_DT, c.ENT_DATE, c.IMG_NAME, c.SIGNED_STATUS, s.ID, s.CONSTRUCTION_ID, s.STAGE_ID, s.STAGE_STATUS AS ST_STA, s.STAGE_NOTE AS NOTE FROM construction c, construction_stage s WHERE c.CONSTRUCTION_ID = s.CONSTRUCTION_ID AND c.CONSTRUCTION_ID = ".$_POST["construction_ID"];
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    if($count > 0)
    {
        $obralist;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $r["CONS_ID"]              =       $row["CONST_ID"];
        $r["CONS_NAME"]         =          $row["NAME_C"];
        $r["ESTADO"]                = $row["NOTE"];
        $r["ETAPA"]               =       $row["ST_STA"];
        $r["BUS_CONDITION"]         =       $row["BUS_C"];
        $obralist[]                    =       $r;
        }
        $response["data"]   =   $obralist;
        $response["login"]      =   true;
    }
    
        }else {
            $response["login"]      =   false;
        }
    
        echo (json_encode($response));
        
}
if (isset($_POST["action"]) && $_POST["action"] == "get_obra_stage_id") {
    if (isset($_POST["construction_ID"])) {
    $response["status"]     =   true;
    $response["login"]      =   true;
    $sql            =   "SELECT c.CONSTRUCTION_ID AS CONST_ID, c.CONST_NAME AS NAME_C, c.SUPERVISOR, c.COORDINATES, c.ADDRESS, c.BUSINESS, c.BUS_CONDITION AS BUS_C, c.QTY, c.START_DT AS ST_DT, c.END_DT AS ST_END, c.ENT_DATE, c.IMG_NAME, c.SIGNED_STATUS, s.ID, s.CONSTRUCTION_ID, s.STAGE_ID, s.STAGE_STATUS AS ST_STA, s.STAGE_NOTE AS NOTE FROM construction c, construction_stage s WHERE c.CONSTRUCTION_ID = s.CONSTRUCTION_ID AND c.CONSTRUCTION_ID = ".$_POST["construction_ID"];
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    if($count > 0)
    {
        $obralist;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $r["CONS_ID"]             =   $row["CONST_ID"];
        $r["CONS_NAME"]           =   $row["NAME_C"];
        $r["FECHA_I"]             =   $row["ST_DT"];
        $r["FECHA_E"]             =   $row["ST_END"];
        $r["ESTADO"]              =   $row["NOTE"];
        $r["ETAPA"]               =   $row["ST_STA"];
        $r["BUS_CONDITION"]       =   $row["BUS_C"];
        $obralist[]               =   $r;
        }
        $response["data"]   =   $obralist;
        
    }
    
        }else {
            $response["login"]      =   false;
        }
    
        echo (json_encode($response));
        
}
if (isset($_POST["action"]) && $_POST["action"] == "get_obra_documents") {
    if (isset($_POST["construction_ID"])) {
    $sql            =   "SELECT c.CONSTRUCTION_ID AS CONST_ID, c.CONST_NAME AS NAME_C, c.SUPERVISOR, c.COORDINATES, c.ADDRESS, c.BUSINESS, c.BUS_CONDITION AS BUS_C, c.QTY, c.START_DT AS FECHA_I, c.END_DT, c.ENT_DATE, c.IMG_NAME, c.SIGNED_STATUS, s.ID, s.CONSTRUCTION_ID, s.STAGE_ID, s.STAGE_STATUS AS ST_STA, s.STAGE_NOTE AS NOTE, o.DOC_ID, o.CONST_ID, o.DOC_NAME AS D_NAME FROM construction c, construction_stage s, docs_table o WHERE c.CONSTRUCTION_ID = s.CONSTRUCTION_ID AND c.CONSTRUCTION_ID = o.CONST_ID AND c.CONSTRUCTION_ID= ".$_POST["construction_ID"];
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    if($count > 0)
    {
        $obralist;
        while ($row =  mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $r["CONS_ID"]               = $row["CONST_ID"];
        $r["CONS_NAME"]             = $row["NAME_C"];
        $r["ESTADO"]                = $row["NOTE"];
        $r["ETAPA"]                 = $row["ST_STA"];
        $r["BUS_CONDITION"]         = $row["BUS_C"];
        $r["FECHA"]                 = $row["FECHA_I"];
        $r["DOC_NAME"]              = $row["D_NAME"];
        $obralist[]                 =       $r;
        }
        $response["data"]   =   $obralist;
        $response["login"]      =   true;
    }
    
        }else {
            $response["login"]      =   false;
        }
    
        echo (json_encode($response));

        
}

if (isset($_POST["action"]) && $_POST["action"] == "register-advance") {
    if (isset($_SESSION["USER_ID"])) {
        $response["login"]      =       true;
        $sql                    =       'SELECT COALESCE(MAX(stage_ID) , 0) + 1 FROM CONSTRUCTION_STAGE';
        $retval                 =        mysqli_query($db_conn, $sql);
        $stage_ID              =        mysqli_fetch_row($retval)[0];

        if (isset($stage_ID)    && $stage_ID != "") {
                $sql    =   "INSERT INTO CONSTRUCTION_STAGE (STAGE_ID, CONSTRUCTION_ID,  STAGE_STATUS, STAGE_NOTE, STAGE_PERCENTAGE)
                VALUES(" . $stage_ID . ", " . $_POST["construction"] . ", '" . $_POST["part"] . "', '" . $_POST["desc"] . "', '" . $_POST["porc"] . "')";
                $stmt   =   mysqli_query($db_conn, $sql);
                if ($stmt) {
                    $response["status"]     =   true;
                }
                if (!$stmt) {
                    $response["status"]     =   false;
                }
        }
    } else {
        $response["login"]      =   false;
    }
    echo (json_encode($response));
}


