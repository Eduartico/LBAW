SET search_path TO lbaw2235;

DELETE FROM Attend CASCADE;
DELETE FROM Organizer CASCADE;
DELETE FROM Comment CASCADE;
DELETE FROM PostVote CASCADE;
DELETE FROM Post CASCADE;
DELETE FROM Invite CASCADE;
DELETE FROM Event CASCADE;
DELETE FROM Location CASCADE;
DELETE FROM PollVote CASCADE;
DELETE FROM Option CASCADE;
DELETE FROM Poll CASCADE;
DELETE FROM Notification CASCADE;
DELETE FROM lbaw2235.User CASCADE;
DELETE FROM CommentVote CASCADE;


INSERT INTO
    Location ( address, latitude,longitude)
VALUES
    ('5539 Anzinger Lane', 37.552470, 98.779710),
    ('03011 Anzinger Trail', 53.535410, 84.099330),
    ('28 Ronald Regan Trail', 26.368370, 44.317820),
    ('487 Vernon Plaza', 50.197630, 52.739830),
    ('9 Coolidge Court', 30.638890, 21.610150),
    ('8929 Red Cloud Avenue', 29.032530, 45.550190),
    ('66 Glendale Junction', -10.635190, 38.831390),
    ('932 Riverside Drive', 45.427590, -120.818870),
    ('3296 Steensland Street', 53.190790, -0.240780),
    ('494 Oak Park', 56.915180, 62.319850);

INSERT INTO
    lbaw2235.User (name, username, email, password, photo,is_admin)
