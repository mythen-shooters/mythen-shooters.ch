CREATE TABLE handball_team (
	team_id INT primary key,
	team_name VARCHAR(255) NOT NULL,
	saison VARCHAR(8) NOT NULL
)ENGINE=InnoDB COLLATE utf8_unicode_ci;

CREATE TABLE handball_match (
	game_id INT primary key,
	game_nr INT NOT NULL,
	team_a_name VARCHAR(255) NULL,
	team_b_name VARCHAR(255) NULL
)ENGINE=InnoDB COLLATE utf8_unicode_ci;

CREATE TABLE handball_group (
	group_id INT primary key,
	group_text VARCHAR(255),
	league_id INT,
	league_long VARCHAR(255),
	league_short VARCHAR(255),
	ranking TEXT
)ENGINE=InnoDB COLLATE utf8_unicode_ci;

ALTER TABLE handball_team ADD COLUMN league_long VARCHAR(255);
ALTER TABLE handball_team ADD COLUMN league_short VARCHAR(255);

ALTER TABLE handball_match ADD COLUMN game_datetime DATETIME;
ALTER TABLE handball_match ADD COLUMN game_type_long VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN game_type_short VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN league_long VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN league_short VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN round VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN game_status VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN team_a_score_ht INTEGER;
ALTER TABLE handball_match ADD COLUMN team_b_score_ht INTEGER;
ALTER TABLE handball_match ADD COLUMN team_a_score_ft INTEGER;
ALTER TABLE handball_match ADD COLUMN team_b_score_ft INTEGER;
ALTER TABLE handball_match ADD COLUMN venue VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN venue_address VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN venue_zip VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN venue_city VARCHAR(255);
ALTER TABLE handball_match ADD COLUMN spectators INTEGER;
ALTER TABLE handball_match ADD COLUMN round_nr INTEGER;
ALTER TABLE handball_match ADD COLUMN fk_team_id INTEGER NOT NULL;
ALTER TABLE handball_match ADD FOREIGN KEY (fk_team_id) REFERENCES handball_team(team_id);

ALTER TABLE handball_group ADD COLUMN fk_team_id INTEGER NOT NULL;
ALTER TABLE handball_group ADD FOREIGN KEY (fk_team_id) REFERENCES handball_team(team_id);

ALTER TABLE handball_group DROP PRIMARY KEY, ADD PRIMARY KEY (group_id, fk_team_id);

-- new stuff
ALTER TABLE handball_match ADD COLUMN team_a_id INTEGER;
ALTER TABLE handball_match ADD COLUMN team_b_id INTEGER;
ALTER TABLE handball_match ADD COLUMN team_a_club_id INTEGER;
ALTER TABLE handball_match ADD COLUMN team_b_club_id INTEGER;
