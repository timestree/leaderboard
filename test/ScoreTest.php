<?php
use PHPUnit\Framework\TestCase;
require 'vendor/autoload.php';

class ScoreTest extends TestCase
{
    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'https://leaderboard.timestree.com/']);
    }
    public function tearDown(): void {
        $this->http = null;
    } 
 
    public function testReadAll()
    {
        $response = $this->http->request('GET', 'api/learderboard/score/read.php');

        $body = $response->getBody();
        $body_object = json_decode($body);
        $count_score = (count($body_object->records));

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertGreaterThan(0, $count_score) ;
    }
    
    public function testReadOne()
    {
        $response = $this->http->request('GET', 'api/learderboard/score/read_one.php?id=1');

        $body = $response->getBody();
        $body_object = json_decode($body);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('Emma', $body_object->name) ;

    }

    public function testReadOne_invalid()
    {
        $response = $this->http->request('GET', 'api/learderboard/score/read_one.php?id=aaa', ['http_errors' => false]);

        $body = $response->getBody();
        $body_object = json_decode($body);
        $body_message = $body_object->message;
        $validation_message = 'Unable to read score. Data is incomplete.';

        $this->assertEquals(400, $response->getStatusCode());
        $this->assertEquals($validation_message, $body_message) ;

    }

    public function testReadOne_noscore()
    {
        $response = $this->http->request('GET', 'api/learderboard/score/read_one.php?id=900012', ['http_errors' => false]);

        $body = $response->getBody();
        $body_object = json_decode($body);
        $body_message = $body_object->message;
        $validation_message = 'No scores found.';

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals($validation_message, $body_message) ;

    }

    public function testAddScore()
    {
        $response = $this->http->request('GET', 'api/learderboard/score/read_one.php?id=4');
        $body = $response->getBody();
        $body_object = json_decode($body);
        $current_score = $body_object->score;       

                $response = $this->http->request('POST', 
                                                'api/learderboard/score/update.php',
                                                ['json' => [   
                                                                'id' => 4,
                                                                'score' => 1,
                                                                'token' => 's7uBvW7KtsShNupE6sZjp7JCjE7zT'
                                                            ]
                                                ]);

                $body = $response->getBody();
                $body_object = json_decode($body);
                $body_message = $body_object->message;
                $validation_message = 'Score is updated.';

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals($validation_message, $body_message) ;

        $response = $this->http->request('GET', 'api/learderboard/score/read_one.php?id=4');
        $body = $response->getBody();
        $body_object = json_decode($body);
        $new_score = $body_object->score;                     

        $this->assertEquals($current_score+1, $new_score);

    }

    public function testSubtractScore()
    {
        $response = $this->http->request('GET', 'api/learderboard/score/read_one.php?id=4');
        $body = $response->getBody();
        $body_object = json_decode($body);
        $current_score = $body_object->score;       

                $response = $this->http->request('POST', 
                                                'api/learderboard/score/update.php',
                                                ['json' => [   
                                                                'id' => 4,
                                                                'score' => -1,
                                                                'token' => 's7uBvW7KtsShNupE6sZjp7JCjE7zT'
                                                            ]
                                                ]);

                $body = $response->getBody();
                $body_object = json_decode($body);
                $body_message = $body_object->message;
                $validation_message = 'Score is updated.';

                $this->assertEquals(200, $response->getStatusCode());
                $this->assertEquals($validation_message, $body_message) ;

        $response = $this->http->request('GET', 'api/learderboard/score/read_one.php?id=4');
        $body = $response->getBody();
        $body_object = json_decode($body);
        $new_score = $body_object->score;                     

        $this->assertEquals($current_score-1, $new_score);

    }


    public function testSubtractScore_invalidScore()
    {
        $response = $this->http->request('POST', 
                                        'api/learderboard/score/update.php',
                                        ['json' => [   
                                                        'id' => 5,
                                                        'score' => -1,
                                                        'token' => 's7uBvW7KtsShNupE6sZjp7JCjE7zT'
                                                    ],
                                        'http_errors' => false
                                        ]);

        $body = $response->getBody();
        $body_object = json_decode($body);
        $body_message = $body_object->message;
        $validation_message = 'Score cannot be negative';

        $this->assertEquals(503, $response->getStatusCode());
        $this->assertEquals($validation_message, $body_message) ;

    }

    public function testDelete()
    {
        $response = $this->http->request('POST', 
                                        'api/learderboard/score/delete.php',
                                        ['json' => [   
                                                        'id' => 5,
                                                        'token' => 's7uBvW7KtsShNupE6sZjp7JCjE7zT'
                                                    ]
                                        ]);

        $body = $response->getBody();
        $body_object = json_decode($body);
        $body_message = $body_object->message;
        $validation_message = 'Score is deleted.';

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($validation_message, $body_message) ;

    }

    public function testCreate()
    {
        $response = $this->http->request('POST', 
                                        'api/learderboard/score/create.php',
                                        ['json' => [   
                                                        'name' => 'John',
                                                        'age' => 29,
                                                        'address' => '1290 Main Street',
                                                        'token' => 's7uBvW7KtsShNupE6sZjp7JCjE7zT'
                                                    ]
                                        ]);

        $body = $response->getBody();
        $body_object = json_decode($body);
        $body_message = $body_object->message;
        $validation_message = 'Score is created.';

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertEquals($validation_message, $body_message) ;

    }





}
