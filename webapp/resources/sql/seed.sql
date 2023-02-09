SET search_path TO lbaw2235;

-- Drop --
DROP TABLE IF EXISTS "Location" CASCADE;
DROP TABLE IF EXISTS "Event" CASCADE;
DROP TABLE IF EXISTS "Post" CASCADE;
DROP TABLE IF EXISTS "Poll" CASCADE;
DROP TABLE IF EXISTS "Option" CASCADE;
DROP TABLE IF EXISTS "Comment" CASCADE;
DROP TABLE IF EXISTS "lbaw2235.User" CASCADE;
DROP TABLE IF EXISTS "Attend" CASCADE;
DROP TABLE IF EXISTS "Organizer" CASCADE;
DROP TABLE IF EXISTS "Invite" CASCADE;
DROP TABLE IF EXISTS "Notification" CASCADE;
DROP TABLE IF EXISTS "PollVote" CASCADE;
DROP TABLE IF EXISTS "PostVote" CASCADE;
DROP TABLE IF EXISTS "CommentVote" CASCADE;
DROP TYPE IF EXISTS "status" CASCADE;


-- Types --
CREATE TYPE "status" AS ENUM ('public','private','banned');

-- Tables --
CREATE TABLE "Location"
(
    id SERIAL NOT NULL PRIMARY KEY,
    address CHAR(255) NOT NULL,
    longitude FLOAT NOT NULL,
    latitude FLOAT NOT NULL,
    address_FTS TSVECTOR
);


CREATE TABLE "lbaw2235.User"
(
    id       SERIAL  NOT NULL PRIMARY KEY,
    name     TEXT    NOT NULL,
    remember_token     TEXT   ,
    username TEXT    NOT NULL UNIQUE,
    email    TEXT    NOT NULL UNIQUE,
    password TEXT    NOT NULL,
    photo    TEXT    ,
    is_admin  BOOLEAN NOT NULL DEFAULT FALSE

);
CREATE TABLE "Event"
(
    id           SERIAL        NOT NULL PRIMARY KEY,
    name         CHAR(255)     NOT NULL,
    location     INTEGER       NOT NULL REFERENCES Location(id),
    category     CHAR(255)     NOT NULL,
    ticket_price DECIMAL(8, 2) NOT NULL DEFAULT 0,
    status       "status"      NOT NULL DEFAULT 'private',
    owner_id     INTEGER       NOT NULL REFERENCES "lbaw2235.User"(id),
    event_date   DATE          NOT NULL CHECK ( event_date >= NOW() ),
    publish_date DATE          NOT NULL CHECK ( publish_date <= now()),
    name_FTS     tsvector
);

CREATE TABLE "Attend"
(
    user_id  INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    event_id INTEGER NOT NULL REFERENCES "Event"(id),
    PRIMARY KEY (user_id, event_id)
);
CREATE TABLE "Organizer"
(
    user_id  INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    event_id INTEGER NOT NULL REFERENCES "Event"(id),
    PRIMARY KEY (user_id, event_id)
);
CREATE TABLE "Post"
(
    id       SERIAL NOT NULL PRIMARY KEY,
    owner_id INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    event_id INTEGER NOT NULL REFERENCES "Event"(id),
    text     TEXT    NOT NULL,
    score    INTEGER NOT NULL DEFAULT 0,
    date     DATE    NOT NULL DEFAULT now(),
    file     TEXT    ,
    text_FTS tsvector
);

