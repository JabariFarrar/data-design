-- this is a comment in SQL (yes, the space is needed!)
-- these statements will drop the tables and re-add them
-- this is akin to reformatting and reinstalling Windows (OS X never needs a reinstall...) ;)
-- never ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever ever
-- do this on live data!!!!
DROP TABLE IF EXISTS favorite;
DROP TABLE IF EXISTS product;
DROP TABLE IF EXISTS profile;

-- the CREATE TABLE function is a function that takes tons of arguments to layout the table's schema
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- auto_increment tells mySQL to number them {1, 2, 3, ...}
	-- not null means the attribute is required!
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileActivationToken CHAR(32),
	profileEmail VARCHAR(128) UNIQUE NOT NULL,
	profileHash	CHAR(128) NOT NULL,
	-- to make something optional, exclude the not null
	profilePhone VARCHAR(32),
	profileSalt CHAR(64) NOT NULL,
	UNIQUE(profileEmail),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);

-- create the product entity
CREATE TABLE product (
	-- this is for yet another primary key...
	productId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	-- this is for a foreign key; auto_incremented is omitted by design
	productName VARCHAR(64) NOT NULL,
	productPrice DECIMAL NOT NULL,
	-- and finally create the primary key
	PRIMARY KEY(productId)
);

CREATE TABLE favorite (
	-- these are not auto_increment because they're still foreign keys
	favoriteProfileId INT UNSIGNED NOT NULL,
	favoriteProductId INT UNSIGNED NOT NULL,
	favoriteDate DATETIME NOT NULL,
	-- index the foreign keys
	INDEX(favoriteProfileId),
	INDEX(favoriteProductId),
	-- create the foreign key relations
	FOREIGN KEY(favoriteProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(favoriteProductId) REFERENCES product(productId),
	-- finally, create a composite foreign key with the two foreign keys
	PRIMARY KEY(favoriteProfileId, favoriteProductId)
);