<?php

namespace MarcosSegovia\Twitter\Tests;

use MarcosSegovia\Twitter\TwitterApiClient;

final class TwitterApiClientTest extends \PHPUnit_Framework_TestCase
{
    private $twitter_api_client;

    public function tearDown()
    {
        $this->twitter_api_client = null;
    }

    public function testItShouldGetOkayCodeFromTwitter()
    {
        $this->havingAnHttpTwitterAccess();

        $url_to_check_twitter_standard_access = '/1.1/statuses/user_timeline.json';
        $query_parameters                     = ['count' => 100, 'screen_name' => 'twitterapi'];
        $guzzle_response                      = $this->twitter_api_client->get($url_to_check_twitter_standard_access,
            $query_parameters
        );
        $this->assertEquals(200, $guzzle_response->getStatusCode());
    }

    public function havingAnHttpTwitterAccess()
    {
        $this->twitter_api_client = new TwitterApiClient(getenv('API_KEY'),
            getenv('API_SECRET')
        );
    }

}
