# Project Name: Simple Arcade
## Project Summary: This project will create a simple Arcade with scoreboards and competitions based on the implemented game.
## Github Link: (Prod Branch of Project Folder)
## Project Board Link: 
## Website Link: (Heroku Prod of Project folder)
## Your Name: Rafael Rodriguez

<!--
### Line item / Feature template (use this for each bullet point)
#### Don't delete this

- [ ] \(mm/dd/yyyy of completion) Feature Title (from the proposal bullet point, if it's a sub-point indent it properly)
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
### End Line item / Feature Template
--> 
### Proposal Checklist and Evidence
Milestone Features:
	Milestone 1:
- [x] \(11/10/2021 of completion) User will be able to register a new account
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link:https://rar22-prod.herokuapp.com/Project/register.php
    - Pull Requests
      - PR link https://github.com/RafRod232/IT202-003/pull/36
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141235769-d030acbc-2890-44c8-9830-e5e05e562dba.png)
        - Screenshot #1 Shows all the fields in registration and how everything but the email is deleted and alerts user if passwords match
      - Screenshot #2![image](https://user-images.githubusercontent.com/89927101/141236240-fc8856f3-29c2-4577-81af-8c970df34f02.png)
        - Screenshot #2 Shows how it asked if username is required
      - Screenshot #3![image](https://user-images.githubusercontent.com/89927101/141236132-04ce0d6f-e524-48db-a692-e47e9a71c32a.png)
        - Screenshot #3 Show if email is validated and required 
        
    - Form Fields
        - [x] Username, email, password, confirm password(other fields optional)
        - [x] Email is required and must be validated
        - [x] Username is required
        - [x] Confirm password’s match
    - Users Table
        -[x] Id, username, email, password (60 characters), created, modified
    - Password must be hashed (plain text passwords will lose points)
    - Email should be unique
    - Username should be unique
    - System should let user know if username or email is taken and allow the user to correct the error without wiping/clearing the form
        - [x] The only fields that may be cleared are the password fields
- [x] \(11/10/2021 of completion) User will be able to login to their account (given they enter the correct credentials)
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/login.php
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141236424-a0412c30-1b88-417a-bf8e-f6c17d6a4922.png)
        - Screenshot #1 Shows login with email or username and password
      - Screenshot #2![image](https://user-images.githubusercontent.com/89927101/141236685-40aab3c3-11d3-48a9-b9b3-a1890e4485b4.png)
        - Screenshot #2 Shows Passwords dont match
      - Screenshot #3 ![image](https://user-images.githubusercontent.com/89927101/141236772-8e3d2ee3-0516-4245-9ea8-16e044ab178f.png)
        - Screenshot #3 Shows after login I was redirected to home
    - Form
        - [x] User can login with email or username
            - This can be done as a single field or as two separate fields
        - [x] Password is required
    - User should see friendly error messages when an account either doesn’t exist or if passwords don’t match
    - Logging in should fetch the user’s details (and roles) and save them into the session.
    - User will be directed to a landing page upon login
        - [x] This is a protected page (non-logged in users shouldn’t have access)
        - [x] This can be home, profile, a dashboard, etc
- [x] \(11/10/2021 of completion) User will be able to logout
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/logout.php
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32 
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141237190-94fd45d9-b4a7-48ba-acec-b7bb404a70a4.png)
        - Screenshot #1 Shows User succesfully logged out
      - Screenshot #2 ![image](https://user-images.githubusercontent.com/89927101/141237273-225f8ede-039b-4206-b66a-58a02691174a.png)
        - Screenshot #2 Shows user cannot go back in after being logged out
    - Logging out will redirect to login page
    - User should see a message that they’ve successfully logged out
    - Session should be destroyed (so the back button doesn’t allow them access back in)
- [x] \(11/10/2021 of completion) Basic security rules implemented
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/home.php
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141237273-225f8ede-039b-4206-b66a-58a02691174a.png)
        - Screenshot #1 Shows proff that if user is loggen in function works
      - Screenshot #2 ![image](https://user-images.githubusercontent.com/89927101/141237581-54b63d90-dc15-43c7-983d-b1095d1e935d.png)
        - Screenshot #2 Show roles table
    - Authentication:
        - [x] Function to check if user is logged in
        - [x] Function should be called on appropriate pages that only allow logged in users
    - Roles/Authorization:
        - [x] Have a roles table (see below)
- [x] \(11/10/2021 of completion) Basic Roles implemented
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/home.php
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141237691-4c3f092a-54b5-47e3-8995-15f7b7686f6a.png)
        - Screenshot #1 Shows Roles,User Roles table
    - Have a Roles table	(id, name, description, is_active, modified, created)
    - Have a User Roles table (id, user_id, role_id, is_active, created, modified)
    - Include a function to check if a user has a specific role (we won’t use it for this milestone but it should be usable in the future)
