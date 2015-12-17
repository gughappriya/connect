INSERT INTO
hood(hoodName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES('NewYorkSlope' , 42.8525365993135,-
75.605787109375,42.64745447566536,-75.92713085937498);
INSERT INTO
hood(hoodName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES('NewHavenSlope', 41.87848336954302,-
72.58454687500006,41.40705593394235,-73.40027539062498);
-- Block
SELECT hoodId INTO @hoodID FROM hood where hoodName ='NewYorkSlope';
INSERT INTO
block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES( @hoodID, 'WesternSlope',
41.673656111253166,-72.58454687500006,41.47294306224083,-
73.02674023437498);
INSERT INTO
block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES( @hoodID, 'EasternSlope',
41.673656111253166,-72.89216406250006,41.47294306224083,-
73.26843945312498);
SELECT hoodId INTO @hoodID FROM hood where hoodName ='NewHavenSlope';
INSERT INTO
block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES(@hoodID, 'NorthernSlope', 40.881048190735065,
-73.84797460937506,40.644551985542265, -74.03748242187498);
INSERT INTO
block(hoodId,blockName,northeastLat,northeastLong,southwestLat,southwestLong) VALUES(@hoodID, 'SouthernSlope', 40.881048190735065,
-74.06770117187506,40.644551985542265, -74.48792187499998 );
-- blockrequests
-- status will be APPROVED, PENDING maintained through
-- application
SELECT blockId INTO @blockID FROM hood inner join
Connections.block on Connections.block.hoodId = hood.hoodId
where hoodName = 'NewYorkSlope' and blockName='WesternSlope' ;
INSERT INTO blockrequests
VALUES('Antony878',@blockID,null,null,null,'APPROVED',now());
INSERT INTO blockrequests
VALUES('Benny458',@blockID,'Antony878',null,null,'APPROVED',now()
);
INSERT INTO blockrequests
VALUES('Chandler444',@blockID,'Antony878','Benny458',null,'APPROVED',now());

INSERT INTO blockrequests
VALUES('Dilan566',@blockID,'Antony878',null,null,'PENDING',now())
;
SELECT blockId INTO @blockID FROM hood inner join
Connections.block on Connections.block.hoodId = hood.hoodId
where hoodName = 'NewYorkSlope' and blockName='EasternSlope' ;
INSERT INTO blockrequests
VALUES('Emily589',@blockID,null,null,null,'APPROVED',now());
-- INSERT INTO message VALUES(1,'Looking for a baby sitter',1,);
-- Friend
INSERT INTO friend VALUES('Antony878', 'Benny458','Approved',
now(), 'Active');
INSERT INTO friend VALUES('Antony878', 'Chandler444','Approved',
now(), 'Active');
INSERT INTO friend VALUES('Antony878', 'Dilan566','Approved',
now(), 'Active');
INSERT INTO friend VALUES('Benny458', 'Dilan566','Approved',
now(), 'Active');
-- Neighbor
INSERT INTO Neighbor VALUES('Antony878', 'Benny458', now(),
'Active');
INSERT INTO Neighbor VALUES('Benny458', 'Chandler444', now(),
'Active');
INSERT INTO Neighbor VALUES('Chandler444', 'Benny458', now(),
'Active');
-- Relation
INSERT INTO Relation(relationName) VALUES('Brother');
INSERT INTO Relation(relationName) VALUES('Sister');
INSERT INTO Relation(relationName) VALUES('Spouse');
INSERT INTO Relation(relationName) VALUES('Aunt');
INSERT INTO Relation(relationName) VALUES('Mother');
INSERT INTO Relation(relationName) VALUES('Father');
INSERT INTO Relation(relationName) VALUES('Grandmother');
INSERT INTO Relation(relationName) VALUES('Grandfather');
INSERT INTO Relation(relationName) VALUES('Cousin(male)');
INSERT INTO Relation(relationName) VALUES('Cousin(female)');
INSERT INTO Relation(relationName) VALUES('Sister-in-law');
INSERT INTO Relation(relationName) VALUES('Brother-in-law');
-- Family
SELECT relationId INTO @relationId FROM relation where
relationName = 'Cousin(male)';
INSERT INTO Family VALUES('Antony878', 'Benny458', @relationId);
INSERT INTO Family VALUES('Antony878', 'Chandler444',
@relationId);
SELECT relationId INTO @relationId FROM relation where
relationName = 'Spouse';
INSERT INTO Family VALUES('Dilan566', 'Chandler444', @relationId);
