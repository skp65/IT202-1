SELECT count(1) as "favorite" FROM Favorites where story_id = :story_id AND user_id = :user_id