VALUES
    ('[deleted]', '[deleted]', 'admin@lbaw.com', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', null, true);

INSERT INTO
    lbaw2235.User (name, username, email, password, photo)
VALUES
    ('Wilburt Arens', 'warens0', 'warens0@arstechnica.com', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'FaucibusCursusUrna.png'),
    ('Mordy Pulbrook', 'mpulbrook1', 'mpulbrook1@aboutads.info', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'OrciNullam.png'),
    ('Haleigh Brikner', 'hbrikner2', 'hbrikner2@webnode.com', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'LuctusUltriciesEu.jpg'),
    ('Brandea Boldra', 'bboldra3', 'bboldra3@spiegel.de', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'Quam.png'),
    ('Rozamond Jaquet', 'rjaquet4', 'rjaquet4@de.vu', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'UltricesPosuere.png'),
    ('Tailor Greatreax', 'tgreatreax5', 'tgreatreax5@youtu.be', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'Erat.jpg'),
    ('Ezra Sugarman', 'esugarman6', 'esugarman6@aboutads.info', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'EleifendPedeLibero.png'),
    ('Celie Croce', 'ccroce7', 'ccroce7@typepad.com', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'MattisOdioDonec.png'),
    ('Bing Swash', 'bswash8', 'bswash8@opera.com', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'PedeMalesuadaIn.png'),
    ('Carlo Olivazzi', 'colivazzi9', 'colivazzi9@baidu.com', '$2y$10$hH7kmQgqBd4BQez6fi2xquEudVeo3MaMEU01eDcqWQRPFqWGs/8/O', 'SemperSapienA.jpg');

INSERT INTO
    Event (name, description, location, category, ticket_price, status, owner_id, event_date, publish_date)
VALUES
    ('Dreams Evermore','description text', 1, 'Festival', 9.27, 'private', 4, '8/17/2023', '1/2/2022'),
    ('Organic Mania','description text', 2, 'Concert', 91.59, 'private', 7, '9/15/2027', '2/21/2022'),
    ('Prince Hand','description text', 3, 'Conference', 71.87, 'private', 3, '5/17/2024', '10/7/2021'),
    ('Fourplan Blue Meetings','description text', 4, 'Expo', 2.89, 'public', 1, '12/24/2023', '4/5/2021'),
    ('Amalgamated Up Sweet','description text', 5, 'Workshop', 73.52, 'public', 5, '6/5/2025', '1/25/2022'),
    ('Elegant Live Association','description text', 6, 'Politics', 79.36, 'private', 9, '10/20/2028', '4/16/2022'),
    ('Smart Celebration','description text', 7, 'Live TV', 96.82, 'private', 2, '12/28/2026', '10/20/2021'),
    ('Knox Black Connection','description text', 8, 'Protest', 38.42, 'private', 8, '7/21/2024', '7/10/2022'),
    ('Original It Parties','description text', 9, 'Exercise', 58.27, 'public', 6, '2/26/2027', '9/23/2021'),
    ('Star Eventments','description text', 10, 'Auction', 55.22, 'private', 10, '12/24/2023', '8/7/2021');

INSERT INTO
    Attend (user_id, event_id)
VALUES
    (1, 5),
    (7, 2),
    (3, 3),
    (10, 8),
    (5, 4),
    (9, 1),
    (7, 7),
    (2, 10),
    (9, 9),
    (4, 10);

INSERT INTO
    Organizer (user_id, event_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 5),
    (6, 6),
    (7, 7),
    (8, 8),
    (9, 9),
    (10, 10);

INSERT INTO
    Post ( owner_id, event_id,title, text, score, date, file)
VALUES
    (1, 6,'A', 'etiam faucibus cursus urna ut tellus nulla ut erat id mauris vulputate elementum nullam varius nulla facilisi cras non velit', 0, '3/6/2022', 'DapibusAugue.png'),
    (2, 2,'B', 'luctus et ultrices posuere cubilia curae duis faucibus accumsan odio curabitur convallis duis consequat dui nec nisi volutpat eleifend donec', 64, '9/23/2022', 'NuncVestibulumAnte.mp3'),
    (8, 3,'C', 'congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat', 0, '12/2/2021', 'Morbi.tiff'),
    (1, 4,'B', 'iaculis diam erat fermentum justo nec condimentum neque sapien placerat ante nulla justo', 32, '8/3/2022', 'ArcuAdipiscingMolestie.ppt'),
    (5, 3,'D', 'morbi quis tortor id nulla ultrices aliquet maecenas leo odio condimentum', 3, '11/7/2021', 'Libero.tiff'),
    (3, 10,'T', 'amet sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus', 86, '10/11/2022', 'MagnaVulputateLuctus.xls'),
    (7, 3,'qe', 'donec ut mauris eget massa tempor convallis nulla neque libero', 48, '6/7/2022', 'InLeo.tiff'),
    (10, 1,'sp', 'nunc rhoncus dui vel sem sed sagittis nam congue risus semper porta', 27, '1/24/2022', 'DolorVelEst.gif'),
    (9, 5,'en', 'dui luctus rutrum nulla tellus in sagittis dui vel nisl duis ac nibh fusce lacus purus', 0, '1/2/2022', 'SapienDignissimVestibulum.png'),
    (4, 10,'bv', 'quis tortor id nulla ultrices aliquet maecenas leo odio condimentum id luctus nec molestie sed justo', 8, '7/24/2022', 'In.ppt');

INSERT INTO
    Poll (owner_id, voter_count)
VALUES
    (1, 0),
    (2, 93),
    (3, 8),
    (4, 77),
    (5, 11),
    (6, 0),
    (7, 48),
    (8, 42),
    (9, 0),
    (10, 7);

INSERT INTO
    Option (poll_id, text, voter_count)
VALUES
    (1, 'ligula in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper purus sit amet nulla quisque', 27),
    (2, 'nam dui proin leo odio porttitor id consequat in consequat ut nulla sed accumsan felis ut at dolor quis odio', 1),
    (3, 'lorem id ligula suspendisse ornare consequat lectus in est risus auctor sed tristique in tempus sit amet sem fusce', 13),
    (4, 'sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit', 25),
    (5, 'eget vulputate ut ultrices vel augue vestibulum ante ipsum primis', 6),
    (6, 'pretium iaculis diam erat fermentum justo nec condimentum neque sapien', 0),
    (7, 'maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat dui', 81),
    (8, 'integer a nibh in quis justo maecenas rhoncus aliquam lacus morbi', 88),
    (9, 'tortor quis turpis sed ante vivamus tortor duis mattis egestas metus aenean fermentum donec ut mauris', 69),
    (10, 'lacinia eget tincidunt eget tempus vel pede morbi porttitor lorem id', 0);

INSERT INTO
    Comment (text, owner_id, parent_post)
VALUES
    ('proin at turpis a pede posuere nonummy integer non velit donec diam', 1, 1),
    ('amet erat nulla tempus vivamus in felis eu sapien cursus vestibulum proin eu mi nulla ac enim in tempor', 2, 2),
    ('metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec', 3, 3),
    ('arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc', 4, 4),
    ('sit amet nulla quisque arcu libero rutrum ac lobortis vel dapibus', 5, 5),
    ('ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare', 6, 6),
    ('proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum', 7, 7),
    ('eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed ante vivamus tortor duis mattis egestas', 8, 8),
    ('ut erat curabitur gravida nisi at nibh in hac habitasse', 9, 9),
    ('in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat', 10, 10);
INSERT INTO
    Invite (inviter, invited, event_id)
VALUES
    (1, 6, 1),
    (2, 1, 2),
    (3, 2, 3),
    (4, 9, 4),
    (5, 10, 5),
    (6, 3, 6),
    (7, 5, 7),
    (8, 4, 8),
    (9, 8, 9),
    (10, 7, 10);



INSERT INTO
    PollVote (poll_id, user_id, option_id)
VALUES
    (1, 1, 1),
    (2, 2, 2),
    (3, 3, 3),
    (4, 4, 4),
    (5, 5, 5),
    (6, 6, 6),
    (7, 7, 7),
    (8, 8, 8),
    (9, 9, 9),
    (10, 10, 10);

INSERT INTO
    PostVote (post_id, user_id, is_positive)
VALUES
    (1, 1, true),
    (2, 2, true),
    (3, 3, true),
    (4, 4, false),
    (5, 5, true),
    (6, 6, false),
    (7, 7, true),
    (8, 8, false),
    (9, 9, false),
    (10, 10, true);

INSERT INTO
    CommentVote (comment_id, user_id, is_positive)
VALUES
    (1, 1, false),
    (2, 2, false),
    (3, 3, true),
    (4, 4, false),
    (5, 5, false),
    (6, 6, false),
    (7, 7, true),
    (8, 8, false),
    (9, 9, false),
    (10, 10, true);