- [x] \(11/10/2021 of completion) Site should have basic styles/theme applied; everything should be styled
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/home.php
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141236772-8e3d2ee3-0516-4245-9ea8-16e044ab178f.png)
        - Screenshot #1 proof of styling
    - I.e., forms/input, navigation bar, etc
- [x] \(11/10/2021 of completion) Any output messages/errors should be “user friendly”
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/register.php
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141236772-8e3d2ee3-0516-4245-9ea8-16e044ab178f.png)
        - Screenshot #1 user friendly message greeting the user
    - Any technical errors or debug output displayed will result in a loss of points
- [x] \(11/10/2021 of completion) User will be able to see their profile
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/profile.php 
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141237019-b9ef5acb-514f-40cc-84a7-2cf8fec2478e.png)
        - Screenshot #1 User profile shown
    - Email, username, etc
- [x] \(11/10/2021 of completion) User will be able to edit their profile
  -  List of Evidence of Feature Completion
    - Status: Completed (Completed, Partially working, Incomplete, Pending)
    - Direct Link: https://rar22-prod.herokuapp.com/Project/profile.php
    - Pull Requests
      - PR link #1 https://github.com/RafRod232/IT202-003/pull/32
    - Screenshots
      - Screenshot #1 ![image](https://user-images.githubusercontent.com/89927101/141237019-b9ef5acb-514f-40cc-84a7-2cf8fec2478e.png)
        - Screenshot #1 options to change password is available
    - Changing username/email should properly check to see if it’s available before allowing the change
    - Any other fields should be properly validated
    - Allow password reset (only if the existing correct password is provided)
        - [ ]Hint: logic for the password check would be similar to login
	Milestone 2:
- [ ] \(mm/dd/yyyy of completion)  Pick a simple game to implement, anything that generates a score that’s more advanced than a simple random number generator (may build off of a sample from the site shared in class)
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
  - What game will you be doing?
    - [game]
  - Briefly describe it.
    - [describe]
    - Note: For this milestone the game doesn’t need to be complete, just have something basic or a placeholder that can generate a score when played.
-[ ] \(mm/dd/yyyy of completion) The system will save the user’s score at the end of the game if the user is logged in
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
  - There should be a scores table (id, user_id, score, created)
  - Each received score is a new entry (scores will not be updated)
- [ ] \(mm/dd/yyyy of completion) The user will be able to see their last 10 scores
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
  - Show on their profile page
  - Ordered by most recent
