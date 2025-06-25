<?php
include 'db.php';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=rptcustsurveyregister_" . date('d-m-Y') . ".xls");

echo "<table border='1'>";
echo "<tr>
<th>Sr No</th>
<th>Party Name</th>
<th>Type</th>
<th>City</th>
<th>State</th>
<th>Designation</th>
<th>Material</th>
<th>Area</th>
<th>Rating</th>
<th>Remarks</th>
<th>Survey Date</th>
</tr>";

$query = "SELECT P.PartyName, P.PartyType, C.CityName, S.StateName,
                 D.DesignationName, M.MaterialName, A.AreaName, SD.Rating, SD.Remarks, SM.SurveyDate
          FROM SurveyMain SM
          JOIN Party P ON SM.PartyID = P.PartyID
          JOIN City C ON SM.CityID = C.CityID
          JOIN State S ON SM.StateID = S.StateID
          JOIN Designation D ON SM.DesignationID = D.DesignationID
          JOIN SurveyDetails SD ON SM.SurveyID = SD.SurveyID
          JOIN Material M ON SD.MaterialID = M.MaterialID
          JOIN AreaMaster A ON SD.AreaID = A.AreaID";

$stmt = sqlsrv_query($conn, $query);

$sr = 1;
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $date = $row['SurveyDate']->format('d-m-Y');
    echo "<tr>
        <td>{$sr}</td>
        <td>{$row['PartyName']}</td>
        <td>{$row['PartyType']}</td>
        <td>{$row['CityName']}</td>
        <td>{$row['StateName']}</td>
        <td>{$row['DesignationName']}</td>
        <td>{$row['MaterialName']}</td>
        <td>{$row['AreaName']}</td>
        <td>{$row['Rating']}</td>
        <td>{$row['Remarks']}</td>
        <td>{$date}</td>
    </tr>";
    $sr++;
}

echo "</table>";
?>
