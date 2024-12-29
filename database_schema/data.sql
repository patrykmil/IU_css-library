truncate public."User" cascade;
truncate public."Avatar" cascade;
truncate public."Type" cascade;
truncate public."Color" cascade;
truncate public."Set" cascade;
truncate public."Tag" cascade;
truncate public."Component" cascade;
truncate public."ComponentTag" cascade;
truncate public."Likes" cascade;
truncate public."Bookmark" cascade;
truncate public."BookmarkComponent" cascade;

-- Avatar inserts
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (1, 'basic_green.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (2, 'basic_orange.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (3, 'basic_purple.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (4, 'glasses_green.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (5, 'glasses_orange.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (6, 'glasses_purple.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (7, 'hair_green.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (8, 'hair_orange.svg');
INSERT INTO public."Avatar" (avatarid, avatarpath) VALUES (9, 'hair_purple.svg');

-- User inserts
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid, isadmin) VALUES (1, 'iuadmin@iu.iu', 'admin1', '$2y$12$9cqkVFs2HxdhzN0ZPp8/1uudWjvDZT5YJVI4euVIUJjgPazullhtm', 3, true);
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid) VALUES (2, 'patryk@gmail.com', 'patryk', '$2a$12$dpeQ2M1m0kCa.QcLL8CTtespIjB2Do29Vih3X3QOjadM1jBmUDdWe', 1);
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid) VALUES (3, 'none@proton.me', 'none', '$2a$12$tHTVAWSwNysA8WW3gXGd6uBebCJFzDD/0r2NkO54vGUqlncxDXzz.', 8);

--Type inserts
INSERT INTO public."Type" (typeid, name) VALUES (1, 'button');
INSERT INTO public."Type" (typeid, name) VALUES (2, 'input');

--Color inserts
INSERT INTO public."Color" (colorid, hex) VALUES (1, '00F0FF');
INSERT INTO public."Color" (colorid, hex) VALUES (2, '13A823');
INSERT INTO public."Color" (colorid, hex) VALUES (3, 'FFFFFF');

--Set inserts
INSERT INTO public."Set" (setid, name, ownerid) VALUES (1, 'neon', 1);
INSERT INTO public."Set" (setid, name, ownerid) VALUES (2, 'basic', 2);
INSERT INTO public."Set" (setid, name, ownerid) VALUES (3, 'modern', 3);
INSERT INTO public."Set" (setid, name, ownerid) VALUES (4, 'pastel', 2);

--Tag inserts
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (1, 'simple', 1);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (2, 'fancy', 2);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (3, 'colorless', 3);

--Component inserts
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat) VALUES (1, 'button1', 1, 1, 1, 'button {background-color: red;}', '&lt;button&gt;Click me&lt;/button&gt;', 1, '2021-01-01 00:00:00');
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat) VALUES (2, 'button2', 1, 1, 2, 'button {background-color: green;}', '&lt;button&gt;Click me&lt;/button&gt;', 1, '2021-01-01 00:00:00');
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat) VALUES (3, 'input1', 3, 2, 3, 'input {background-color: blue;}', '&lt;input&gt;', 1, '2021-01-01 00:00:00');
INSERT INTO public."Component" (componentid, name, setid, typeid, colorid, css, html, authorid, createdat) VALUES (4, 'button3', 2, 1, 1, 'button {background-color: red;}', '&lt;button&gt;Click me&lt;/button&gt;', 2, '2021-01-01 00:00:00');

--ComponentTag inserts
INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (1, 1);
INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (1, 3);
INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (2, 2);
INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (3, 3);
INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (4, 1);
INSERT INTO public."ComponentTag" (componentid, tagid) VALUES (4, 2);

--Likes inserts
INSERT INTO public."Likes" (componentid, userid) VALUES (1, 2);
INSERT INTO public."Likes" (componentid, userid) VALUES (1, 3);
INSERT INTO public."Likes" (componentid, userid) VALUES (2, 2);
INSERT INTO public."Likes" (componentid, userid) VALUES (3, 3);
INSERT INTO public."Likes" (componentid, userid) VALUES (4, 2);


--Bookmark inserts
INSERT INTO public."Bookmark" (bookmarkid, userid, name) VALUES (1, 2, 'To remember!');
INSERT INTO public."Bookmark" (bookmarkid, userid, name) VALUES (2, 3, 'Saved for later');
INSERT INTO public."Bookmark" (bookmarkid, userid, name) VALUES (3, 2, 'For work project');

--BookmarkComponent inserts
INSERT INTO public."BookmarkComponent" (bookmarkid, componentid) VALUES (1, 1);
INSERT INTO public."BookmarkComponent" (bookmarkid, componentid) VALUES (1, 2);
INSERT INTO public."BookmarkComponent" (bookmarkid, componentid) VALUES (2, 3);
INSERT INTO public."BookmarkComponent" (bookmarkid, componentid) VALUES (3, 4);

--Reset sequence
SELECT setval(pg_get_serial_sequence('"User"', 'userid'), coalesce(max(userid)+1, 1), false) FROM "User";
SELECT setval(pg_get_serial_sequence('"Avatar"', 'avatarid'), coalesce(max(avatarid)+1, 1), false) FROM "Avatar";
SELECT setval(pg_get_serial_sequence('"Type"', 'typeid'), coalesce(max(typeid)+1, 1), false) FROM "Type";
SELECT setval(pg_get_serial_sequence('"Color"', 'colorid'), coalesce(max(colorid)+1, 1), false) FROM "Color";
SELECT setval(pg_get_serial_sequence('"Set"', 'setid'), coalesce(max(setid)+1, 1), false) FROM "Set";
SELECT setval(pg_get_serial_sequence('"Tag"', 'tagid'), coalesce(max(tagid)+1, 1), false) FROM "Tag";
SELECT setval(pg_get_serial_sequence('"Component"', 'componentid'), coalesce(max(componentid)+1, 1), false) FROM "Component";
SELECT setval(pg_get_serial_sequence('"Bookmark"', 'bookmarkid'), coalesce(max(bookmarkid)+1, 1), false) FROM "Bookmark";