- [ ] \(mm/dd/yyyy of completion) Create functions that output the following scoreboards (this will be used later)
  -  List of Evidence of Feature Completion
    - Status: Pending (Completed, Partially working, Incomplete, Pending)
    - Direct Link: (Direct link to the file or files in heroku prod for quick testing (even if it's a protected page))
    - Pull Requests
      - PR link #1 (repeat as necessary)
    - Screenshots
      - Screenshot #1 (paste the image so it uploads to github) (repeat as necessary)
        - Screenshot #1 description explaining what you're trying to show
  - Top 10 Weekly
  - Top 10 Monthly
  - Top 10 Lifetime
  - Scoreboards should show no more than 10 results; if there are no results a proper message should be displayed (i.e., “No [time period] scores to display”)
Milestone 3:
Users will have points associated with their account.
Alter the User table to include points with a default of 0.
This field will not be incremented/decremented directly, you must use the PointsHistory table to calculate it and set it each time the points change
Points should show on their profile page
You may show points elsewhere as well if you wish
Create a PointsHistory table (id, user_id, point_change, reason, created)
Any new entry should update the user’s points value (do not update the User points column directly)
SUM the point_change for the user_id to get the total
Competitions table should have the following columns (id, name, created, duration, expires (now + duration), current_reward, starting_reward, join_fee, current_participants, min_participants, paid_out (boolean), min_score, first_place_per, second_place_per, third_place_per, cost_to_create, created, modified)
User will be able to create a competition
Competitions will start at 1 point (reward)
User sets a name for the competition
User determines % given for 1st, 2nd, and 3rd place winners
Combination must be equal to 100% (no more, no less)
User determines if it’s free to join or the cost to join (min 0 for free)
User determines the duration of the competition (in days)
User can determine the minimum score to qualify (min 0)
User determines minimum participants for payout (min 3)
Show any user friendly error messages
Show user friendly confirmation message that competition was created
The cost to the creator of the competition will be (1 + starting reward value)
If they can’t afford it, the competition should not be created
If they can afford it, automatically add them to the competition
Each new participant causes the Reward value to increase by at least 1 or 50% of the joining fee rounded up
Have a page where the User can see active competitions (not expired)
For this milestone limit the output to a maximum of 10
Order the results by soonest to expire
Will need an association table CompetitionParticipants (id, comp_id, user_id, created)
Comp_id and user_id should be a composite unique key (user can only join a competition once)
User can join active competitions 
Creates an entry in CompetitionParticipants
Recalculate the Competitions.participants value based on the count of participants for this competition from the CompetitionParticipants table.
Update the Competitions.reward based on the # of participants and the appropriate math from the competition requirements above
Best to due this based on a simple equation via the initial Competition data and participants
Show proper error message if user is already registered
Show proper confirmation if user registered successfully
Create function that calculates competition winners
Get all expired and not paid_out competitions
For each competition
Check that the participant count against the minimum required
Get the top 3 winners
Pick 1 (strike out the option you won’t do; do not delete):
Option 1: Scores are calculated by the sum of the score from the Scores table where it was earned/created between Competition start and Competition expires timestamps
Option 2: Where the score was earned/created between when the user joined the competition and when the Competition expires
Calculate the payout (reward * place_percent)
Round up the value (it’s ok to pay out an extra point here and there)
Create entries for the Users in the PointsHistory table
Apply the new values (SUM) to their points column in the Users table after entry is added
Reason should be recorded as ‘competition’ (or something with more precise information)
Mark the competition as paid_out = true
	Milestone 4:
User can set their profile to be public or private (will need another column in Users table)
If public, hide email address from other users
User will be able to see their competition history
Limit to 10 results
Paginate anything after 10
If no results, show the appropriate message
User with the role of “admin” can edit a competition where paid_out = false
They can adjust any of the regular form values
If the competition was expired they can update the duration to include extra time
Add pagination to the Active Competitions view
Show 10 competitions per page
Paginate anything after 10
If no results, show the appropriate message
Anywhere a username is displayed should be a link to that user’s profile
This includes all scoreboards
If the profile is private you can have the page just display “this profile is private” upon access
Viewing an active or expired competition should show the top 10 scoreboard related to that competition
Game should be fully implemented/complete by this point
Game should tell the player if they’re not logged in that their score will not be recorded.
User’s score history will include pagination
Show latest 10
Paginate after 10
Show appropriate message for no results
Home page will have a weekly, monthly, and lifetime scoreboard
Will also have a link to the game
Scoreboards will show username and points for the session
(See requirement about username linking to profile)

### Intructions
#### Don't delete this
1. Pick one project type
2. Create a proposal.md file in the root of your project directory of your GitHub repository
3. Copy the contents of the Google Doc into this readme file
4. Convert the list items to markdown checkboxes (apply any other markdown for organizational purposes)
5. Create a new Project Board on GitHub
   - Choose the Automated Kanban Board Template
   - For each major line item (or sub line item if applicable) create a GitHub issue
   - The title should be the line item text
   - The first comment should be the acceptance criteria (i.e., what you need to accomplish for it to be "complete")
   - Leave these in "to do" status until you start working on them
   - Assign each issue to your Project Board (the right-side panel)
   - Assign each issue to yourself (the right-side panel)
6. As you work
  1. As you work on features, create separate branches for the code in the style of Feature-ShortDescription (using the Milestone branch as the source)
  2. Add, commit, push the related file changes to this branch
  3. Add evidence to the PR (Feat to Milestone) conversation view comments showing the feature being implemented
     - Screenshot(s) of the site view (make sure they clearly show the feature)
     - Screenshot of the database data if applicable
     - Describe each screenshot to specify exactly what's being shown
     - A code snippet screenshot or reference via GitHub markdown may be used as an alternative for evidence that can't be captured on the screen
  4. Update the checklist of the proposal.md file for each feature this is completing (ideally should be 1 branch/pull request per feature, but some cases may have multiple)
    - Basically add an x to the checkbox markdown along with a date after
      - (i.e.,   - [x] (mm/dd/yy) ....) See Template above
    - Add the pull request link as a new indented line for each line item being completed
    - Attach any related issue items on the right-side panel
  5. Merge the Feature Branch into your Milestone branch (this should close the pull request and the attached issues)
    - Merge the Milestone branch into dev, then dev into prod as needed
    - Last two steps are mostly for getting it to prod for delivery of the assignment 
  7. If the attached issues don't close wait until the next step
  8. Merge the updated dev branch into your production branch via a pull request
  9. Close any related issues that didn't auto close
    - You can edit the dropdown on the issue or drag/drop it to the proper column on the project board
