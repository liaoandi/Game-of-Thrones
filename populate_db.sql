USE liaoad17DB;

LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/Continent.dat"
    REPLACE INTO TABLE Continent
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (continent_id, continent_name, continent_details);

LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/House.dat"
    REPLACE INTO TABLE House
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (house_id, house_name, motto, flag);
    
LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/People.dat" 
    REPLACE INTO TABLE People
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (people_id, first_name, last_name, born_date, death_date, title, is_alive);

LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/Timeline.dat"
    REPLACE INTO TABLE Timeline
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (timeline_id, timeline_name, at_time);

LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/Region.dat"
    REPLACE INTO TABLE Region
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (continent_id, region_id, region_name, ruler_house_id);
    
LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/Location.dat"
    REPLACE INTO TABLE Location
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (continent_id, region_id, location_id, location_name, is_capital);
    
LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/Battle.dat"
    REPLACE INTO TABLE Battle
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (battle_id, battle_name, timeline_id, conflict, result);
    
    
LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/HouseFriend.dat"
    REPLACE INTO TABLE HouseFriend
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (house_id, house_id_fk, house_relation); 
    
LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/PeopleFriend.dat"
    REPLACE INTO TABLE PeopleFriend
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (people_id, people_id_fk, people_relation);  
    
LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/PeopleBelongHouse.dat"
    REPLACE INTO TABLE PeopleBelongHouse
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (house_id, people_id, connect);  
    
LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/BattleTakePlaceLocation.dat"
    REPLACE INTO TABLE BattleTakePlaceLocation
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (battle_id, location_name);

LOAD DATA
    LOCAL INFILE "C:/Users/liaoa/Desktop/MPCS 53001/Assignment9/data/BattleParticipateHouse.dat"
    REPLACE INTO TABLE BattleParticipateHouse
    FIELDS TERMINATED BY '|'
    LINES TERMINATED BY '\r\n'
    (battle_id, house_id, role, outcome, casualty);