<?php
function Material_STK($itmcode)
{
    include("db_connection.php");
    $sql            =   "SELECT RD.FK_RECEIPT_ID RECEIPT_ID,  RD.MATERIAL_ID ITMCODE, initcap(M.MAT_NAME) MATERIAL_NAME, RD.AMOUNT RECEIPT_QTY, M.UNIT_ID UNIT_CODE, initcap(U.UNIT_DESC) UNIT  FROM RECEIPT_DET_INV RD, MATERIALS M ,MAT_UNITS U WHERE RD.MATERIAL_ID = M.ITMCODE AND M.UNIT_ID = U.UNIT_ID AND RD.MATERIAL_ID = '" . $itmcode . "'  GROUP BY RD.MATERIAL_ID";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    $receipt_inv = array();
    if ($count > 0) {
        $receipt_inv        =   mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        $receipt_inv["RECEIPT_ID"]       =      0;
        $receipt_inv["MATERIAL_NAME"]    =      0;
        $receipt_inv["ITMCODE"]          =      0;
        $receipt_inv["UNIT_CODE"]        =      0;
        $receipt_inv["RECEIPT_QTY"]      =      0;
    }
    return $receipt_inv;
}

function Total_Material_Issued($itmcode)
{
    include("db_connection.php");
    $sql            =   "SELECT D.MATERIAL_ID ITMCODE, initcap(M.MAT_NAME) MATERIAL_NAME, D.AMOUNT ISSUED_QTY, initcap(U.UNIT_DESC) UNIT   FROM DELIVERY_DET D, MATERIALS M, MAT_UNITS U  WHERE D.MATERIAL_ID = M.ITMCODE AND M.UNIT_ID = U.UNIT_ID    AND D.MATERIAL_ID = '" . $itmcode . "' GROUP BY ITMCODE";
    $result         =   mysqli_query($db_conn,  $sql);
    $count          =   mysqli_num_rows($result);
    if ($count > 0) {
        $mat_issued;
        $mat_issued = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return $mat_issued;
    }
}

function GetUserRole($user_ID)
{
    include("db_connection.php");
    $role;
    $sql        =   "SELECT U.ROLE_ID, initcap(R.ROLE_DESCRIPTION) ROLE_DESCRIP FROM USERS U, USER_ROLES R WHERE U.ROLE_ID = R.ROLE_ID AND U.USER_ID = ".$user_ID;
    $stmt       =   mysqli_query($db_conn, $sql);
    if($stmt) 
    {
        $role   = mysqli_fetch_array($stmt);
    }
    return $role;
}
