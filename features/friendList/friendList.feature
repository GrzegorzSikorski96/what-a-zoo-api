Feature: Friend List

    Background: 
        Given a normal user named "User"

    @fail
    Scenario: Get friendlist unauthenticated
        Given I send request to '/api/friends' using 'GET' method
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
        And the response "friends" field should be empty

    @success
    Scenario: Get friendlist authenticated
        Given I am logged in as User
        And I send request to '/api/friends' using 'GET' method
        When request is sent
        Then the response status code should be 200
        And the response success field should be true

    @success
    Scenario: Get friend from friendlist
        Given I am logged in as User
        And I send request to '/api/friend/1' using 'GET' method
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response "friend" field should not be empty

    @fail
    Scenario: Get friend who is not in your friendlist
        Given I am logged in as User
        And I send request to '/api/friend/2' using 'GET' method
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
        And the response "friend" field should be empty

    @success
    Scenario: Add friend
        Given I am logged in as User
        And I send request to '/api/friend/add' using 'POST' method
        And request data is:
        | key       | value |
        | friend_id | 2     |
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response "friend" field should not be empty

    @fail
    Scenario: Add non existing friend
        Given I am logged in as User
        And I send request to '/api/friend/add' using 'POST' method
        And request data is:
        | key       | value  |
        | friend_id | 123123 |
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
        And the response "friend" field should be empty

    @success
    Scenario: Remove friend
        Given I am logged in as User
        And I send request to '/api/friend/remove' using 'DELETE' method
        And request data is:
        | key       | value  |
        | friend_id | 2      |
        When request is sent
        Then the response status code should be 200
        And the response success field should be true

    @fail
    Scenario: Remove friend you do not have
        Given I am logged in as User
        And I send request to '/api/friend/remove' using 'DELETE' method
        And request data is:
        | key       | value  |
        | friend_id | 123    |
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
    