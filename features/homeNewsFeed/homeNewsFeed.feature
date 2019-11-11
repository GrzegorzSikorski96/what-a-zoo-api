Feature: Home News Feed

    Background:
        Given a normal user named 'User'

    @success
    Scenario: get news when logged in
        Given I am logged in as User
        And I send request to '/api/news' using 'GET' method
        When request is sent
        Then the response status code should be 200
        And response successs field should be true
        And response 'news' field should not be empty

    @fail
    Scenario: Get news when not logged in 
        Given I send request to '/api/news' using 'GET' method
        When request is sent 
        Then the response status code should be 400
        And the response success field should be false