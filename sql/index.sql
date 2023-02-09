SET search_path TO lbaw2235;

DROP INDEX IF EXISTS event_attendee;
DROP INDEX IF EXISTS event_post;
DROP INDEX IF EXISTS date_event;
DROP INDEX IF EXISTS idx_event_name;
DROP INDEX IF EXISTS idx_location_address;
-- attendee index
CREATE INDEX event_attendee ON Attend USING btree (event_id);

--post index
CREATE INDEX event_post ON Post USING hash (event_id);

-- event index
CREATE INDEX date_event ON Event USING btree (event_date);

-- event search index
CREATE INDEX idx_event_name ON Event USING gist(name_FTS);

-- location search index
CREATE INDEX idx_location_address ON Location USING gist(address_FTS);
