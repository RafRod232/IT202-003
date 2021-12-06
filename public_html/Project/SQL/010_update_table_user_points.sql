UPDATE Users U
SET    U.points  = (SELECT SUM(point_change)
FROM   PointsHistory H
WHERE  H.user_id = U.id);
