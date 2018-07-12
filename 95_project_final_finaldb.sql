drop table claims;
drop table consistsof;
drop table wears;
drop table hunter;
drop table mission;
drop table elder;
drop table equipment;
drop table team;
drop table clan;
drop table monster;

 
CREATE TABLE monster (
	ID INT,
	Alive INT,
	MonsterLevel INT,
	Name CHAR(255),
	Location CHAR(255),
	PRIMARY KEY (ID)
);


insert into monster
	values(42081, 1, 30, 'Armadillo', 'Ancient Forest');
insert into monster
	values(67820, 1, 25, 'Crocodile', 'Arcane Ocean');
insert into monster
	values(47321, 1, 40, 'Armadillo', 'Misty Swamp');
insert into monster
	values(21345, 0, 5, 'Crocodile', 'Rainbow Village');
insert into monster
	values(87738, 1, 70, 'Armadillo', 'Rotten Vale');






CREATE TABLE clan (
	Name CHAR(255),
	Location CHAR(255),
	MemberCount INT,
	Symbol CHAR(255),
	CreatedIn INT,
	PRIMARY KEY (Name)
);


insert into clan
values ('The Lionheart', null, 12, 'Lion', 1001);

insert into clan
values ('The Blackfire', null, 7, 'Dragon', 1002);

insert into clan
values ('WinterDown', null, 8, 'Wolf', 1003);

insert into clan
values ('The Leaves', null, 7, 'Pine', 1004);

insert into clan
values ('Lightning Bolt', null, 4, 'Thunderbird', 1005);








CREATE TABLE team (
	ID INT,
	teamScore INT,
	PRIMARY KEY (ID)
);


insert into team
values (103, 37);

insert into team
values (89, 55);

insert into team
values (145, 67);

insert into team
values (187, 62);

insert into team
values (56, 130);






CREATE TABLE equipment (
	Name CHAR(255),
	PRIMARY KEY (Name)
);


insert into equipment
values ('Spear');

insert into equipment
values ('Bow');

insert into equipment
values ('Sword');

insert into equipment
values ('Armor');

insert into equipment
values ('Shield');









CREATE TABLE elder (
	ID INT,
	NAME CHAR(255) NOT NULL ,
	ClanName CHAR(255) NOT NULL,
	Age INT,
	PRIMARY KEY (ID),
	FOREIGN KEY (ClanName) REFERENCES clan (Name)
		-- ON DELETE NO ACTION,
		-- ON UPDATE CASCADE,
);


insert into elder
	values(890, 'Julia', 'The Lionheart', 101);
insert into elder
	values(783, 'Arista', 'The Blackfire', 99);
insert into elder
	values(829, 'Ezio', 'WinterDown', 66);
insert into elder
	values(478, 'Alice', 'The Leaves', 123);
insert into elder
	values(672, 'Vladimir', 'Lightning Bolt', 150);








CREATE TABLE mission (
	ID INT,
	RewardPoint INT,
	Completion INT,
	TimeLimit INT,
	MinimumScore INT,
	MonsterID INT NOT NULL,
	ElderID INT NOT NULL,
	PRIMARY KEY (ID),
	FOREIGN KEY (MonsterID) REFERENCES monster (ID) ON DELETE CASCADE,
		-- ON DELETE NO ACTION,
		-- ON UPDATE CASCADE,
	FOREIGN KEY (ElderID) REFERENCES elder (ID)
		-- ON DELETE NO ACTION
		-- ON UPDATE CASCADE,
);


insert into mission
	values(1001, 5, 0, 14, 1, 42081, 829);
insert into mission
	values(1002, 4, 0, 10, 10, 67820, 783);
insert into mission
	values(1003, 6, 0, 9, 20, 47321, 478);
insert into mission
	values(1004, 1, 1, 7, 12, 21345, 478);
insert into mission
	values(1005, 10, 0, 15, 20, 87738, 672);










CREATE TABLE hunter (
	ID INT,
	NAME CHAR(255) NOT NULL ,
	ClanName CHAR(255) NOT NULL,
	Age INT,
	PRIMARY KEY (ID),
	FOREIGN KEY (ClanName) REFERENCES clan (Name)
		-- ON DELETE NO ACTION,
		-- ON UPDATE CASCADE,
);


insert into hunter
	values(10023, 'Ryan', 'The Blackfire', 34);
insert into hunter
	values(10384, 'Eric', 'Lightning Bolt', 53);
insert into hunter
	values(10842, 'Kevin', 'The Lionheart', 46);
insert into hunter
	values(10839, 'Tim', 'The Lionheart', 57);
insert into hunter
	values(10984, 'William', 'WinterDown', 23);










CREATE TABLE wears (
	EquipName CHAR(255),
	HunterID INT,
	PRIMARY KEY (EquipName, HunterID),
	FOREIGN KEY (EquipName) REFERENCES equipment (Name) ON DELETE CASCADE,
	FOREIGN KEY (HunterID) REFERENCES hunter (ID)
);


insert into wears
values ('Spear', 10023);

insert into wears
values ('Shield', 10384);

insert into wears
values ('Sword', 10842);

insert into wears
values ('Sword', 10384);

insert into wears
values ('Armor', 10839);









CREATE TABLE consistsof (
	TeamID INT,
	HunterID INT,
	PRIMARY KEY (TeamID, HunterID),
	FOREIGN KEY (TeamID) REFERENCES team (ID),
	FOREIGN KEY (HunterID) REFERENCES hunter (ID)
);


insert into consistsof
values (103, 10384);

insert into consistsof
values (89, 10384);

insert into consistsof
values (89, 10842);

insert into consistsof
values (89, 10984);

insert into consistsof
values (145, 10842);

insert into consistsof
values (187, 10839);

insert into consistsof
values (187, 10842);

insert into consistsof
values (56, 10984);




CREATE TABLE claims (
	TeamID INT,
	MissionID INT,
	PRIMARY KEY (TeamID, MissionID),
	FOREIGN KEY (TeamID) REFERENCES team (ID),
	FOREIGN KEY (MissionID) REFERENCES mission (ID) ON DELETE CASCADE
);


insert into claims
values (145, 1001);

insert into claims
values (145, 1003);

insert into claims
values (145, 1002);

insert into claims
values (89, 1003);

insert into claims
values (89, 1002);

insert into claims
values (103, 1002);

insert into claims
values (103, 1003);

insert into claims
values (103, 1005);

insert into claims
values (187, 1003);

insert into claims
values (187, 1002);

insert into claims
values (56, 1005);

insert into claims
values (56, 1003);


delimiter //
CREATE TRIGGER insertTeamBeforeConsists BEFORE INSERT ON consistsof 
FOR EACH ROW 
BEGIN
	IF (SELECT EXISTS(SELECT * FROM team WHERE ID = NEW.TeamID) = 0) THEN
		INSERT INTO team VALUES(NEW.TeamID, 0);
	END IF;
END//
delimiter ;
