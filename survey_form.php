<!DOCTYPE html>
<html>
<head>
    <title>Customer Survey Form</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
<div class="form-container">
    <h2> Customer Survey Form</h2>
    <form action="submit_form.php" method="post">

        <label>Party Name:</label>
        <input type="text" name="party_name" required>

        <label>Party Type:</label>
        <input type="text" name="party_type" placeholder="Customer/Supplier" required>

        <label>City:</label>
        <input type="text" name="city" required>

        <label>State:</label>
        <input type="text" name="state" required>

        <label>Designation:</label>
        <input type="text" name="designation" required>

        <label>Material:</label>
        <input type="text" name="material" required>

        <label>Area:</label>
        <input type="text" name="area" required>

        <label>Rating (1–5):</label>
        <input type="number" name="rating" min="1" max="5" required>

        <label>Remarks:</label>
        <textarea name="remarks" rows="4"></textarea>

        <input type="submit" value="Submit Survey">
    </form>
</div>
</body>
</html>
