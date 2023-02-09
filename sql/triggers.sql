SET search_path TO lbaw2235;

DROP TRIGGER IF EXISTS tr_post_vote_notification ON PostVote CASCADE;
DROP TRIGGER IF EXISTS tr_poll_vote_notification ON PollVote CASCADE;
DROP TRIGGER IF EXISTS tr_invitation_notification ON Invite CASCADE;
DROP TRIGGER IF EXISTS tr_comment_vote_notification ON CommentVote CASCADE;
DROP TRIGGER IF EXISTS tr_update_poll_vote_count ON PollVote CASCADE;
DROP TRIGGER IF EXISTS tr_update_poll_option_vote_count ON PollVote CASCADE;
DROP TRIGGER IF EXISTS tr_update_post_score ON PostVote CASCADE;
DROP TRIGGER IF EXISTS tr_update_comment_score ON CommentVote CASCADE;
DROP TRIGGER IF EXISTS tr_post_search ON Post CASCADE;
DROP TRIGGER IF EXISTS tr_event_search ON Event CASCADE;
DROP TRIGGER IF EXISTS tr_location_search ON Location CASCADE;
Drop TRIGGER IF EXISTS tr_event_description_search ON Event CASCADE;
Drop TRIGGER IF EXISTS tr_event_name_search ON Event CASCADE;
DROP TRIGGER IF EXISTS tr_update_event_report_count ON EventReport CASCADE;
DROP TRIGGER IF EXISTS tr_update_post_report_count ON PostReport CASCADE;
DROP TRIGGER IF EXISTS tr_update_comment_report_count ON CommentReport CASCADE;

DROP FUNCTION IF EXISTS new_post_vote_notification();
DROP FUNCTION IF EXISTS new_poll_vote_notification();
DROP FUNCTION IF EXISTS new_invitation_notification();
DROP FUNCTION IF EXISTS new_comment_vote_notification();
DROP FUNCTION IF EXISTS update_poll_vote_count();
DROP FUNCTION IF EXISTS update_poll_option_vote_count();
DROP FUNCTION IF EXISTS update_post_score() CASCADE;
DROP FUNCTION IF EXISTS update_comment_score();
DROP FUNCTION IF EXISTS post_search();
DROP FUNCTION IF EXISTS event_search();
DROP FUNCTION IF EXISTS location_search();
DROP FUNCTION IF EXISTS event_description_search();
DROP FUNCTION IF EXISTS event_name_search();
DROP FUNCTION IF EXISTS update_event_report_count();
DROP FUNCTION IF EXISTS update_post_report_count();
DROP FUNCTION IF EXISTS update_comment_report_count();

CREATE OR REPLACE FUNCTION update_comment_report_count()
    RETURNS TRIGGER AS
$$BEGIN
    IF tg_op = 'INSERT' THEN
        UPDATE Event
        SET reports = (SELECT reports from comment where id = new.comment_id) + 1
        WHERE id = new.comment_id;
    END IF;
    IF tg_op = 'DELETE' THEN
        UPDATE Event
        SET reports = (SELECT reports from Event where id = new.comment_id) - 1
        WHERE id = new.comment_id;
    END IF;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_comment_report_count
    AFTER INSERT OR DELETE ON CommentReport
    FOR EACH ROW
EXECUTE PROCEDURE update_comment_report_count();



CREATE OR REPLACE FUNCTION update_post_report_count()
    RETURNS TRIGGER AS
$$BEGIN
    IF tg_op = 'INSERT' THEN
        UPDATE Event
        SET reports = (SELECT reports from post where id = new.post_id) + 1
        WHERE id = new.post_id;
    END IF;
    IF tg_op = 'DELETE' THEN
        UPDATE Event
        SET reports = (SELECT reports from post where id = new.post_id) - 1
        WHERE id = new.post_id;
    END IF;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_post_report_count
    AFTER INSERT OR DELETE ON PostReport
    FOR EACH ROW
EXECUTE PROCEDURE update_post_report_count();



CREATE OR REPLACE FUNCTION update_event_report_count()
    RETURNS TRIGGER AS
$$BEGIN
    IF tg_op = 'INSERT' THEN
        UPDATE Event
        SET reports = (SELECT reports from Event where id = new.event_id) + 1
        WHERE id = new.event_id;
    END IF;
    IF tg_op = 'DELETE' THEN
        UPDATE Event
        SET report = (SELECT report from Event where id = new.event_id) - 1
        WHERE id = new.event_id;
    END IF;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_event_report_count
    AFTER INSERT OR DELETE ON EventReport
    FOR EACH ROW
EXECUTE PROCEDURE update_event_report_count();



CREATE OR REPLACE FUNCTION update_event_attendee_count()
    RETURNS TRIGGER AS
