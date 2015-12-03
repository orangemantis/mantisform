<?php
require_once '../includes/config.php';
require_once '../includes/sillystring.class.php';
require_once '../includes/identity.class.php';

//Create random string gnerator
$sstring = new SillyString();

//Installs app user in MySQL
echo '<p>Setting up database...</p>';
$dbRoot ="root";
$dbRootPass = 'mantisorange';
$dbConString = 'mysql:host=' . $config['dbHost'] .';charset=' . $config['dbCharSet'];
$dbUserName = "'" . $config['dbUser'] . "'@'" . $config['dbHost'] . "'";

//Create db
$dbSetupStmt = "CREATE DATABASE IF NOT EXISTS " . $config['dbName'] . ";";
//create user
$dbSetupStmt .= "CREATE USER " . $dbUserName . " IDENTIFIED BY '" . $config['dbPassword'] . "';";
//Grant db permission to user
$dbSetupStmt .= "GRANT ALL ON " . $config['dbName'] . ".* TO " . $dbUserName . ";";

try{
	$db1 = new PDO($dbConString, $dbRoot, $dbRootPass);
	$db1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db1->exec($dbSetupStmt);

	echo '<p>Database setup went well.</p>';
}
catch(PDOException $error1){
	echo '<p>Uh-oh the database setup failed.<br/>';
	print_r($error1->getMessage());
	echo '</p>';
}

echo "<p>Setting up application...</p>";

//Setup user credentials
$salt = $sstring->getRandom();
$password = 'mantisorange' . $salt;
$password = identity::encrypt($password);

//Setup subscriber table
$subScriberTableStmt = 'CREATE TABLE IF NOT EXISTS subscribers
	(
				subscriber_id int NOT NULL AUTO_INCREMENT,
				first_name varchar(26),
				middle_initial varchar(26),
				last_name varchar(26),
				email varchar(255),
				mobile_phone varchar(30),
				home_phone varchar(30),
				address1 varchar(140),
				address2 varchar(140),
				city varchar(50),
				state int(3),
				zip_pc varchar(15),
				country int(3),
				notes varchar(255),
				subscribed tinyint(1),
				PRIMARY KEY(subscriber_id)
				
	);';
//Table set up in the event that I move the state list to the db
$stateTableStmt = 'CREATE TABLE IF NOT EXISTS states
	(
			state_id int NOT NULL AUTO_INCREMENT,
			state_abbrv varchar(2),
			state_name varchar(50),
			state_country int,
			PRIMARY KEY(state_id)
	);';
//Table set up in the event that I move the country list to the db
$countryTableStmt = 'CREATE TABLE IF NOT EXISTS countries
	(
			country_id int NOT NULL AUTO_INCREMENT,
			country_abbrv varchar(3),
			country_name varchar(50),
			PRIMARY KEY(country_id)
	);';

$settingsTableStmt = 'CREATE TABLE IF NOT EXISTS settings
	(
			campaign_id int NOT NULL AUTO_INCREMENT,
			campaign_name varchar(50),
			campaign_date DATE,
			campaign_location varchar(50),
			campaign_contact varchar(30),
			campaign_email varchar(255),
			campaign_phone varchar(30),
			campaign_message varchar(140),
			campaign_terms text,
			campaign_note text,
			campaign_brand varchar(50),
			layout_signup int DEFAULT 1,
			PRIMARY KEY(campaign_id)
	);';


