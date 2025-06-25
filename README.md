# 📋 Survey Form Project (PHP + SQL Server)

This is a web-based **Survey Form System** developed using **HTML, CSS, PHP**, and **Microsoft SQL Server** as the backend database. It is designed to collect and store customer or supplier feedback and export survey data in Excel format.

---

## 🔧 Features

- 📝 Responsive HTML survey form for collecting data
- 🗂️ Stores survey data in Microsoft SQL Server (`SurveyDB`)
- 📊 Real-time report viewing with `report.php`
- 📤 Export collected data to `.xls` Excel file using `export_excel.php`
- 🎨 Beautiful CSS design via `style.css`
- ✅ Works with manual entry form as well as auto-load from DB

---

## 🛠️ Tech Stack

| Component    | Technology           |
|--------------|----------------------|
| Frontend     | HTML5, CSS3          |
| Backend      | PHP (v8.x recommended) |
| Database     | Microsoft SQL Server |
| Export Tool  | PHP Excel headers / PHPSpreadsheet (optional) |

---

## 📁 Project Structure

```
SurveyFormProject/
│
├── survey_form.php         # Survey Form UI
├── submit_form.php         # Form data handler & DB insert
├── report.php              # Displays submitted survey report
├── export_excel.php        # Exports survey report to Excel
├── db.php                  # SQL Server connection settings
├── style.css               # Form & table design
├── test_conn.php           # DB connection tester
├── SurveyDB_Refreshed.sql  # SQL script to create required tables
├── README.md               # Project description (this file)
└── vendor/                 # PHPSpreadsheet (if used via composer)
```

---

## 🧰 Setup Instructions

### 1. Database
- Open `SQL Server Management Studio (SSMS)`
- Run the script `SurveyDB_Refreshed.sql`
- It will create a database called `SurveyDB` with all required tables

### 2. Web Server
- Copy all files into `C:/xampp/htdocs/SurveyFormProject/`
- Start XAMPP Apache and SQL Server services

### 3. Configuration
- Edit `db.php` and add your SQL Server login:
```php
$serverName = "localhost\\SQLEXPRESS"; 
$connectionOptions = [
    "Database" => "SurveyDB",
    "Uid" => "sa",
    "PWD" => "your_password",
    "TrustServerCertificate" => true
];
```

---

## 🚀 How to Use

1. Open browser and go to:
   ```
   http://localhost/SurveyFormProject/survey_form.php
   ```

2. Fill the survey form and submit.

3. To view submitted responses:
   ```
   http://localhost/SurveyFormProject/report.php
   ```

4. To export to Excel:
   - Click on "⬇ Export to Excel" button on `report.php`
   - Or go to `export_excel.php` directly

---

## 📸 Screenshots

> Add screenshots if needed (form, report, Excel output)

---

## 📚 License

This project is for educational use. You are free to use, modify, and distribute it with attribution.

---

## 👩‍💻 Created By

**Rutika Guruprasad Kamalakar**  
`Third Year B.Tech – Computer Science & Engineering`  
Shivaji University, Kolhapur
