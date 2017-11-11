<?php

///////////////////////
// SNAPTRAVELS
///////////////////////

/* 
install.php
Configures database tables and inserts example data is requested
*/

require_once('connection.php');

// Display welcome message
echo '<h1>SnapTravels - Database Installer</h1>';

// Check if connection is present
if($conn) {
	echo '<h2>Install Progress</h2>';

	// Check user is not installing sample data
	if (!isset($_POST['installSampleData'])) {
		
		/* Set up database tables */

		// DROP ALL TABLES
		// Prepare SQL Query to drop tables and ignore foreign key constraint checks
		$query = $conn->prepare("SET FOREIGN_KEY_CHECKS = 0;
		drop table if exists places;
		drop table if exists types;
		drop table if exists cuisines;
		SET FOREIGN_KEY_CHECKS = 1;");

		// Run query and check for true boolean return
		if ($query->execute()) {
			// Display success message if query returns true
			echo 'Tables dropped successfully<br>';
		} else {
			// Display error message and stop execution
			echo 'Error dropping tables<br>';
			exit;
		}

		// CREATE TABLE: CUISINES
		// Prepare SQL Query to create table
		$query = $conn->prepare("CREATE TABLE cuisines (
				cuisineId INT(11) PRIMARY KEY AUTO_INCREMENT,
				name varchar(40),
				socialQuery varchar(140)
			)");

		// Run query and check for true boolean return
		if ($query->execute()) {
			// Display success message if query returns true
			echo 'Cuisines table created successfully<br>';
		} else {
			// Display error message and stop execution
			echo 'Error creating cuisines tables<br>';
			exit;
		}

		// CREATE TABLE: TYPES
		// Prepare SQL Query to create table
		$query = $conn->prepare("CREATE TABLE types (
			typeId INT(11) PRIMARY KEY AUTO_INCREMENT,
			name varchar(40),
			socialQuery varchar(140)
		)");

		// Run query and check for true boolean return
		if ($query->execute()) {
			// Display success message if query returns true
			echo 'Types table created successfully<br>';
		} else {
			// Display error message and stop execution
			echo 'Error creating types tables<br>';
			exit;
		}

		// CREATE TABLE: PLACES
		// Prepare SQL Query to create table
		$query = $conn->prepare("CREATE TABLE places (
			placeId varchar(8) PRIMARY KEY,
			name varchar(40),
			country varchar(40),
			socialQuery varchar(140),
			cuisineId INT(11),
			typeId INT(11),
			FOREIGN KEY (cuisineId) REFERENCES cuisines(cuisineId),
			FOREIGN KEY (typeId) REFERENCES types(typeId)
		)");

		// Run query and check for true boolean return
		if ($query->execute()) {
			// Display success message if query returns true
			echo 'Places table created successfully<br>';
		} else {
			// Display error message and stop execution
			echo 'Error creating places tables<br>';
			exit;
		}

		// Ask user if sample data required
		echo <<<_END
		<form method="post">
			<input type="hidden" name="installSampleData" value="true">
			<label>Would you like to insert sample data?</label>
			<button type="submit">Yes</button>
		</form>
_END;
	} else {
		
		// Initial data for the INSERT statements

		// Create cuisines data in an array
		$cuisines = [
			[
				'name' => 'Asian',
				'socialQuery' => '#japanese OR #chinese OR #thai OR #asian OR #noodles AND #cuisine'
			],
			[
				'name' => 'Indian',
				'socialQuery' => '#korma OR #jalfrezi OR #vindaloo OR #dhansak OR #bhuna AND #cuisine'
			],
			[
				'name' => 'Mexican',
				'socialQuery' => '#tacos OR #burritos OR #nachos OR #fajitas OR #enchiladas AND #cuisine'
			],
			[
				'name' => 'Italian',
				'socialQuery' => '#lasagne OR #spaghetti OR #tagliatelle OR #pizza OR #pasta AND #cuisine'
			],
			[
				'name' => 'Greek',
				'socialQuery' => '#olives OR #moussaka OR #feta OR #dolmades OR #taramasalata AND #cuisine'
			],
			[
				'name' => 'British',
				'socialQuery' => '#yorkshirepuddings OR #toadinahole OR #shepherdspie OR #fishandchips OR #englishbreakfast AND #cuisine'
			],
			[
				'name' => 'American',
				'socialQuery' => '#steak OR #hotdogs OR #pancakes OR #waffles OR #fries AND #cuisine'
			],
			[
				'name' => 'French',
				'socialQuery' => '#coqauvin OR #cassoulet OR #beefbourguignon OR #souffle OR #croissants AND #cuisine'
			]
		];

		// for each item in array, create a row in the cuisines table
		foreach($cuisines as $cuisine){
			$query = $conn->prepare("INSERT INTO cuisines (name, socialQuery) VALUES ('" . $cuisine['name'] . "', '" . $cuisine['socialQuery'] . "')");
			if($query->execute()){
				echo "Inserted " . $cuisine['name'] . " into cusines table! <br>";
			}
		}

		// separate insert statements between each table
		echo "<br>";

		// Types
		$types = [
			[
				'name' => 'Skiing',
				'socialQuery' => '#ski OR #mountain OR #skislope OR #snow OR #wintersports AND #holiday'
			],
			[
				'name' => 'Beach',
				'socialQuery' => '#exoticbeach OR #whitesand OR #whitebeach OR #tropicalisland OR #clearwater AND #holiday'
			],
			[
				'name' => 'City',
				'socialQuery' => '#skyscraper OR #newyork OR #city OR #london OR #paris AND #holiday'
			],
			[
				'name' => 'Adventure',
				'socialQuery' => '#mountain OR #jungle OR #expedition OR #desert OR #adventure AND #holiday'
			],
			[
				'name' => 'Safari',
				'socialQuery' => '#elephants OR #safari OR #lions OR #zebras OR #rhinos AND #holiday'
			]
		];

		// for each item in array, create a row in the cuisines table
		foreach($types as $type){
			$query = $conn->prepare("INSERT INTO cuisines (name, socialQuery) VALUES ('" . $type['name'] . "', '" . $type['socialQuery'] . "')");
			if($query->execute()){
				echo "Inserted " . $type['name'] . " into types table! <br>";
			}
		}

		// separate insert statements between each table
		echo "<br>";

		// Places
		$places = [];

	}

} else {
	echo '<h2>An Error Occured</h2><p>Please check your connection to the database.</p>';
}
