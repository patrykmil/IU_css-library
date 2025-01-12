DROP TABLE IF EXISTS "Color" CASCADE;
DROP TABLE IF EXISTS "Avatar" CASCADE;
DROP TABLE IF EXISTS "User" CASCADE;
DROP TABLE IF EXISTS "Set" CASCADE;
DROP TABLE IF EXISTS "Type" CASCADE;
DROP TABLE IF EXISTS "Component" CASCADE;
DROP TABLE IF EXISTS "Tag" CASCADE;
DROP TABLE IF EXISTS "ComponentTag" CASCADE;
DROP TABLE IF EXISTS "Likes" CASCADE;
DROP TABLE IF EXISTS "Bookmark" CASCADE;
DROP TABLE IF EXISTS "BookmarkComponent" CASCADE;


CREATE TABLE "Avatar"
(
    avatarID   SERIAL PRIMARY KEY,
    avatarPath VARCHAR(255) NOT NULL
);

CREATE TABLE "User"
(
    userID       SERIAL PRIMARY KEY,
    email        VARCHAR(255) UNIQUE NOT NULL,
    nickname     VARCHAR(255)        NOT NULL,
    passwordHash VARCHAR(255)        NOT NULL,
    avatarID     INT                 REFERENCES "Avatar" (avatarID) ON DELETE SET NULL,
    isAdmin      BOOLEAN DEFAULT FALSE
);

CREATE TABLE "Set"
(
    setID   SERIAL PRIMARY KEY,
    name    VARCHAR(30) NOT NULL,
    ownerID INT         REFERENCES "User" (userID) ON DELETE SET NULL
);


CREATE TABLE "Type"
(
    typeID SERIAL PRIMARY KEY,
    name   VARCHAR(30) NOT NULL
);

CREATE TABLE "Color"
(
    colorID SERIAL PRIMARY KEY,
    hex     VARCHAR(6) NOT NULL
);

CREATE TABLE "Component"
(
    componentID SERIAL PRIMARY KEY,
    name        VARCHAR(30) NOT NULL,
    setID       INT         REFERENCES "Set" (setID) ON DELETE SET NULL,
    typeID      INT REFERENCES "Type" (typeID) ON DELETE CASCADE,
    colorID     INT         REFERENCES "Color" (colorID) ON DELETE SET NULL,
    css         TEXT,
    html        TEXT,
    authorID    INT REFERENCES "User" (userID) ON DELETE CASCADE,
    createdAt   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE "Tag"
(
    tagID   SERIAL PRIMARY KEY,
    name    VARCHAR(30) NOT NULL UNIQUE,
    colorID INT         REFERENCES "Color" (colorID) ON DELETE SET NULL
);


CREATE TABLE "ComponentTag"
(
    componentID INT REFERENCES "Component" (componentID) ON DELETE CASCADE,
    tagID       INT REFERENCES "Tag" (tagID) ON DELETE CASCADE,
    PRIMARY KEY (componentID, tagID)
);


CREATE TABLE "Likes"
(
    userID      INT REFERENCES "User" (userID) ON DELETE CASCADE,
    componentID INT REFERENCES "Component" (componentID) ON DELETE CASCADE,
    likedAt     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (userID, componentID)
);


CREATE TABLE "Bookmark"
(
    bookmarkID SERIAL PRIMARY KEY,
    userID     INT REFERENCES "User" (userID) ON DELETE CASCADE,
    name       VARCHAR(30) NOT NULL
);


CREATE TABLE "BookmarkComponent"
(
    bookmarkID  INT REFERENCES "Bookmark" (bookmarkID) ON DELETE CASCADE,
    componentID INT REFERENCES "Component" (componentID) ON DELETE CASCADE,
    PRIMARY KEY (bookmarkID, componentID)
);

CREATE TABLE "UserSession"
(
    token     VARCHAR(255) PRIMARY KEY,
    userID    INT REFERENCES "User" (userID) ON DELETE CASCADE,
    expiresAt TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '30 days')
);