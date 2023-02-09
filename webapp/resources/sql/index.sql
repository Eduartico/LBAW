SET search_path TO lbaw2235;

-- attendee index
CREATE INDEX event_attendee ON Attend USING btree (event_id);

--post index
CREATE INDEX event_post ON Post USING hash (event_id);

-- event index
CREATE INDEX date_event ON Event USING btree (event_date);

-- post search index
CREATE INDEX idx_post_text ON Post USING gist(text_FTS);

-- event search index
CREATE INDEX idx_event_name ON Event USING gist(name_FTS);

-- location search index
CREATE INDEX idx_location_address ON Location USING gist(address_FTS);
