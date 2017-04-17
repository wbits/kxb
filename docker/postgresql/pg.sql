CREATE TABLE art_piece(
   id uuid,
   doc jsonb,
   PRIMARY KEY( id )
);

CREATE INDEX idxginartist ON art_piece USING gin ((art_piece.doc -> 'artist_id'));

/** art by artist */
SELECT * FROM art_piece WHERE art_piece.doc @> '{"artist_id":"?"}';