CREATE TABLE "Poll"
(
    id          SERIAL NOT NULL PRIMARY KEY,
    owner_id    INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    voter_count INTEGER NOT NULL DEFAULT 0
);
CREATE TABLE "Option"
(
    id          SERIAL NOT NULL PRIMARY KEY,
    poll_id     INTEGER NOT NULL REFERENCES "Poll"(id),
    text        TEXT    NOT NULL,
    voter_count INTEGER NOT NULL DEFAULT 0
);
CREATE TABLE "Comment"
(
    id             SERIAL NOT NULL PRIMARY KEY ,
    text           TEXT    NOT NULL,
    owner_id        INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    parent_post    INTEGER NOT NULL REFERENCES "Post"(id),
    parent_comment INTEGER REFERENCES "Comment"(id),
    total_score    INTEGER NOT NULL default 0
);
CREATE TABLE "Invite"
(
    inviter  INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    invited  INTEGER NOT NULL REFERENCES "lbaw2235.User"(id)
        check (invited != inviter ),
    event_id INTEGER NOT NULL REFERENCES "Event"(id),
    PRIMARY KEY (inviter, invited, event_id)
);
CREATE TABLE "Notification"
(
    id      SERIAL NOT NULL PRIMARY KEY,
    user_id INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    date    DATE    NOT NULL DEFAULT now(),
    text    TEXT    NOT NULL
);
CREATE TABLE "PollVote"
(
    poll_id     INTEGER NOT NULL REFERENCES "Poll"(id),
    user_id     INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    option_id     INTEGER NOT NULL REFERENCES "Option"(id),
    PRIMARY KEY (poll_id, User_id)
);
CREATE TABLE "PostVote"
(
    post_id     INTEGER NOT NULL REFERENCES "Post"(id),
    user_id     INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    is_positive BOOLEAN NOT NULL,
    PRIMARY KEY (post_id,user_id)
);
CREATE TABLE "CommentVote"
(
    comment_id  INTEGER NOT NULL REFERENCES "Comment"(id),
    user_id     INTEGER NOT NULL REFERENCES "lbaw2235.User"(id),
    is_positive BOOLEAN NOT NULL,
    PRIMARY KEY (comment_id,user_id)
);
-- Indexes --

-- Triggers --

-- Population --
INSERT INTO
    "Location" (id, address, latitude, longitude)
VALUES
    (1, '5539 Anzinger Lane', 37.552470, 98.779710),
    (2, '03011 Anzinger Trail', 53.535410, 84.099330),
    (3, '28 Ronald Regan Trail', 26.368370, 44.317820),
    (4, '487 Vernon Plaza', 50.197630, 52.739830),
    (5, '9 Coolidge Court', 30.638890, 21.610150),
    (6, '8929 Red Cloud Avenue', 29.032530, 45.550190),
    (7, '66 Glendale Junction', -10.635190, 38.831390),
    (8, '932 Riverside Drive', 45.427590, -120.818870),
    (9, '3296 Steensland Street', 53.190790, -0.240780),
    (10, '494 Oak Park', 56.915180, 62.319850);

INSERT INTO
    "lbaw2235.User" (id, name, username, email, password, photo, is_admin)
VALUES
    (0, 'Tico Meria', 'admin', 'admin@lbaw.com', '1234', 'FaucibusCursusUrna.png', true),
    (1, 'Wilburt Arens', 'warens0', 'warens0@arstechnica.com', '4800mSY', 'FaucibusCursusUrna.png', false),
    (2, 'Mordy Pulbrook', 'mpulbrook1', 'mpulbrook1@aboutads.info', 'gmVNcdL0WhIw', 'OrciNullam.png', false),
    (3, 'Haleigh Brikner', 'hbrikner2', 'hbrikner2@webnode.com', 'kKOd6H7O4O', 'LuctusUltriciesEu.jpg', false),
    (4, 'Brandea Boldra', 'bboldra3', 'bboldra3@spiegel.de', 'BFTPNY', 'Quam.png', false),
    (5, 'Rozamond Jaquet', 'rjaquet4', 'rjaquet4@de.vu', 'sSSqvDw20', 'UltricesPosuere.png', false),
    (6, 'Tailor Greatreax', 'tgreatreax5', 'tgreatreax5@youtu.be', '7CIIMcPCzCEj', 'Erat.jpg', false),
    (7, 'Ezra Sugarman', 'esugarman6', 'esugarman6@aboutads.info', 'xHcoGBvY', 'EleifendPedeLibero.png', false),
    (8, 'Celie Croce', 'ccroce7', 'ccroce7@typepad.com', '1NAEfohde5', 'MattisOdioDonec.png', false),
    (9, 'Bing Swash', 'bswash8', 'bswash8@opera.com', 'Pr34Hjlbkf', 'PedeMalesuadaIn.png', false),
    (10, 'Carlo Olivazzi', 'colivazzi9', 'colivazzi9@baidu.com', 'mj1ep1CJknN', 'SemperSapienA.jpg', false);

