-- Step 1: Create database
IF NOT EXISTS (SELECT name FROM sys.databases WHERE name = 'SurveyDB')
BEGIN
    CREATE DATABASE SurveyDB;
END;
GO

-- Step 2: Use the database
USE SurveyDB;
GO

-- Step 3: Drop old tables if already exist
IF OBJECT_ID('SurveyDetails', 'U') IS NOT NULL DROP TABLE SurveyDetails;
IF OBJECT_ID('SurveyMain', 'U') IS NOT NULL DROP TABLE SurveyMain;
IF OBJECT_ID('Designation', 'U') IS NOT NULL DROP TABLE Designation;
IF OBJECT_ID('AreaMaster', 'U') IS NOT NULL DROP TABLE AreaMaster;
IF OBJECT_ID('Material', 'U') IS NOT NULL DROP TABLE Material;
IF OBJECT_ID('State', 'U') IS NOT NULL DROP TABLE State;
IF OBJECT_ID('City', 'U') IS NOT NULL DROP TABLE City;
IF OBJECT_ID('Party', 'U') IS NOT NULL DROP TABLE Party;
GO

-- Step 4: Create master tables
CREATE TABLE Party (
    PartyID INT IDENTITY(1,1) PRIMARY KEY,
    PartyName NVARCHAR(100),
    PartyType NVARCHAR(50)
);

CREATE TABLE City (
    CityID INT IDENTITY(1,1) PRIMARY KEY,
    CityName NVARCHAR(100)
);

CREATE TABLE State (
    StateID INT IDENTITY(1,1) PRIMARY KEY,
    StateName NVARCHAR(100)
);

CREATE TABLE Designation (
    DesignationID INT IDENTITY(1,1) PRIMARY KEY,
    DesignationName NVARCHAR(100)
);

CREATE TABLE Material (
    MaterialID INT IDENTITY(1,1) PRIMARY KEY,
    MaterialName NVARCHAR(100)
);

CREATE TABLE AreaMaster (
    AreaID INT IDENTITY(1,1) PRIMARY KEY,
    AreaName NVARCHAR(100)
);

-- Step 5: Create transaction tables
CREATE TABLE SurveyMain (
    SurveyID INT IDENTITY(1,1) PRIMARY KEY,
    PartyID INT FOREIGN KEY REFERENCES Party(PartyID),
    SurveyDate DATE,
    CityID INT FOREIGN KEY REFERENCES City(CityID),
    StateID INT FOREIGN KEY REFERENCES State(StateID),
    DesignationID INT FOREIGN KEY REFERENCES Designation(DesignationID)
);

CREATE TABLE SurveyDetails (
    DetailID INT IDENTITY(1,1) PRIMARY KEY,
    SurveyID INT FOREIGN KEY REFERENCES SurveyMain(SurveyID),
    MaterialID INT FOREIGN KEY REFERENCES Material(MaterialID),
    AreaID INT FOREIGN KEY REFERENCES AreaMaster(AreaID),
    Rating INT CHECK (Rating BETWEEN 1 AND 5),
    Remarks NVARCHAR(255)
);
GO
SELECT * FROM SurveyMain;

