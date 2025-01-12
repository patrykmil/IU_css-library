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
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid) VALUES (2, 'patryk@gmail.com', 'patryk', '$2a$12$AO9m5bhM66mJ6VYJmpcnDeyiB14EmM1FyDhP5plk6wAvSwD0YEirm', 1);
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid) VALUES (3, 'none@proton.me', 'none', '$2y$12$d/MJQW2V0jQkYbLLJqZRpOHyH8Fcs4Bqh78i17oqhAASJjPEInV5K', 8);

--Type inserts
INSERT INTO public."Type" (typeid, name) VALUES (1, 'button');
INSERT INTO public."Type" (typeid, name) VALUES (2, 'input');
INSERT INTO public."Type" (typeid, name) VALUES (3, 'checkbox');
INSERT INTO public."Type" (typeid, name) VALUES (4, 'radio button');

--Color inserts
INSERT INTO public."Color" (colorid, hex) VALUES (1, '00F0FF');
INSERT INTO public."Color" (colorid, hex) VALUES (2, '13A823');
INSERT INTO public."Color" (colorid, hex) VALUES (3, 'FFFFFF');
INSERT INTO public."Color" (colorid, hex) VALUES (4, 'FF5733');
INSERT INTO public."Color" (colorid, hex) VALUES (5, 'C70039');
INSERT INTO public."Color" (colorid, hex) VALUES (6, '900C3F');
INSERT INTO public."Color" (colorid, hex) VALUES (7, '581845');
INSERT INTO public."Color" (colorid, hex) VALUES (8, 'DAF7A6');

--Tag inserts
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (1, 'simple', 1);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (2, 'fancy', 2);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (3, 'colorless', 3);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (4, 'responsive', 4);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (5, 'animated', 5);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (6, 'modest', 6);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (7, 'modern', 7);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (8, 'classic', 8);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (9, 'dark', 1);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (10, 'light', 2);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (11, 'flat', 3);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (12, 'gradient', 4);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (13, 'shadow', 5);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (14, 'bordered', 6);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (15, 'rounded', 7);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (16, 'outlined', 8);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (17, 'transparent', 1);
INSERT INTO public."Tag" (tagid, name, colorid) VALUES (18, 'solid', 2);

--Reset sequence
SELECT setval(pg_get_serial_sequence('"User"', 'userid'), coalesce(max(userid)+1, 1), false) FROM "User";
SELECT setval(pg_get_serial_sequence('"Avatar"', 'avatarid'), coalesce(max(avatarid)+1, 1), false) FROM "Avatar";
SELECT setval(pg_get_serial_sequence('"Type"', 'typeid'), coalesce(max(typeid)+1, 1), false) FROM "Type";
SELECT setval(pg_get_serial_sequence('"Color"', 'colorid'), coalesce(max(colorid)+1, 1), false) FROM "Color";
SELECT setval(pg_get_serial_sequence('"Set"', 'setid'), coalesce(max(setid)+1, 1), false) FROM "Set";
SELECT setval(pg_get_serial_sequence('"Tag"', 'tagid'), coalesce(max(tagid)+1, 1), false) FROM "Tag";
SELECT setval(pg_get_serial_sequence('"Component"', 'componentid'), coalesce(max(componentid)+1, 1), false) FROM "Component";
SELECT setval(pg_get_serial_sequence('"Bookmark"', 'bookmarkid'), coalesce(max(bookmarkid)+1, 1), false) FROM "Bookmark";