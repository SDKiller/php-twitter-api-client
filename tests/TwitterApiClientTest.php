<?php

namespace MarcosSegovia\Twitter\Tests;

use GuzzleHttp\Message\ResponseInterface;
use MarcosSegovia\Twitter\TwitterApiClient;

final class TwitterApiClientTest extends \PHPUnit_Framework_TestCase
{
    /** @var  TwitterApiClient */
    private $twitter_api_client;

    public function tearDown()
    {
        $this->twitter_api_client = null;
    }

    public function testItShouldGetOkayCodeFromTwitter()
    {
        $this->havingAnHttpTwitterAccess();

        $url_to_check_access = '/1.1/statuses/user_timeline.json';
        $query_parameters    = ['count' => 100, 'screen_name' => 'twitterapi'];
        $guzzle_response     = $this->twitter_api_client->get($url_to_check_access, $query_parameters);

        $this->assertEquals(200, $guzzle_response->getStatusCode());
    }

    public function testItShouldReturnListOfTweetsInJson()
    {
        $this->havingAnHttpTwitterAccess();

        $url              = '/1.1/search/tweets.json';
        $query_parameters = ['q' => '\“happy hour\”', 'lang' => 'es', 'count' => '1'];
        /** @var ResponseInterface $guzzle_response */
        $guzzle_response = $this->twitter_api_client->get($url, $query_parameters);
        $tweets_in_array = $guzzle_response->json();
        $tweets_in_json  = json_encode($tweets_in_array);
        $this->assertJson($tweets_in_json);
    }

    public function testItShouldReturnListOfTweetsInJsonWithSearchCall()
    {
        $this->havingAnHttpTwitterAccess();
        $guzzle_response = $this->twitter_api_client->getSearch('@NASA', 'en', '2');

        $tweets_in_array = $guzzle_response->json();
        $tweets_in_json  = json_encode($tweets_in_array);
        var_dump($tweets_in_json);

        $this->assertJson($tweets_in_json);
    }

    public function havingAnHttpTwitterAccess()
    {
        $this->twitter_api_client = new TwitterApiClient(getenv('API_KEY'),
            getenv('API_SECRET')
        );
    }

}
