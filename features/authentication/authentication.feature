@authentication

Feature: Authentication system

  @success
  Scenario: Success: Login to existing account
    Given I send request to '/api/auth/login' using 'POST' method
    And user with email 'test@example.com' and password 'secret' exists
    And request data is:
      | key      | value            |
      | email    | test@example.com |
      | password | secret           |
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'data.token' field should not be empty
    And response 'data.user' field should not be empty

  @fail
  Scenario: Fail: Login to non existing account
    Given I send request to '/api/auth/login' using 'POST' method
    And user with email 'test@example.com' not exists
    And request data is:
      | key      | value            |
      | email    | test@example.com |
      | password | secret           |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @fail
  Scenario: Fail: Login with wrong password
    Given I send request to '/api/auth/login' using 'POST' method
    And user with email 'test@example.com' and password 'secret' exists
    And request data is:
      | key      | value            |
      | email    | test@example.com |
      | password | wrongPass        |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @fail
  Scenario: Fail: Login with missing email field
    Given I send request to '/api/auth/login' using 'POST' method
    And request data is:
      | key      | value  |
      | password | secret |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @fail
  Scenario: Fail: Login with missing password field
    Given I send request to '/api/auth/login' using 'POST' method
    And request data is:
      | key   | value            |
      | email | test@example.com |
    When request is sent
    Then the response status code should be 400
    And response success field should be false