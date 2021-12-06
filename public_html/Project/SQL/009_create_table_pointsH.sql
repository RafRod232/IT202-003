CREATE TABLE IF NOT EXISTS PointsHistory(
    id int AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    point_change int,
    reason VARCHAR(50),
    created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id)
)