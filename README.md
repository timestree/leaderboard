# leaderboard

Version 1.0

- Based on requirements in [requirement.docx](requirement.docx)
- No authentication required for read function
- Any update/create/delete requires authentication based on a pre-defined token value __s7uBvW7KtsShNupE6sZjp7JCjE7zT__
- Read.php handle listing of all users, and assuming any update/create/delete will make a request to read.php to refresh the order and users in the leaderboard
- Update.php handles both add/subtract score, assuming 1 or -1 will be passed along to have the score to be updated
- Required database table and records are store in [scores.sql](scores.sql)

## End Points ##
Sample end point https://leaderboard.timestree.com/api/learderboard/score/
[Download postman collection](leaderboard_api.postman_collection.json)
e.g. https://leaderboard.timestree.com/api/learderboard/score/read.php

- /api/learderboard/score/read.php
    - Load all active scores from a get request

- /api/learderboard/score/create.php
    - Create score/user based on a json post request

- /api/learderboard/score/update.php
    - Add/subtract score based on a json post request

- /api/learderboard/score/delete.php
    - Archive score based on a json post request

## Tests ##
All tests are stored in [/test/ScoreTest.php](test/ScoreTest.php) 
- Requires phpunit and guzzlehttp

