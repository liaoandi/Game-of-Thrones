USE liaoad17DB;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS Continent;
CREATE TABLE Continent (
	continent_id INT PRIMARY KEY,
    continent_name VARCHAR(50),
    continent_details VARCHAR(1000)
    );

DROP TABLE IF EXISTS House;
CREATE TABLE House(
	house_id INT PRIMARY KEY,
    house_name VARCHAR(50),
    motto VARCHAR(100),
    flag VARCHAR(500)
    );
    
DROP TABLE IF EXISTS People;
CREATE TABLE People (
	people_id INT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    born_date VARCHAR(50),
    death_date VARCHAR(50),
    title VARCHAR(200),
    is_alive Varchar(50)
    );

DROP TABLE IF EXISTS Timeline;    
CREATE TABLE Timeline(
	timeline_id INT PRIMARY KEY,
    timeline_name VARCHAR(50),
    at_time VARCHAR(50)
    );

DROP TABLE IF EXISTS Region;
CREATE TABLE Region(
	continent_id INT,
    region_id INT,
    region_name VARCHAR(50),
    ruler_house_id INT,
    PRIMARY KEY (continent_id, region_id),
	FOREIGN KEY (continent_id) REFERENCES Continent(continent_id)
    ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (ruler_house_id) REFERENCES House(house_id)
    ON DELETE SET NULL
	ON UPDATE CASCADE
    );

DROP TABLE IF EXISTS Location;
CREATE TABLE Location(
	continent_id INT,
    region_id INT REFERENCES Region(region_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    location_id INT,
    location_name VARCHAR(50),
    is_capital VARCHAR(50),
    PRIMARY KEY (continent_id, region_id, location_id),
	FOREIGN KEY (continent_id) REFERENCES Continent(continent_id)
    ON DELETE CASCADE
	ON UPDATE CASCADE
    );
    
DROP TABLE IF EXISTS Battle;    
CREATE TABLE Battle(
	battle_id INT PRIMARY KEY,
    battle_name VARCHAR(50),
    timeline_id INT,
    conflict VARCHAR(50),
    result VARCHAR(50),
    FOREIGN KEY (timeline_id) REFERENCES Timeline(timeline_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
    );

DROP TABLE IF EXISTS HouseFriend; 
CREATE TABLE HouseFriend(
	house_id INT,
    house_id_fk INT,
    house_relation VARCHAR(50),
    PRIMARY KEY (house_id, house_id_fk),
    FOREIGN KEY (house_id) REFERENCES House(house_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (house_id_fk) REFERENCES House(house_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
    );

DROP TABLE IF EXISTS PeopleFriend;     
CREATE TABLE PeopleFriend(
	people_id INT,
    people_id_fk INT,
    people_relation VARCHAR(50),
    PRIMARY KEY (people_id, people_id_fk),
    FOREIGN KEY (people_id) REFERENCES People(people_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (people_id_fk) REFERENCES People(people_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
    );

DROP TABLE IF EXISTS PeopleBelongHouse; 
CREATE TABLE PeopleBelongHouse(
	house_id INT,
    people_id INT,
    connect VARCHAR(50),
    PRIMARY KEY (house_id, people_id),
    FOREIGN KEY (house_id) REFERENCES House(house_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (people_id) REFERENCES People(people_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
    );

DROP TABLE IF EXISTS BattleTakePlaceLocation; 
CREATE TABLE BattleTakePlaceLocation(
	battle_id INT, 
    location_name VARCHAR(50),
    PRIMARY KEY (battle_id, location_name),
    FOREIGN KEY (battle_id) REFERENCES Battle(battle_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
    );

DROP TABLE IF EXISTS BattleParticipateHouse;     
CREATE TABLE BattleParticipateHouse(
	battle_id INT, 
	house_id INT, 
    role VARCHAR(50), 
    outcome VARCHAR(100),
    casualty VARCHAR(50),
    PRIMARY KEY(battle_id, house_id),
    FOREIGN KEY (battle_id) REFERENCES Battle(battle_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
    FOREIGN KEY (house_id) REFERENCES House(house_id)
	ON DELETE CASCADE
	ON UPDATE CASCADE
    );
    
SET FOREIGN_KEY_CHECKS = 1;