INSERT INTO
    "Event" (id, name, location, category, ticket_price, status, owner_id, event_date, publish_date)
VALUES
    (1, 'Dreams Evermore', 1, 'Festival', 9.27, 'private', 4, '8/17/2023', '1/2/2022'),
    (2, 'Organic Mania', 2, 'Concert', 91.59, 'private', 7, '9/15/2027', '2/21/2022'),
    (3, 'Prince Hand', 3, 'Conference', 71.87, 'private', 3, '5/17/2024', '10/7/2021'),
    (4, 'Fourplan Blue Meetings', 4, 'Expo', 2.89, 'public', 1, '12/24/2022', '4/5/2021'),
    (5, 'Amalgamated Up Sweet', 5, 'Workshop', 73.52, 'public', 5, '6/5/2025', '1/25/2022'),
    (6, 'Elegant Live Association', 6, 'Politics', 79.36, 'private', 9, '10/20/2028', '4/16/2022'),
    (7, 'Smart Celebration', 7, 'Live TV', 96.82, 'private', 2, '12/28/2026', '10/20/2021'),
    (8, 'Knox Black Connection', 8, 'Protest', 38.42, 'private', 8, '7/21/2024', '7/10/2022'),
    (9, 'Original It Parties', 9, 'Exercise', 58.27, 'public', 6, '2/26/2027', '9/23/2021'),
    (10, 'Star Eventments', 10, 'Auction', 55.22, 'private', 10, '12/24/2022', '8/7/2021');

INSERT INTO
    "Attend" (user_id, event_id)
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
    "Organizer" (user_id, event_id)
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
    "Post" (id, owner_id, event_id, text, score, date, file)
VALUES
    (1, 1, 6, 'etiam faucibus cursus urna ut tellus nulla ut erat id mauris vulputate elementum nullam varius nulla facilisi cras non velit', 0, '3/6/2022', 'DapibusAugue.png'),
    (2, 2, 2, 'luctus et ultrices posuere cubilia curae duis faucibus accumsan odio curabitur convallis duis consequat dui nec nisi volutpat eleifend donec', 64, '9/23/2022', 'NuncVestibulumAnte.mp3'),
    (3, 8, 3, 'congue diam id ornare imperdiet sapien urna pretium nisl ut volutpat', 0, '12/2/2021', 'Morbi.tiff'),
    (4, 1, 4, 'iaculis diam erat fermentum justo nec condimentum neque sapien placerat ante nulla justo', 32, '8/3/2022', 'ArcuAdipiscingMolestie.ppt'),
    (5, 5, 3, 'morbi quis tortor id nulla ultrices aliquet maecenas leo odio condimentum', 3, '11/7/2021', 'Libero.tiff'),
    (6, 3, 10, 'amet sapien dignissim vestibulum vestibulum ante ipsum primis in faucibus', 86, '10/11/2022', 'MagnaVulputateLuctus.xls'),
    (7, 7, 3, 'donec ut mauris eget massa tempor convallis nulla neque libero', 48, '6/7/2022', 'InLeo.tiff'),
    (8, 10, 1, 'nunc rhoncus dui vel sem sed sagittis nam congue risus semper porta', 27, '1/24/2022', 'DolorVelEst.gif'),
    (9, 9, 5, 'dui luctus rutrum nulla tellus in sagittis dui vel nisl duis ac nibh fusce lacus purus', 0, '1/2/2022', 'SapienDignissimVestibulum.png'),
    (10, 4, 10, 'quis tortor id nulla ultrices aliquet maecenas leo odio condimentum id luctus nec molestie sed justo', 8, '7/24/2022', 'In.ppt');

