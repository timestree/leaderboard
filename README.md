# leaderboard

Version 1.0

- Based on requirement as in [requirement.docx](requirement.docx)
- No authentication required for read function
- Any update/create/delete requires authentication based on pre-defined token value Markup : __s7uBvW7KtsShNupE6sZjp7JCjE7zT__
- Read.php handle listing of all users, and assuming any update/create/delete will make a request to read.php to refresh the leaderboard
- Update.php handles both add/subtract score, assuming 1 or -1 will be passed along to have the score to be updated
- Required database table and records are store in [scores.sql](scores.sql)

## End Points ##
[Download postman collection](leaderboard_api.postman_collection.json), and test on https://leaderboard.timestree.com/api/learderboard/score/

e.g. https://leaderboard.timestree.com/api/learderboard/score/read.php

- /api/learderboard/score/read.php
    - Load all active score from a get request

- /api/learderboard/score/create.php
    - Create score/user based on json post request

- /api/learderboard/score/update.php
    - Add/subtract score based on json post request

- /api/learderboard/score/delete.php
    - Archive use based on json post request

## Tests ##
All tests are stored in [/test/ScoreTest.php](test/ScoreTest.php) 
- Requires phpunit and guzzlehttp

