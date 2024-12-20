
CREATE TABLE "Avatar"
(
    avatarID   SERIAL PRIMARY KEY,
    avatarPath VARCHAR(255) NOT NULL
);


CREATE TABLE "User"
(
    userID   SERIAL PRIMARY KEY,
    email    VARCHAR(30) NOT NULL UNIQUE,
    nickName VARCHAR(30) NOT NULL,
    passwordHash VARCHAR(120) NOT NULL,
    avatarID INT  REFERENCES "Avatar" (avatarID) ON DELETE SET NULL
);


CREATE TABLE "ComponentSet"
(
    setID SERIAL PRIMARY KEY,
    name  VARCHAR(30) NOT NULL
);


CREATE TABLE "ComponentType"
(
    typeID SERIAL PRIMARY KEY,
    name   VARCHAR(30) NOT NULL
);


CREATE TABLE "Component"
(
    componentID SERIAL PRIMARY KEY,
    name        VARCHAR(30) NOT NULL,
    setID       INT  REFERENCES "ComponentSet" (setID) ON DELETE SET NULL,
    typeID      INT REFERENCES "ComponentType" (typeID) ON DELETE CASCADE,
    color       VARCHAR(30) NOT NULL,
    css         TEXT,
    html        TEXT,
    authorID    INT REFERENCES "User" (userID) ON DELETE CASCADE,
    createdAt   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE "Tag"
(
    tagID SERIAL PRIMARY KEY,
    name  VARCHAR(30) NOT NULL UNIQUE
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
