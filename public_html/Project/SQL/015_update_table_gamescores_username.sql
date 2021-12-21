UPDATE GameScores 
JOIN Users ON GameScores.user_id = Users.id
SET GameScores.username = Users.username;