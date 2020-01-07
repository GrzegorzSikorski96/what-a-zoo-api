@visitedZoos

Feature: Visited Zoos

  @success
  Scenario: Get list of visited zoos when logged in
    Given I send request to '/api/zoos/visited' using 'GET' method
    And I am logged in as User
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'visited' field should be array

  @fail
  Scenario: Get list of visited zoos when not logged in
    Given I send request to '/api/zoos/visited' using 'GET' method
    When request is sent
    Then the response status code should be 401
    And response success field should be false

  @success
  Scenario: Get list of friend visited zoos when logged in and user is friend
    Given I send request to '/api/user/1/visited'
    And I am logged in as User
    And user with id '1' is friend
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'visited' field should be array

  @fail
  Scenario: Get list of friend visited zoos when logged in and user is not friend
    Given I send request to '/api/user/1/visited'
    And I am logged in as User
    And user with id '1' is not friend
    When request is sent
    Then the response status code should be 401
    And response success field should be false
