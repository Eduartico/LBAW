SET search_path TO lbaw2235;

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
-- Insert Post
CREATE FUNCTION insert_into_post (owner_id INT ,event_id INT,text text,score int ,date date,file text)
RETURNS VOID AS
$$begin;
    INSERT INTO Post ( owner_id, event_id, text, score, date, file)
    VALUES ( owner_id, event_id, text, score, date, file);
END;$$
LANGUAGE SQL;

CREATE FUNCTION insert_into_post (text text ,owner_id INT,parent_post INT,parent_comment int ,total_score int)
RETURNS VOID AS
$$begin;
    INSERT INTO Comment (text, owner_id, parent_post, parent_comment, total_score)
    VALUES (text, owner_id, currval(parent_post), parent_comment, total_score);
    END;$$
LANGUAGE SQL;

END TRANSACTION;

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;
-- Get number of current comment votes
SELECT COUNT(*)
FROM CommentVote, Comment
WHERE CommentVote.comment_id = Comment.id;
END TRANSACTION;

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;
-- Get number of current poll votes
SELECT *
FROM PollVote, Poll
WHERE PollVote.poll_id = Poll.id;
END TRANSACTION;

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;
-- Get number of current poll votes
SELECT COUNT(*)
FROM PostVote, Post
WHERE PostVote.post_id = Post.id;
END TRANSACTION;

BEGIN TRANSACTION;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE READ ONLY;
-- Get number of events
SELECT COUNT(*)
FROM Event
WHERE now() < event_date;
-- Get ending events (limit 10)
SELECT Event.id, Event.name, Event.location, Event.category, Event.ticket_price, status, owner_id, event_date, publish_date
FROM Event
INNER JOIN Location ON Event.location = Location.id
INNER JOIN User ON Event.owner_id = User.id
WHERE now () < Event.event_date
ORDER BY Event.event_date ASC
LIMIT 10;
END TRANSACTION;
