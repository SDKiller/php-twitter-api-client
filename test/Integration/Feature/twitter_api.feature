Feature: I can be sure Twitter API works within my client
  As a client from my library
  I want to make sure this library works
  So I can provide the service to the world

  Scenario: I Should get an Okay response from Twitter
    Given I have Twitter Access through my API client
    And I try to curl the following url "/1.1/statuses/user_timeline.json" with the following count "100" and screen_name "twitterapi"
    When executing the service
    Then I should get a status code of "200"

   Scenario: I Should get an array of Tweets from Twitter
     Given I have Twitter Access through my API client
     And I try to curl the following url '/1.1/search/tweets.json' with the following query '\“happy hour\”', language 'en' and count '1'
     When executing the service
     Then I should get an array of tweets
