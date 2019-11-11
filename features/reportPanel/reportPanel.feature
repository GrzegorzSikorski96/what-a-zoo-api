Feature: Report Panel

    Background:
        Given a global administrator named 'Admin'
        And a normal user named 'User'

    @fail
    Scenario: Accessing report panel unauthenticated
        Given I send request to '/api/reports' using 'GET' method
        When the request is sent
        Then the response status code should be 400
        And the response success field should be false

    @fail
    Scenario: Accessing report panel as user
        Given I am logged in as User
        And I send request to '/api/reports' using 'GET' method
        When the request is sent
        Then the response status code should be 400
        And the response success field should be false

    @success
    Scenario: Accessing report panel as Admin
        Given I am logged in as Admin
        And I send request to '/api/reports' using 'GET' method
        When the request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response 'reports' field should not be empty

    @success
    Scenario: Setting Report as offensive
        Given Report with id equal to 1 
        And I am logged in as Admin
        And i send request to '/api/reports/resolve' using 'POST' method
        And request data is:
        | key       | value |
        | id        | 1     |
        | offensive | true  |
        When the request is sent
        Then the response status should be 200
        And the response success field should be true
        And the response "reports" field should not be empty

    @success
    Scenario: Setting Report as not offensive
        Given Report with id equal to 1 
        And I am logged in as Admin
        And i send request to '/api/reports/resolve' using 'POST' method
        And request data is:
        | key       | value |
        | id        | 1     |
        | offensive | false |
        When the request is sent
        Then the response status should be 200
        And the response success field should be true
        And the response "reports" field should not be empty

    @success
    Scenario: Ban a user
        Given I am logged in as Admin
        And I send request to '/api/user/1/ban/' using 'POST' method
        When the request is sent
        Then the response status should be 200
        and the response success field should be true

    @fail
    Scenario: Ban a non existing user
        Given I am logged in as Admin
        And I send request to '/api/user/123/ban/' using 'POST' method
        When the request is sent
        then the response status should be 400
        and the response success field should be false