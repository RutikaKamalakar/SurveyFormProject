<?php
include 'db.php';

function get_or_insert_id($conn, $table, $column, $value) {
    // ID column mapping per table
    $idColumn = match($table) {
        'Party' => 'PartyID',
        'City' => 'CityID',
        'State' => 'StateID',
        'Material' => 'MaterialID',
        'AreaMaster' => 'AreaID',
        'Designation' => 'DesignationID',
        default => $table . 'ID'
    };

    // Check if value already exists
    $select = "SELECT {$idColumn} FROM $table WHERE $column = ?";
    $stmt = sqlsrv_query($conn, $select, array($value));

    if ($stmt === false) {
        die("❌ SELECT Error in $table: " . print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    if ($row) {
        return $row[$idColumn];
    } else {
        // Insert if not exists
        $insert = "INSERT INTO $table ($column) VALUES (?)";
        $stmt2 = sqlsrv_query($conn, $insert, array($value));
        if ($stmt2 === false) {
            die("❌ INSERT Error in $table: " . print_r(sqlsrv_errors(), true));
        }

        // Re-fetch ID
        $stmt3 = sqlsrv_query($conn, $select, array($value));
        $row2 = sqlsrv_fetch_array($stmt3, SQLSRV_FETCH_ASSOC);
        return $row2[$idColumn];
    }
}

// Get POST data safely
$partyName = $_POST['party_name'] ?? '';
$partyType = $_POST['party_type'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$designation = $_POST['designation'] ?? '';
$material = $_POST['material'] ?? '';
$area = $_POST['area'] ?? '';
$rating = $_POST['rating'] ?? '';
$remarks = $_POST['remarks'] ?? '';

//  Get or Insert into Master Tables
$partyID = get_or_insert_id($conn, "Party", "PartyName", $partyName);
sqlsrv_query($conn, "UPDATE Party SET PartyType = ? WHERE PartyID = ?", array($partyType, $partyID));

$cityID = get_or_insert_id($conn, "City", "CityName", $city);
$stateID = get_or_insert_id($conn, "State", "StateName", $state);
$designationID = get_or_insert_id($conn, "Designation", "DesignationName", $designation);
$materialID = get_or_insert_id($conn, "Material", "MaterialName", $material);
$areaID = get_or_insert_id($conn, "AreaMaster", "AreaName", $area);

//  Insert into SurveyMain
$surveyDate = date('Y-m-d');
$insertMain = "INSERT INTO SurveyMain (PartyID, SurveyDate, CityID, StateID, DesignationID)
               VALUES (?, ?, ?, ?, ?)";
$paramsMain = array($partyID, $surveyDate, $cityID, $stateID, $designationID);
$stmtMain = sqlsrv_query($conn, $insertMain, $paramsMain);

if ($stmtMain === false) {
    die("❌ SurveyMain Insert Error: " . print_r(sqlsrv_errors(), true));
}

//  Get last inserted SurveyID
$getID = sqlsrv_query($conn, "SELECT MAX(SurveyID) AS LastID FROM SurveyMain");
$rowSurvey = sqlsrv_fetch_array($getID, SQLSRV_FETCH_ASSOC);
$lastSurveyID = $rowSurvey['LastID'] ?? 0;

//  Insert into SurveyDetails
$insertDetails = "INSERT INTO SurveyDetails (SurveyID, MaterialID, AreaID, Rating, Remarks)
                  VALUES (?, ?, ?, ?, ?)";
$paramsDetails = array($lastSurveyID, $materialID, $areaID, $rating, $remarks);
$stmtDetails = sqlsrv_query($conn, $insertDetails, $paramsDetails);

if ($stmtDetails === false) {
    die("❌ SurveyDetails Insert Error: " . print_r(sqlsrv_errors(), true));
}

echo "<h3 style='color: green;'>✅ Survey submitted successfully!</h3>";
?>
