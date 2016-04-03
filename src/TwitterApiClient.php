<?php

namespace MarcosSegovia\Twitter;

use CommerceGuys\Guzzle\Oauth2\GrantType\ClientCredentials;
use CommerceGuys\Guzzle\Oauth2\GrantType\RefreshToken;
use CommerceGuys\Guzzle\Oauth2\Oauth2Subscriber;
use GuzzleHttp\Client;

/**
 * Class TwitterApiClient
 * @package MarcosSegovia\Twitter
 *
 * - Search in tweets
 * - Retrieve any user information
 */
class TwitterApiClient
{
    const BASE_TWITTER_URL = 'https://api.twitter.com';

    /**
     * @var Client
     */
    protected $auth_client;

    /**
     * @var Client
     */
    protected $http_client;

    /**
     * @var integer
     */
    protected $timeout;

    public function __construct(
        $a_consumer_key,
        $a_consumer_secret
    )
    {
        $this->auth_client = new Client(['base_url' => self::BASE_TWITTER_URL]);

        $config_parameters = [
            'client_id'     => $a_consumer_key,
            'client_secret' => $a_consumer_secret,
            'token_url'     => '/oauth2/token'
        ];

        $token        = new ClientCredentials($this->auth_client, $config_parameters);
        $refreshToken = new RefreshToken($this->auth_client, $config_parameters);

        $oauth2 = new Oauth2Subscriber($token, $refreshToken);

        $this->http_client = new Client([
                'base_url' => self::BASE_TWITTER_URL,
                'defaults' => [
                    'auth'        => 'oauth2',
                    'subscribers' => [$oauth2],
                ],
            ]
        );
    }

    public function get(
        $an_url,
        $query_parameters = []
    )
    {
        return $this->http_client->get($an_url,
            [
                'query' => $query_parameters
            ]
        );
    }

}
