@users

Feature: Users

  @success
  Scenario: Get users list
    Given I send request to '/api/users' using 'GET' method
    And I am logged in as User
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'data.users' field type should be array

  @success
  Scenario: Get user data
    Given I send request to '/api/user/2' using 'GET' method
    And I am logged in as User
    And user with id 1 exist
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'data.user' field type should be array

  @success
  Scenario: Ban a user
    Given I send request to '/api/user/2/ban/' using 'POST' method
    And I am logged in as Admin
    And user with id 2 exist
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response message should be 'user.banned.success'

  @fail
  Scenario: Ban a non existing user
    Given I send request to '/api/user/123/ban/' using 'POST' method
    And I am logged in as Admin
    And user with id 123 not exist
    When request is sent
    Then the response status code should be 404
    And response success field should be false