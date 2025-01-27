DROP SCHEMA IF EXISTS public CASCADE;
CREATE SCHEMA public;
--------------------------------------------------------------------------------------------------
CREATE TABLE "Avatar"
(
    avatarID   SERIAL PRIMARY KEY,
    avatarPath VARCHAR(255) NOT NULL
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "User"
(
    userID       SERIAL PRIMARY KEY,
    email        VARCHAR(255) UNIQUE NOT NULL,
    nickname     VARCHAR(255)        NOT NULL,
    passwordHash VARCHAR(255)        NOT NULL,
    avatarID     INT                 REFERENCES "Avatar" (avatarID) ON DELETE SET NULL,
    isAdmin      BOOLEAN DEFAULT FALSE
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "Set"
(
    setID   SERIAL PRIMARY KEY,
    name    VARCHAR(30) NOT NULL,
    ownerID INT         REFERENCES "User" (userID) ON DELETE SET NULL
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "Type"
(
    typeID SERIAL PRIMARY KEY,
    name   VARCHAR(30) NOT NULL
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "Color"
(
    colorID SERIAL PRIMARY KEY,
    hex     VARCHAR(6) NOT NULL
);
--------------------------------------------------------------------------------------------------
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
--------------------------------------------------------------------------------------------------
CREATE TABLE "Tag"
(
    tagID   SERIAL PRIMARY KEY,
    name    VARCHAR(30) NOT NULL UNIQUE,
    colorID INT         REFERENCES "Color" (colorID) ON DELETE SET NULL
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "ComponentTag"
(
    componentID INT REFERENCES "Component" (componentID) ON DELETE CASCADE,
    tagID       INT REFERENCES "Tag" (tagID) ON DELETE CASCADE,
    PRIMARY KEY (componentID, tagID)
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "Likes"
(
    userID      INT REFERENCES "User" (userID) ON DELETE CASCADE,
    componentID INT REFERENCES "Component" (componentID) ON DELETE CASCADE,
    likedAt     TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (userID, componentID)
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "UserSession"
(
    token     VARCHAR(255) PRIMARY KEY,
    userID    INT REFERENCES "User" (userID) ON DELETE CASCADE,
    expiresAt TIMESTAMP DEFAULT (CURRENT_TIMESTAMP + INTERVAL '30 days')
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "Message"
(
    messageid   INTEGER NOT NULL PRIMARY KEY,
    name        VARCHAR NOT NULL,
    description TEXT
);
--------------------------------------------------------------------------------------------------
CREATE TABLE "DeletedComponent"
(
    componentid INTEGER NOT NULL PRIMARY KEY,
    name        VARCHAR NOT NULL,
    css         TEXT,
    html        TEXT,
    authorid    INTEGER,
    messageid   INTEGER REFERENCES "Message" (messageid) ON DELETE SET NULL
);
-------------------------------------------------------------------------------------------------- Avatar inserts
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (1, 'basic_green.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (2, 'basic_orange.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (3, 'basic_purple.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (4, 'glasses_green.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (5, 'glasses_orange.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (6, 'glasses_purple.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (7, 'hair_green.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (8, 'hair_orange.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath)
VALUES (9, 'hair_purple.svg');
-------------------------------------------------------------------------------------------------- User inserts
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid, isadmin)
VALUES (1, 'iuadmin@iu.iu', 'admin1', '$2y$12$9cqkVFs2HxdhzN0ZPp8/1uudWjvDZT5YJVI4euVIUJjgPazullhtm', 3, true);
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid)
VALUES (2, 'patryk@gmail.com', 'patryk', '$2a$12$AO9m5bhM66mJ6VYJmpcnDeyiB14EmM1FyDhP5plk6wAvSwD0YEirm', 1);
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid)
VALUES (4, 'none@proton.me', 'none', '$2y$12$d/MJQW2V0jQkYbLLJqZRpOHyH8Fcs4Bqh78i17oqhAASJjPEInV5K', 8);
--------------------------------------------------------------------------------------------------Type inserts
INSERT INTO public."Type" (typeid, name)
VALUES (1, 'button');
INSERT INTO public."Type" (typeid, name)
VALUES (2, 'input');
INSERT INTO public."Type" (typeid, name)
VALUES (3, 'checkbox');
INSERT INTO public."Type" (typeid, name)
VALUES (4, 'radio button');
--------------------------------------------------------------------------------------------------Color inserts
INSERT INTO public."Color" (colorid, hex)
VALUES (1, '00F0FF');
INSERT INTO public."Color" (colorid, hex)
VALUES (2, '13A823');
INSERT INTO public."Color" (colorid, hex)
VALUES (3, 'FFFFFF');
INSERT INTO public."Color" (colorid, hex)
VALUES (4, 'FF5733');
INSERT INTO public."Color" (colorid, hex)
VALUES (5, 'C70039');
INSERT INTO public."Color" (colorid, hex)
VALUES (6, '900C3F');
INSERT INTO public."Color" (colorid, hex)
VALUES (7, '581845');
INSERT INTO public."Color" (colorid, hex)
VALUES (8, 'DAF7A6');
INSERT INTO public."Color" (colorid, hex)
VALUES (9, '9f29e5');
INSERT INTO public."Color" (colorid, hex)
VALUES (10, 'd43ad4');
INSERT INTO public."Color" (colorid, hex)
VALUES (11, '6a5ed3');
INSERT INTO public."Color" (colorid, hex)
VALUES (12, '5ed398');
--------------------------------------------------------------------------------------------------Set inserts
INSERT INTO public."Set" (setid, name, ownerid)
VALUES (1, 'gradient', 4);
INSERT INTO public."Set" (setid, name, ownerid)
VALUES (2, 'others', 4);
INSERT INTO public."Set" (setid, name, ownerid)
VALUES (3, 'easy', 2);
--------------------------------------------------------------------------------------------------Tag inserts
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (1, 'simple', 1);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (2, 'fancy', 2);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (3, 'colorless', 3);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (4, 'responsive', 4);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (5, 'animated', 5);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (6, 'modest', 6);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (7, 'modern', 7);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (8, 'classic', 8);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (9, 'dark', 1);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (10, 'light', 2);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (11, 'flat', 3);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (12, 'gradient', 4);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (13, 'shadow', 5);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (14, 'bordered', 6);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (15, 'rounded', 7);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (16, 'outlined', 8);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (17, 'transparent', 1);
INSERT INTO public."Tag" (tagid, name, colorid)
VALUES (18, 'solid', 2);
--------------------------------------------------------------------------------------------------Component inserts
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (1, 'purple check', 1, 3, 9, e'.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
  border-radius: 5px;
}

.container {
  display: block;
  position: relative;
  cursor: pointer;
  font-size: 20px;
  user-select: none;
  border-radius: 5px;
  box-shadow: 2px 2px 0px rgb(183, 183, 183);
}

.checkmark {
  position: relative;
  top: 0;
  left: 0;
  height: 1.3em;
  width: 1.3em;
  background-color: #ccc;
  border-radius: 5px;
}

.container input:checked ~ .checkmark {
  box-shadow: 3px 3px 0px rgb(183, 183, 183);
  transition: all 0.2s;
  opacity: 1;
  background-image: linear-gradient(45deg, rgb(100, 61, 219) 0%, rgb(217, 21, 239) 100%);
}

.container input ~ .checkmark {
  transition: all 0.2s;
  opacity: 1;
  box-shadow: 1px 1px 0px rgb(183, 183, 183);
}

.checkmark:after {
  content: &quot;&quot;;
  position: absolute;
  opacity: 0;
  transition: all 0.2s;
}

.container input:checked ~ .checkmark:after {
  opacity: 1;
  transition: all 0.2s;
}

.container .checkmark:after {
  left: 0.45em;
  top: 0.25em;
  width: 0.25em;
  height: 0.5em;
  border: solid white;
  border-width: 0 0.15em 0.15em 0;
  transform: rotate(45deg);
}', e'&lt;label class=&quot;container&quot;&gt;
      &lt;input type=&quot;checkbox&quot; checked=&quot;checked&quot; /&gt;
      &lt;div class=&quot;checkmark&quot;&gt;&lt;/div&gt;
    &lt;/label&gt;', 4, '2025-01-12 13:47:04.369663');
--------------------------------------------------------------------------------------------------
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (2, 'keycap radio button', 2, 4, 3, e'.btn {
  font: inherit;
  background-color: #f0f0f0;
  border: 0;
  color: #242424;
  font-size: 1.15rem;
  padding: 0.375em 1em;
  text-shadow: 0 0.0625em 0 #fff;
  box-shadow: inset 0 0.0625em 0 0 #f4f4f4, 0 0.0625em 0 0 #efefef, 0 0.125em 0 0 #ececec, 0 0.25em 0 0 #e0e0e0, 0 0.3125em 0 0 #dedede, 0 0.375em 0 0 #dcdcdc,
    0 0.425em 0 0 #cacaca, 0 0.425em 0.5em 0 #cecece;
  transition: 0.23s ease;
  cursor: pointer;
  font-weight: bold;
  margin: -1px;
}
.middle {
  border-radius: 0px;
}
.right {
  border-top-right-radius: 0.5em;
  border-bottom-right-radius: 0.5em;
}
.left {
  border-top-left-radius: 0.5em;
  border-bottom-left-radius: 0.5em;
}
.btn:active {
  translate: 0 0.225em;
  box-shadow: inset 0 0.03em 0 0 #f4f4f4, 0 0.03em 0 0 #efefef, 0 0.0625em 0 0 #ececec, 0 0.125em 0 0 #e0e0e0, 0 0.125em 0 0 #dedede, 0 0.2em 0 0 #dcdcdc, 0 0.225em 0 0 #cacaca,
    0 0.225em 0.375em 0 #cecece;
  letter-spacing: 0.1em;
  color: skyblue;
}
.btn:focus {
  color: skyblue;
}', e'&lt;div class=&quot;btn-group&quot;&gt;
      &lt;button class=&quot;btn left&quot; type=&quot;button&quot;&gt;Left&lt;/button&gt;
      &lt;button class=&quot;btn middle&quot; type=&quot;button&quot;&gt;Middle&lt;/button&gt;
      &lt;button class=&quot;btn right&quot; type=&quot;button&quot;&gt;Right&lt;/button&gt;
    &lt;/div&gt;', 4, '2025-01-12 13:49:21.140628');
--------------------------------------------------------------------------------------------------
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (5, 'gradient text', 1, 2, 9, e'.gradient-border {
            border: 2px solid transparent;
            border-radius: 5px;
            background-image: linear-gradient(white, white), linear-gradient(45deg, rgb(100, 61, 219) 0%, rgb(217, 21, 239) 100%);
            background-origin: border-box;
            background-clip: content-box, border-box;
            padding: 5px;
            font-size: 16px;
            font-weight: bold;
            color: transparent;
            -webkit-background-clip: text;
            background-clip: text;
            background-image: linear-gradient(45deg, rgb(100, 61, 219) 0%, rgb(217, 21, 239) 100%);
        }',
        '&lt;input type=&quot;text&quot; class=&quot;gradient-border&quot; placeholder=&quot;Enter text here&quot;&gt;',
        4, '2025-01-12 14:00:50.977333');
--------------------------------------------------------------------------------------------------
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (6, 'gradient radio', 1, 4, 9, e'.gradient-radio {
            position: relative;
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid transparent;
            border-radius: 50%;
            background-image: linear-gradient(white, white), linear-gradient(45deg, rgb(100, 61, 219) 0%, rgb(217, 21, 239) 100%);
            background-origin: border-box;
            background-clip: content-box, border-box;
            vertical-align: middle;
            margin-right: 10px;
        }

        .gradient-radio input[type=&quot;radio&quot;] {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            margin: 0;
            cursor: pointer;
        }

        .gradient-radio input[type=&quot;radio&quot;]:checked + .checkmark {
            background-image: linear-gradient(45deg, rgb(100, 61, 219) 0%, rgb(217, 21, 239) 100%);
        }

        .checkmark {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: white;
        }', e'&lt;label class=&quot;gradient-radio&quot;&gt;
        &lt;input type=&quot;radio&quot; name=&quot;radio&quot;&gt;
        &lt;span class=&quot;checkmark&quot;&gt;&lt;/span&gt;
    &lt;/label&gt;
    &lt;label class=&quot;gradient-radio&quot;&gt;
        &lt;input type=&quot;radio&quot; name=&quot;radio&quot;&gt;
        &lt;span class=&quot;checkmark&quot;&gt;&lt;/span&gt;
    &lt;/label&gt;', 4, '2025-01-12 14:04:52.415996');
--------------------------------------------------------------------------------------------------
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (47, 'pink submit', 3, 1, 10, e'#submit-button {
  display: inline-flex;
  font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;
  width: 7.5em;
  height: 2em;
  font-size: 2rem;
  font-weight: 500;
  padding: 0.8rem 0.8rem;
  justify-content: center;
  align-items: center;
  gap: 0.625rem;
  border-radius: 0.8125rem;
  color: rgb(212, 58, 212);
  border: 3px solid rgb(212, 58, 212);
  background-color: inherit;
}

#submit-button:hover {
  background-color: rgb(212, 58, 212);
  color: #fff;
  cursor: pointer;
  border-color: #ffffff;
}', '&lt;button id=&quot;submit-button&quot;&gt;Submit&lt;/button&gt;', 2, '2025-01-12 13:54:00.663748');
--------------------------------------------------------------------------------------------------
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (53, 'purple submit', 3, 1, 11, e'#submit-button {
  display: inline-flex;
  font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;
  width: 7.5em;
  height: 2em;
  font-size: 2rem;
  font-weight: 500;
  padding: 0.8rem 0.8rem;
  justify-content: center;
  align-items: center;
  gap: 0.625rem;
  border-radius: 0.8125rem;
  color: #6a5ed3;
  border: 3px solid #6a5ed3;
  background-color: inherit;
}

#submit-button:hover {
  background-color: #6a5ed3;
  color: #fff;
  cursor: pointer;
  border-color: #ffffff;
}', '&lt;button id=&quot;submit-button&quot;&gt;Submit&lt;/button&gt;', 2, '2025-01-23 12:48:54.729399');
--------------------------------------------------------------------------------------------------
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (54, 'green submit', 3, 1, 12, e'#submit-button {
  display: inline-flex;
  font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;
  width: 7.5em;
  height: 2em;
  font-size: 2rem;
  font-weight: 500;
  padding: 0.8rem 0.8rem;
  justify-content: center;
  align-items: center;
  gap: 0.625rem;
  border-radius: 0.8125rem;
  color: #5ed398;
  border: 3px solid #5ed398;
  background-color: inherit;
}

#submit-button:hover {
  background-color: #5ed398;
  color: #000000;
  cursor: pointer;
  border-color: #000000;
}', '&lt;button id=&quot;submit-button&quot;&gt;Submit&lt;/button&gt;', 2, '2025-01-23 12:50:12.928597');
--------------------------------------------------------------------------------------------------
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat)
VALUES (55, 'green input', 3, 2, 12, e'#search_input {
  display: inline-flex;
  font-family: &quot;Segoe UI&quot;, Tahoma, Geneva, Verdana, sans-serif;
  width: 7.5em;
  height: 2em;
  font-size: 1rem;
  font-weight: 500;
  padding: 0.1rem 0.8rem;
  justify-content: center;
  align-items: center;
  gap: 0.625rem;
  border-radius: 0.8125rem;
  color: #5ed398;
  border: 3px solid #5ed398;
  background-color: inherit;
}

#search_input:focus {
  outline: none;
  border: 3px solid #5ed398;
}',
        '&lt;input name=&quot;text&quot; id=&quot;search_input&quot; type=&quot;text&quot; placeholder=&quot;Search&quot; /&gt;',
        2, '2025-01-23 12:57:35.674594');

--------------------------------------------------------------------------------------------------Component-Tag inserts
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (1, 12);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (1, 2);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (1, 7);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (2, 6);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (2, 13);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (2, 3);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (5, 12);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (5, 9);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (6, 12);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (6, 15);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (6, 2);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (53, 9);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (53, 1);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (54, 9);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (54, 1);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (55, 1);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (55, 9);
INSERT INTO public."ComponentTag" (componentid, tagid)
VALUES (55, 15);
--------------------------------------------------------------------------------------------------Likes inserts
INSERT INTO public."Likes" (userid, componentid, likedat)
VALUES (2, 5, '2025-01-17 15:48:30.070802');
INSERT INTO public."Likes" (userid, componentid, likedat)
VALUES (1, 1, '2025-01-17 16:32:57.245697');
INSERT INTO public."Likes" (userid, componentid, likedat)
VALUES (1, 5, '2025-01-17 16:32:57.806962');
INSERT INTO public."Likes" (userid, componentid, likedat)
VALUES (2, 2, '2025-01-18 16:05:15.519838');
INSERT INTO public."Likes" (userid, componentid, likedat)
VALUES (2, 1, '2025-01-20 18:52:07.011277');
INSERT INTO public."Likes" (userid, componentid, likedat)
VALUES (2, 6, '2025-01-21 18:32:24.644146');
--------------------------------------------------------------------------------------------------Reset sequence
SELECT setval(pg_get_serial_sequence('"User"', 'userid'), coalesce(max(userid) + 1, 1), false)
FROM "User";
SELECT setval(pg_get_serial_sequence('"Avatar"', 'avatarid'), coalesce(max(avatarid) + 1, 1), false)
FROM "Avatar";
SELECT setval(pg_get_serial_sequence('"Type"', 'typeid'), coalesce(max(typeid) + 1, 1), false)
FROM "Type";
SELECT setval(pg_get_serial_sequence('"Color"', 'colorid'), coalesce(max(colorid) + 1, 1), false)
FROM "Color";
SELECT setval(pg_get_serial_sequence('"Set"', 'setid'), coalesce(max(setid) + 1, 1), false)
FROM "Set";
SELECT setval(pg_get_serial_sequence('"Tag"', 'tagid'), coalesce(max(tagid) + 1, 1), false)
FROM "Tag";
SELECT setval(pg_get_serial_sequence('"Component"', 'componentid'), coalesce(max(componentid) + 1, 1), false)
FROM "Component";

-------------------------------------------------------------------------------------------------- Views
create view "UserDetailsView"(userid, nickname, email, passwordhash, avatarpath) as
SELECT u.userid,
       u.nickname,
       u.email,
       u.passwordhash,
       a.avatarpath
FROM "User" u
         LEFT JOIN "Avatar" a ON u.avatarid = a.avatarid;

alter table "UserDetailsView"
    owner to docker;
--------------------------------------------------------------------------------------------------
create view "ComponentTagsView"(componentid, tagid, name, hex) as
SELECT ct.componentid,
       t.tagid,
       t.name,
       c.hex
FROM "ComponentTag" ct
         JOIN "Tag" t USING (tagid)
         JOIN "Color" c USING (colorid);

alter table "ComponentTagsView"
    owner to docker;
--------------------------------------------------------------------------------------------------
create view "ComponentDetailsView"
            (componentid, name, authorid, nickname, hex, typename, setname, createdat, likes, tags, css, html) as
SELECT c.componentid,
       c.name,
       c.authorid,
       u.nickname,
       co.hex,
       t.name                                 AS typename,
       s.name                                 AS setname,
       c.createdat,
       (SELECT count(*) AS count
        FROM "Likes" l
        WHERE l.componentid = c.componentid)  AS likes,
       (SELECT string_agg(tg.name::text, ', '::text) AS string_agg
        FROM "ComponentTag" ct
                 JOIN "Tag" tg ON ct.tagid = tg.tagid
        WHERE ct.componentid = c.componentid) AS tags,
       c.css,
       c.html
FROM "Component" c
         LEFT JOIN "Color" co USING (colorid)
         LEFT JOIN "Set" s USING (setid)
         LEFT JOIN "Type" t USING (typeid)
         LEFT JOIN "User" u ON c.authorid = u.userid;

alter table "ComponentDetailsView"
    owner to docker;
-------------------------------------------------------------------------------------------------- Routines
create function add_user(emailn text, nickname text, passwordhash text, OUT success boolean) returns boolean
    language plpgsql
as
$$
DECLARE
    avatar INT;
BEGIN
    IF EXISTS (SELECT 1 FROM public."User" WHERE email = emailN) THEN
        success := FALSE;
        RETURN;
    END IF;

    SELECT avatarid INTO avatar FROM public."Avatar" ORDER BY RANDOM() LIMIT 1;

    INSERT INTO public."User" (email, nickname, passwordhash, avatarid)
    VALUES (emailN, nickname, passwordhash, avatar);

    success := TRUE;
END;
$$;
alter function add_user(text, text, text, out boolean) owner to docker;
--------------------------------------------------------------------------------------------------
create function add_user_session(user_id integer) returns text
    language plpgsql
as
$$
DECLARE
    session_token TEXT;
    count         INT;
BEGIN
    LOOP
        session_token := substring(md5(random()::text) from 1 for 16);
        SELECT COUNT(*) INTO count FROM public."UserSession" WHERE token = session_token;
        EXIT WHEN count = 0;
    END LOOP;

    INSERT INTO public."UserSession" (token, userID, expiresAt)
    VALUES (session_token, user_id, CURRENT_TIMESTAMP + INTERVAL '30 days');

    RETURN session_token;
END;
$$;
alter function add_user_session(integer) owner to docker;
--------------------------------------------------------------------------------------------------
create procedure admin_delete_component(IN comp_id integer, IN msg_id integer DEFAULT 0)
    language plpgsql
as
$$
BEGIN
    INSERT INTO "DeletedComponent" (componentid, name, css, html, authorid, messageid)
    SELECT componentid, name, css, html, authorid, msg_id
    FROM "Component"
    WHERE componentid = comp_id;

    DELETE
    FROM "Component"
    WHERE componentid = comp_id;

EXCEPTION
    WHEN OTHERS THEN
        RAISE;
END;
$$;
alter procedure admin_delete_component(integer, integer) owner to docker;
--------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------

