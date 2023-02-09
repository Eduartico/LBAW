SET search_path TO lbaw2235;

DROP TABLE IF EXISTS Location CASCADE;
DROP TABLE IF EXISTS Event CASCADE;
DROP TABLE IF EXISTS Post CASCADE;
DROP TABLE IF EXISTS Poll CASCADE;
DROP TABLE IF EXISTS Option CASCADE;
DROP TABLE IF EXISTS Comment CASCADE;
DROP TABLE IF EXISTS lbaw2235.user CASCADE;
DROP TABLE IF EXISTS Attend CASCADE;
DROP TABLE IF EXISTS Organizer CASCADE;
DROP TABLE IF EXISTS Invite CASCADE;
DROP TABLE IF EXISTS Notification CASCADE;
DROP TABLE IF EXISTS PollVote CASCADE;
DROP TABLE IF EXISTS PostVote CASCADE;
DROP TABLE IF EXISTS CommentVote CASCADE;
DROP TABLE IF EXISTS EventReport CASCADE;
DROP TABLE IF EXISTS PostReport CASCADE;
DROP TABLE IF EXISTS CommentReport CASCADE;
DROP TYPE IF EXISTS status CASCADE;


CREATE TYPE status AS ENUM ('public','private','banned','cancelled','postponed');

CREATE TABLE Location
(
    id          SERIAL      NOT NULL PRIMARY KEY,
    address     CHAR(255)   NOT NULL,
    longitude   FLOAT       NOT NULL,
    latitude    FLOAT       NOT NULL,
    address_FTS TSVECTOR
);


CREATE TABLE lbaw2235.user
(
    id              SERIAL  NOT NULL PRIMARY KEY,
    name            TEXT    NOT NULL,
    remember_token  TEXT,
    username        TEXT    NOT NULL UNIQUE,
    email           TEXT    NOT NULL UNIQUE,
    password        TEXT    NOT NULL,
    photo           TEXT,
    is_admin        BOOLEAN NOT NULL DEFAULT FALSE
);
CREATE TABLE Event
(
    id              SERIAL        NOT NULL PRIMARY KEY,
    name            CHAR(255)     NOT NULL,
    description     TEXT          NOT NULL, --NEEDS FULL TXT SEARCH TRIGGER UPDATE
    location_id     INTEGER       NOT NULL REFERENCES Location(id),
    category        CHAR(255)     NOT NULL,
    ticket_price    DECIMAL(8, 2) NOT NULL DEFAULT 0,
    status          status        NOT NULL DEFAULT 'private',
    owner_id        INTEGER       NOT NULL REFERENCES lbaw2235.user(id),
    event_date      DATE          NOT NULL CHECK ( event_date >= now() ),
    publish_date    DATE          NOT NULL CHECK ( publish_date <= now()),
    reports         INTEGER       NOT NULL DEFAULT 0,
    attendee_count  INTEGER       NOT NULL DEFAULT 0, -- NEEDS TRIGGERS TO UPDATE
    image           TEXT,
    name_FTS        tsvector,
    description_FTS tsvector
);

CREATE TABLE Attend
(
    user_id     INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    event_id    INTEGER NOT NULL REFERENCES Event(id),
    is_private  BOOLEAN NOT NULL DEFAULT FALSE,
    PRIMARY KEY (user_id, event_id)
);
CREATE TABLE Organizer
(
    user_id  INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    event_id INTEGER NOT NULL REFERENCES Event(id),
    PRIMARY KEY (user_id, event_id)
);
CREATE TABLE Post
(
    id          SERIAL      NOT NULL PRIMARY KEY,
    owner_id    INTEGER     NOT NULL REFERENCES lbaw2235.user(id),
    event_id    INTEGER     NOT NULL REFERENCES Event(id),
    title       TEXT        NOT NULL, --NEEDS TO UPDATE TRIGGER FOR FULL TXT SEARCH
    text        TEXT,
    score       INTEGER     NOT NULL DEFAULT 0,
    reports     INTEGER     NOT NULL DEFAULT 0,
    date        TIMESTAMP   NOT NULL DEFAULT now(),
    file        TEXT
);
CREATE TABLE Poll
(
    id          SERIAL  NOT NULL PRIMARY KEY,
    post_id    INTEGER NOT NULL REFERENCES Post(id),
    voter_count INTEGER NOT NULL DEFAULT 0
);
CREATE TABLE Option
(
    id          SERIAL  NOT NULL PRIMARY KEY,
    poll_id     INTEGER NOT NULL REFERENCES Poll(id),
    text        TEXT    NOT NULL,
    voter_count INTEGER NOT NULL DEFAULT 0
);
CREATE TABLE Comment
(
    id              SERIAL  NOT NULL    PRIMARY KEY ,
    text            TEXT    NOT NULL,
    owner_id        INTEGER NOT NULL    REFERENCES lbaw2235.user(id),
    parent_post     INTEGER NOT NULL    REFERENCES Post(id),
    parent_comment  INTEGER             REFERENCES Comment(id),
    total_score     INTEGER NOT NULL    default 0,
    reports         INTEGER NOT NULL    default 0
);
CREATE TABLE Invite
(
    inviter  INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    invited  INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    event_id INTEGER NOT NULL REFERENCES Event(id),
    check ( Invite.invited != Invite.inviter ),
    PRIMARY KEY (inviter, invited, event_id)
);
CREATE TABLE Notification
(
    id      SERIAL      NOT NULL PRIMARY KEY,
    user_id INTEGER     NOT NULL REFERENCES lbaw2235.user(id),
    date    TIMESTAMP   NOT NULL DEFAULT NOW(),
    text    TEXT        NOT NULL
);
CREATE TABLE PollVote
(
    poll_id     INTEGER NOT NULL REFERENCES  Poll(id),
    user_id     INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    option_id   INTEGER NOT NULL REFERENCES Option(id),
    PRIMARY KEY (poll_id, user_id)
);
CREATE TABLE PostVote
(
    post_id     INTEGER NOT NULL REFERENCES Post(id),
    user_id     INTEGER NOT NULL REFERENCES  lbaw2235.user(id),
    is_positive BOOLEAN NOT NULL,
    PRIMARY KEY (post_id,user_id)
);
CREATE TABLE CommentVote
(
    comment_id  INTEGER NOT NULL REFERENCES Comment(id),
    user_id     INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    is_positive BOOLEAN NOT NULL,
    PRIMARY KEY (comment_id,user_id)
);

CREATE TABLE EventReport(
    user_id INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    event_id INTEGER NOT NULL REFERENCES Event(id),
    PRIMARY KEY(user_id,event_id)
);

CREATE TABLE PostReport(
    user_id INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    post_id INTEGER NOT NULL REFERENCES Post(id),
    PRIMARY KEY(user_id,post_id)
);

CREATE TABLE CommentReport(
    user_id INTEGER NOT NULL REFERENCES lbaw2235.user(id),
    comment_id INTEGER NOT NULL REFERENCES Comment(id),
    PRIMARY KEY(user_id,comment_id)
);