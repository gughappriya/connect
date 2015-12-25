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


-- Actual data for block and hood

-- Hood
INSERT INTO hood(hoodName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES('Journal Square' , 40.7390053892863,-74.05460564422606,40.727502595536656,-74.0726364364624);


-- Block
SELECT hoodId INTO @hoodID FROM hood where hoodName = 'Journal Square';
INSERT INTO block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES( @hoodID, 'Sip Avenue',40.732534283696396,-74.06280247497557, 40.730429525490585,-74.06594164276123);
INSERT INTO block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES( @hoodID,  'Bergen Avenue', 40.732534283696396,-74.06580654907225,40.73042952549061,-74.06894571685791);



-- Hood
INSERT INTO hood(hoodName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES('Jay Street' , 40.69490648767465, -73.98431031036364,40.68969704955463, -73.98857064151775);


-- Block
SELECT hoodId INTO @hoodID FROM hood where hoodName = 'Jay Street';
INSERT INTO block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES( @hoodID, 'Nyu Tandon',40.69490648767465, -73.98617712783795, 40.69374823455756, -73.98714370632177);
INSERT INTO block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES( @hoodID,  'Hoyt Street', 40.6935642782016, -73.98607618713385,40.691002729451796, -73.98726074028013);