$insertStatesStmt = "INSERT INTO states (state_abbrv, state_name, state_country) VALUES 
('AL', 'Alabama', '1'),
('AK', 'Alaska', '1'),
('AZ', 'Arizona', '1'),
('AR', 'Arkansas', '1'),
('CA', 'California', '1'),
('CO', 'Colorado', '1'),
('CT', 'Connecticut', '1'),
('DE', 'Delaware', '1'),
('FL', 'Florida', '1'),
('GA', 'Georgia', '1'),
('HI', 'Hawaii', '1'),
('ID', 'Idaho', '1'),
('IL', 'Illinois', '1'),
('IN', 'Indiana', '1'),
('IA', 'Iowa', '1'),
('KS', 'Kansas', '1'),
('KY', 'Kentucky', '1'),
('LA', 'Louisiana', '1'),
('ME', 'Maine', '1'),
('MD', 'Maryland', '1'),
('MA', 'Massachusetts', '1'),
('MI', 'Michigan', '1'),
('MN', 'Minnesota', '1'),
('MS', 'Mississippi', '1'),
('MO', 'Missouri', '1'),
('MT', 'Montana', '1'),
('NE', 'Nebraska', '1'),
('NV', 'Nevada', '1'),
('NH', 'New Hampshire', '1'),
('NJ', 'New Jersey', '1'),
('NM', 'New Mexico', '1'),
('NY', 'New York', '1'),
('NC', 'North Carolina', '1'),
('ND', 'North Dakota', '1'),
('OH', 'Ohio', '1'),
('OK', 'Oklahoma', '1'),
('OR', 'Oregon', '1'),
('PA', 'Pennsylvania', '1'),
('RI', 'Rhode Island', '1'),
('SC', 'South Carolina', '1'),
('SD', 'South Dakota', '1'),
('TN', 'Tennessee', '1'),
('TX', 'Texas', '1'),
('UT', 'Utah', '1'),
('VT', 'Vermont', '1'),
('VA', 'Virginia', '1'),
('WA', 'Washington', '1'),
('WV', 'West Virginia', '1'),
('WI', 'Wisconsin', '1'),
('WY', 'Wyoming', '1'),
('BC', 'British Columbia', '2'),
('ON', 'Ontario', '2'),
('NL', 'Newfoundland and Labrador', '2'),
('NS', 'Nova Scotia', '2'),
('PE', 'Prince Edward Island', '2'),
('NB', 'New Brunswick', '2'),
('QC', 'Quebec', '2'),
('MB', 'Manitoba', '2'),
('SK', 'Saskatchewan', '2'),
('AB', 'Alberta', '2'),
('NT', 'Northwest Territories', '2'),
('NU', 'Nunavut', '2'),
('YT', 'Yukon Territory', '2');";

$countryInsertStmt = "INSERT INTO countries (country_abbrv, country_name) VALUES 
('USA', 'United States'),
('CAN', 'Canada');";

$settingsInsertStmt = "INSERT INTO settings (
campaign_name,
campaign_date,
campaign_location,
campaign_contact,
campaign_email,
campaign_phone,
campaign_message,
campaign_terms,
campaign_note,
campaign_brand
)
VALUES (
'',
'1999-12-31',
'',
'',
'',
'',
'',
'',
'',
'');";

$userTableStmt = 'CREATE TABLE IF NOT EXISTS users
(
user_id int NOT NULL AUTO_INCREMENT,
user_name varchar(50) NOT NULL,
user_password varchar(255) NOT NULL,
user_salt varchar(16) NOT NULL,
user_email varchar(255) NOT NULL,
UNIQUE(user_name),
PRIMARY KEY(user_id)
);';

$usersInsertStmt = "INSERT INTO users (
user_name,
user_password,
user_salt,
user_email
)
VALUES (
'orangemantis',
'" . $password . "',
'" . $salt . "',
'donotemail@orangemantis.net');";

$conString = 'mysql:host=' . $config['dbHost'] . ';dbname=' . $config['dbName'] . ';charset=' . $config['dbCharSet'];
$stmt = $subScriberTableStmt . $stateTableStmt . $countryTableStmt . $settingsTableStmt . $insertStatesStmt
. $countryInsertStmt . $settingsInsertStmt . $userTableStmt . $usersInsertStmt;

try{
	$db = new PDO($conString, $config['dbUser'], $config['dbPassword']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->exec($stmt);
	
	echo '<p>Installation went well.</p>';
}
catch(PDOException $error){
	echo '<p>Uh-oh the installation failed.<br/>';
	print_r($error->getMessage());
	echo '</p>';
}
?>