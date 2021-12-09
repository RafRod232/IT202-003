CREATE TABLE IF NOT EXISTS Competitions(
 id int AUTO_INCREMENT PRIMARY KEY,
 name varchar(240) not null,
 duration int default 3,
 expires TIMESTAMP DEFAULT (DATE_ADD(CURRENT_TIMESTAMP, INTERVAL duration DAY)),
 current_reward int DEFAULT (starting_reward),
 starting_reward int DEFAULT 1,
 join_fee int default 0,
 current_participants int default 0,
 min_participants int DEFAULT 3,
 paid_out tinyint(1) DEFAULT 0
 min_score int DEFAULT 0,
 first_place_per int DEFAULT 70,
 second_place_per int DEFAULT 20,
 thrid_place_per int DEFAULT 10,
 cost_to_create int,
 created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 modified TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
 check (starting_reward >= 1),
 check (first_place_per + second_place_per + thrid_place_per = 100),
 check (join_fee >= 0),
 check (min_score>=0),
 check (min_participants >= 3),
 check (current_reward >= starting_reward),
 check (cost_to_create >= 1 + starting_reward), 
 check (current_participants >= 0)
)