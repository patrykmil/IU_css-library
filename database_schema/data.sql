truncate public."User" cascade;
truncate public."Avatar" cascade;

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
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid) VALUES (1, 'iuadmin@iu.iu', 'admin1', '$2y$12$9cqkVFs2HxdhzN0ZPp8/1uudWjvDZT5YJVI4euVIUJjgPazullhtm', 3);
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid) VALUES (2, 'patryk@gmail.com', 'patryk', '$2a$12$dpeQ2M1m0kCa.QcLL8CTtespIjB2Do29Vih3X3QOjadM1jBmUDdWe', 1);
INSERT INTO public."User" (userid, email, nickname, passwordhash, avatarid) VALUES (3, 'none@proton.me', 'none', '$2a$12$tHTVAWSwNysA8WW3gXGd6uBebCJFzDD/0r2NkO54vGUqlncxDXzz.', 8);

