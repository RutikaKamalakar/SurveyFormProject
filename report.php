<?php
include 'db.php';

echo "<h2>📝 Survey Report</h2>";

// Filter Form
echo '
<form method="get" style="margin-bottom:20px;">
    Search by Party Name: 
    <input type="text" name="party" placeholder="e.g. Infosys">
    
    From Date:
    <input type="date" name="from_date">
    
    To Date:
    <input type="date" name="to_date">
    
    <input type="submit" value="Filter">
</form>
';

//  Filter logic
$where = [];

if (!empty($_GET['party'])) {
    $party = $_GET['party'];
    $where[] = "P.PartyName LIKE '%$party%'";
}

if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $from = $_GET['from_date'];
    $to = $_GET['to_date'];
    $where[] = "SM.SurveyDate BETWEEN '$from' AND '$to'";
}

$whereClause = "";
if (count($where) > 0) {
    $whereClause = "WHERE " . implode(" AND ", $where);
}

// Main query with filters
$query = "SELECT SM.SurveyID, P.PartyName, P.PartyType, C.CityName, S.StateName, 
                 D.DesignationName, M.MaterialName, A.AreaName, SD.Rating, SD.Remarks, SM.SurveyDate
          FROM SurveyMain SM
          JOIN Party P ON SM.PartyID = P.PartyID
          JOIN City C ON SM.CityID = C.CityID
          JOIN State S ON SM.StateID = S.StateID
          JOIN Designation D ON SM.DesignationID = D.DesignationID
          JOIN SurveyDetails SD ON SM.SurveyID = SD.SurveyID
          JOIN Material M ON SD.MaterialID = M.MaterialID
          JOIN AreaMaster A ON SD.AreaID = A.AreaID
          $whereClause";

$stmt = sqlsrv_query($conn, $query);

// Export to Excel Button
echo '
<a href="export_excel.php" style="text-decoration:none;">
    <button style="margin:10px;padding:10px;background-color:#4CAF50;color:white;border:none;border-radius:5px;">
        ⬇ Export to Excel
    </button>
</a>';

// Table headers
echo "<table border='1' cellpadding='8' cellspacing='0'>";
echo "<tr>
<th>SurveyID</th><th>Party Name</th><th>Type</th><th>City</th><th>State</th>
<th>Designation</th><th>Material</th><th>Area</th><th>Rating</th><th>Remarks</th><th>Date</th>
</tr>";

// Data Rows
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $date = $row['SurveyDate'] ? $row['SurveyDate']->format('Y-m-d') : '';
    echo "<tr>
        <td>{$row['SurveyID']}</td>
        <td>{$row['PartyName']}</td>
        <td>{$row['PartyType']}</td>
        <td>{$row['CityName']}</td>
        <td>{$row['StateName']}</td>
        <td>{$row['DesignationName']}</td>
        <td>{$row['MaterialName']}</td>
        <td>{$row['AreaName']}</td>
        <td>{$row['Rating']}</td>
        <td>{$row['Remarks']}</td>
        <td>$date</td>
    </tr>";
}
echo "</table>";
?>