$$BEGIN
    IF tg_op = 'INSERT' THEN
        UPDATE Event
        SET attendee_count = (SELECT attendee_count from Event where id = new.event_id) + 1
        WHERE id = new.event_id;
    END IF;
    IF tg_op = 'DELETE' THEN
        UPDATE Event
        SET attendee_count = (SELECT attendee_count from Event where id = new.event_id) - 1
        WHERE id = new.event_id;
    END IF;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_event_attendee_count
    AFTER INSERT OR DELETE ON attend
    FOR EACH ROW
EXECUTE PROCEDURE update_event_attendee_count();



/*
 NOTIFICATIONS ARE ONLY CREATED ON THE 10,100,1000 VOTES
 TO ACHIEVE THIS YOU CHECK IF THE INTEGER PART OF THE LOG OF THE NUMBER IS
 BIGGER THAN THE INTEGER PART OF THE LOG OF THE NUMBER MINUS 1
 FOR EXAMPLE
    FLOOR(LOG(9)) = 0 AND FLOOR(LOG(10)) = 1
 */

--TO CREATE A NEW NOTIFICATION ON EVERY POWER OF TEN
CREATE OR REPLACE FUNCTION new_post_vote_notification()
    RETURNS TRIGGER AS
$$BEGIN
    IF (SELECT count(*) FROM postvote WHERE post_id = NEW.post_id) = 1
    THEN
        INSERT INTO Notification (user_id, text)
        VALUES (new.user_id,'your post post:' || new.post_id || '... has received ' || (select count(*) from PostVote WHERE post_id = new.post_id) || ' vote');
    ELSE
        IF
            (floor(log((SELECT count(*) FROM PostVote WHERE post_id = NEW.post_id)))
                >
             (floor(log((SELECT count(*) FROM postvote WHERE post_id = NEW.post_id) - 1))))
        THEN
            INSERT INTO Notification (user_id, text)
            VALUES (NEW.user_id,'your post post:' || new.post_id || '... has received ' || (select count(*) from PostVote WHERE post_id = new.post_id) || ' votes');
        END IF;
    END IF;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_post_vote_notification
    AFTER INSERT ON postvote
    FOR EACH ROW
EXECUTE PROCEDURE new_post_vote_notification();

--TO CREATE A NEW NOTIFICATION ON EVERY POWER OF TEN
CREATE OR REPLACE FUNCTION new_poll_vote_notification()
    RETURNS TRIGGER AS
$$BEGIN
    IF
            (SELECT count(*) FROM PollVote WHERE poll_id = NEW.poll_id) = 1
    THEN
        INSERT INTO Notification (user_id, text)
        VALUES (NEW.user_id,'your poll poll:' ||NEW.poll_id || ' has received ' || (select count(*) from PollVote WHERE poll_id = new.poll_id) || ' vote');
    ELSE
        IF
            (floor(log((SELECT count(*) FROM PollVote WHERE poll_id = NEW.poll_id)))
                >
             (floor(log((SELECT count(*) FROM PollVote WHERE poll_id = NEW.poll_id) - 1))))
        THEN
            INSERT INTO Notification (user_id, text)
            VALUES (NEW.user_id,'your poll poll:' || NEW.poll_id || ' has received ' || (select count(*) from PollVote WHERE poll_id = new.poll_id) || ' votes');
        END IF;
    END IF;
    RETURN NEW;

END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_poll_vote_notification
    AFTER INSERT ON PollVote
    FOR EACH ROW
EXECUTE PROCEDURE new_poll_vote_notification();

--TO CREATE A NEW NOTIFICATION ON EVERY INVITATION
CREATE OR REPLACE FUNCTION new_invitation_notification()
    RETURNS TRIGGER AS
$$BEGIN
    INSERT INTO Notification (user_id, text)
    VALUES (NEW.invited, 'you ve been invited by user:' || NEW.inviter || ' to the event:' || NEW.event_id);
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_invitation_notification
    AFTER INSERT ON Invite
    FOR EACH ROW
EXECUTE PROCEDURE new_invitation_notification();

--TO CREATE A NEW NOTIFICATION ON EVERY POWER OF TEN
CREATE OR REPLACE FUNCTION new_comment_vote_notification()
    RETURNS TRIGGER AS
$$BEGIN
    IF (SELECT count(*) FROM CommentVote WHERE comment_id = NEW.comment_id) = 1
    THEN
        INSERT INTO Notification (user_id, text)
        VALUES (NEW.user_id,'your comment comment:' || NEW.comment_id || '... has received ' || (select count(*) from CommentVote WHERE comment_id = new.comment_id) || ' vote');
    ELSE
        IF
            (floor(log((SELECT count(*) FROM CommentVote WHERE comment_id = NEW.comment_id)))
                >
             (floor(log((SELECT count(*) FROM CommentVote WHERE comment_id = NEW.comment_id) - 1))))
        THEN
            INSERT INTO Notification (user_id, text)
            VALUES (NEW.user_id,'your comment comment:' || (select parent_post from comment where comment.id = new.comment_id) || '... has received ' || (select count(*) from CommentVote WHERE id = new.comment_id) || ' votes');
        END IF;
    END IF;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_comment_vote_notification
    AFTER INSERT ON CommentVote
    FOR EACH ROW
