@zooList

Feature: Zoos List

  @success
  Scenario: Get list of all zoos when logged in
    Given I send request to '/api/zoos' using 'GET' method
    And I am logged in as User
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'zoos' field should not be empty

  @fail
  Scenario: Get list of all zoos when not logged in
    Given I send request to '/api/zoos' using 'GET' method
    When request is sent
    Then the response status code should be 401
    And response success field should be false