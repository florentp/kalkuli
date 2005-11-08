-- -----------------------------------------------------------------------
-- person-- -----------------------------------------------------------------------

CREATE TABLE person(
 
	"personId" INTEGER NOT NULL PRIMARY KEY,
 
	"personName" VARCHAR(255) NOT NULL 
);

-- -----------------------------------------------------------------------
-- outgoing-- -----------------------------------------------------------------------

CREATE TABLE outgoing(
 
	"outId" INTEGER NOT NULL PRIMARY KEY,
 
	"outWeight" FLOAT,
 
	"operationIdFK" INTEGER NOT NULL,
 
	"personIdFK" INTEGER NOT NULL 
);

	-- SQLite does not support foreign keys; this is just for reference
    -- FOREIGN KEY ("operationIdFK") REFERENCES operation ("operationId"),
	-- SQLite does not support foreign keys; this is just for reference
    -- FOREIGN KEY ("personIdFK") REFERENCES person ("personId"),
-- -----------------------------------------------------------------------
-- incoming-- -----------------------------------------------------------------------

CREATE TABLE incoming(
 
	"inId" INTEGER NOT NULL PRIMARY KEY,
 
	"inAmount" FLOAT,
 
	"operationIdFK" INTEGER NOT NULL,
 
	"personIdFK" INTEGER NOT NULL 
);

	-- SQLite does not support foreign keys; this is just for reference
    -- FOREIGN KEY ("operationIdFK") REFERENCES operation ("operationId"),
	-- SQLite does not support foreign keys; this is just for reference
    -- FOREIGN KEY ("personIdFK") REFERENCES person ("personId"),
-- -----------------------------------------------------------------------
-- operation-- -----------------------------------------------------------------------

CREATE TABLE operation(
 
	"operationId" INTEGER NOT NULL PRIMARY KEY,
 
	"operationTS" TIMESTAMP NOT NULL,
 
	"operationDescription" MEDIUMTEXT NOT NULL 
);

  
  
  
  
