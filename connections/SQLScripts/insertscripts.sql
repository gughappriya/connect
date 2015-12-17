USE `Connections` ;

-- MessageVisibility
INSERT INTO messagevisibility(category) VALUES('neighbors');
INSERT INTO messagevisibility(category) VALUES('friends');
INSERT INTO messagevisibility(category) VALUES('user');
INSERT INTO messagevisibility(category) VALUES('hood');
INSERT INTO messagevisibility(category) VALUES('block');
-- Country
INSERT INTO country(countryName) VALUES('USA');
INSERT INTO country(countryName) VALUES('Canada');
-- State
SELECT countryId INTO @countryID FROM country where countryName =
'USA';
INSERT INTO state(stateName,countryId)
VALUES('NewJersey',@countryID);
INSERT INTO state(stateName,countryId)
VALUES('NewYork',@countryID);
SELECT countryId INTO @countryID FROM country where countryName =
'Canada';
INSERT INTO State(stateName,countryId)
VALUES('Quebec',@countryID);
INSERT INTO State(stateName,countryId)
VALUES('Montreal',@countryID);
-- NotificationType
INSERT INTO NotificationType VALUES('phone');
INSERT INTO NotificationType VALUES('email');