EXECUTE PROCEDURE new_comment_vote_notification();

--TO UPDATE THE POLL VOTE COUNT
CREATE OR REPLACE FUNCTION update_poll_vote_count()
    RETURNS TRIGGER AS
$$BEGIN
    UPDATE Poll
    SET voter_count = ((SELECT voter_count FROM Poll WHERE id = NEW.poll_id)+1)
    WHERE Poll.id = NEW.poll_id;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_poll_vote_count
    AFTER INSERT ON PollVote
    FOR EACH ROW
EXECUTE PROCEDURE update_poll_vote_count();

--TO UPDATE THE POLL OPTION VOTE COUNT
CREATE OR REPLACE FUNCTION update_poll_option_vote_count()
    RETURNS TRIGGER AS
$$BEGIN
    UPDATE Option
    SET voter_count = ((SELECT voter_count FROM Option WHERE poll_id = NEW.poll_id AND id = NEW.poll_id)+1)
    WHERE Option.id = NEW.option_id;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_poll_option_vote_count
    AFTER INSERT ON PollVote
    FOR EACH ROW
EXECUTE PROCEDURE update_poll_option_vote_count();

--trigger to update the comment total score
CREATE OR REPLACE FUNCTION update_comment_score()
    RETURNS TRIGGER AS
$$BEGIN
    IF NEW.is_positive
    THEN
        UPDATE Comment
        SET total_score = total_score+1
        WHERE Comment.id = NEW.comment_id;
    END IF;
    IF NOT NEW.is_positive
    THEN
        UPDATE Comment
        SET total_score = total_score-1
        WHERE Comment.id = new.comment_id;
    END IF;
    RETURN NEW;
END;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_comment_score
    AFTER INSERT ON CommentVote
    FOR EACH ROW
EXECUTE PROCEDURE update_comment_score();

--trigger to create the post score
CREATE OR REPLACE FUNCTION update_post_score()
    RETURNS TRIGGER AS
$$BEGIN
    IF NEW.is_positive
    THEN
        UPDATE Post
        SET score = score+1
        WHERE id = new.post_id;
    ELSE
        UPDATE Post
        SET score = score-1
        WHERE id = new.post_id;
    END IF;
    RETURN NEW;
end;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_update_post_score
    AFTER INSERT ON PostVote
    FOR EACH ROW
EXECUTE FUNCTION update_post_score();



create or replace function event_description_search()
    returns trigger as
$$BEGIN
    IF tg_op = 'INSERT' THEN
        NEW.description_FTS = to_tsvector('ENGLISH',NEW.description);
    END IF;
    IF tg_op = 'UPDATE' THEN
        IF NEW.description <> OLD.description THEN
            NEW.description_FTS = to_tsvector('ENGLISH',NEW.description);
        end if;
    end if;
    RETURN NEW;
end;$$
    language plpgsql;

CREATE TRIGGER tr_event_description_search
    BEFORE INSERT OR UPDATE ON Event
    FOR EACH ROW
EXECUTE FUNCTION event_description_search();



CREATE OR REPLACE FUNCTION event_name_search()
    RETURNS TRIGGER AS
$$BEGIN
    IF tg_op = 'INSERT' THEN
        NEW.name_FTS = to_tsvector('ENGLISH',NEW.name);
    END IF;
    IF tg_op = 'UPDATE' THEN
        IF NEW.name <> OLD.name THEN
            NEW.name_FTS = to_tsvector('ENGLISH',NEW.name);
        END IF;
    end if;
    RETURN NEW;
end;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_event_name_search
    BEFORE INSERT OR UPDATE ON Event
    FOR EACH ROW
EXECUTE FUNCTION event_name_search();



CREATE FUNCTION location_search()
    RETURNS TRIGGER AS
$$BEGIN
    IF tg_op = 'INSERT' THEN
        NEW.address_FTS = to_tsvector('ENGLISH',NEW.address);
    END IF;
    IF tg_op = 'UPDATE' THEN
        IF NEW.address <> OLD.address THEN
            NEW.address_FTS = to_tsvector('ENGLISH',NEW.name);
        end if;
    end if;
    RETURN NEW;
end;$$
    LANGUAGE plpgsql;
CREATE TRIGGER tr_location_search
    BEFORE INSERT OR UPDATE ON Location
    FOR EACH ROW
EXECUTE FUNCTION location_search();