INSERT INTO
    "Poll" (id, owner_id, voter_count)
VALUES
    (1, 1, 0),
    (2, 2, 93),
    (3, 3, 8),
    (4, 4, 77),
    (5, 5, 11),
    (6, 6, 0),
    (7, 7, 48),
    (8, 8, 42),
    (9, 9, 0),
    (10, 10, 7);

INSERT INTO
    "Option" (id, poll_id, text, voter_count)
VALUES
    (1, 1, 'ligula in lacus curabitur at ipsum ac tellus semper interdum mauris ullamcorper purus sit amet nulla quisque', 27),
    (2, 2, 'nam dui proin leo odio porttitor id consequat in consequat ut nulla sed accumsan felis ut at dolor quis odio', 1),
    (3, 3, 'lorem id ligula suspendisse ornare consequat lectus in est risus auctor sed tristique in tempus sit amet sem fusce', 13),
    (4, 4, 'sem duis aliquam convallis nunc proin at turpis a pede posuere nonummy integer non velit', 25),
    (5, 5, 'eget vulputate ut ultrices vel augue vestibulum ante ipsum primis', 6),
    (6, 6, 'pretium iaculis diam erat fermentum justo nec condimentum neque sapien', 0),
    (7, 7, 'maecenas leo odio condimentum id luctus nec molestie sed justo pellentesque viverra pede ac diam cras pellentesque volutpat dui', 81),
    (8, 8, 'integer a nibh in quis justo maecenas rhoncus aliquam lacus morbi', 88),
    (9, 9, 'tortor quis turpis sed ante vivamus tortor duis mattis egestas metus aenean fermentum donec ut mauris', 69),
    (10, 10, 'lacinia eget tincidunt eget tempus vel pede morbi porttitor lorem id', 0);

INSERT INTO
    "Comment" (id, text, owner_id, parent_post, parent_comment, total_score)
VALUES
    (1, 'proin at turpis a pede posuere nonummy integer non velit donec diam', 1, 1, 1, 0),
    (2, 'amet erat nulla tempus vivamus in felis eu sapien cursus vestibulum proin eu mi nulla ac enim in tempor', 2, 2, 2, 6),
    (3, 'metus arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc donec', 3, 3, 3, 86),
    (4, 'arcu adipiscing molestie hendrerit at vulputate vitae nisl aenean lectus pellentesque eget nunc', 4, 4, 4, 41),
    (5, 'sit amet nulla quisque arcu libero rutrum ac lobortis vel dapibus', 5, 5, 5, 23),
    (6, 'ut suscipit a feugiat et eros vestibulum ac est lacinia nisi venenatis tristique fusce congue diam id ornare', 6, 6, 6, 2),
    (7, 'proin at turpis a pede posuere nonummy integer non velit donec diam neque vestibulum', 7, 7, 7, 2),
    (8, 'eget elit sodales scelerisque mauris sit amet eros suspendisse accumsan tortor quis turpis sed ante vivamus tortor duis mattis egestas', 8, 8, 8, 32),
    (9, 'ut erat curabitur gravida nisi at nibh in hac habitasse', 9, 9, 9, 0),
    (10, 'in hac habitasse platea dictumst morbi vestibulum velit id pretium iaculis diam erat', 10, 10, 10, 17);

INSERT INTO
    "Invite" (inviter, invited, event_id)
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
    "PollVote" (poll_id, user_id, option_id)
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
    "PostVote" (post_id, user_id, is_positive)
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
    "CommentVote" (comment_id, user_id, is_positive)
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
