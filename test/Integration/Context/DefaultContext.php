<?php

namespace MarcosSegovia\Twitter\Test\Integration\Context;

use Behat\Behat\Context\SnippetAcceptingContext;
use GuzzleHttp\Message\Response;
use MarcosSegovia\Twitter\TwitterApiClient;
use PHPUnit_Framework_Assert;

final class DefaultContext implements SnippetAcceptingContext
{
    /** @var TwitterApiClient */
    private $twitter_api_client;

    /** @var string */
    private $url;

    /** @var array */
    private $parameters;

    /** @var Response */
    private $response;

    /**
     * @Given I have Twitter Access through my API client
     */
    public function iHaveTwitterAccessThroughMyApiClient()
    {
        $this->twitter_api_client = new TwitterApiClient(getenv('API_KEY'),
            getenv('API_SECRET')
        );
    }

    /**
     * @Given I try to curl the following url :url with the following count :count and screen_name :screen_name
     */
    public function iTryToCurlTheFollowingUrlWithTheFollowingCountAndScreenName(
        $url,
        $count,
        $screen_name
    )
    {
        $this->url = $url;
        $this->parameters = ['count' => $count, 'screen_name' => $screen_name];
    }

    /**
     * @Given I try to curl the following url :url with the following query :query, language :language and count :count
     */
    public function iTryToCurlTheFollowingUrlWithTheFollowingQueryLanguageAndCount(
        $url,
        $query,
        $language,
        $count
    )
    {
        $this->url = $url;
        $this->parameters = ['q' => $query, 'lang' => $language, 'count' => $count];
    }

    /**
     * @When executing the service
     */
    public function executingTheService()
    {
        $this->response = $this->twitter_api_client->get($this->url, $this->parameters);
    }

    /**
     * @Then I should get a status code of :status
     */
    public function iShouldGetAStatusCodeOf($status)
    {
        PHPUnit_Framework_Assert::assertEquals($status, $this->response->getStatusCode());
    }

    /**
     * @Then I should get an array of tweets
     */
    public function iShouldAnArrayOfTweets()
    {
        PHPUnit_Framework_Assert::assertNotEmpty($this->response->json());
    }
}
