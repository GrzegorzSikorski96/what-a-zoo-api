@zoos

Feature: Zoos

  @success
  Scenario: Get one zoo with its reviews
    Given I send request to '/api/zoo/1' using 'GET' method
    And I am logged in as User
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'zoo' field should not be empty
    And response 'reviews' field should be array

  @fail
  Scenario: Add zoo as normal user
    Given I send request to '/api/zoo/add' using 'POST' method
    And I am logged in as User
    And request data is:
      | key       | value      |
      | name      | newTestZoo |
      | latitude  | 38         |
      | longitude | 58         |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @success
  Scenario: Add zoo as administrator
    Given I send request to '/api/zoo/add' using 'POST' method
    And I am logged in as Admin
    And request data is:
      | key       | value      |
      | name      | newTestZoo |
      | latitude  | 38         |
      | longitude | 58         |
    When request is sent
    Then the response status code should be 200
    And  response success field should be true
    And response 'zoo.name' field should be 'newTestZoo'
    And response 'zoo.latitude' field should equal 38
    And response 'zoo.longitude' field should equal 58

  @fail
  Scenario: Add zoo without coordinates
    Given I am logged in as Admin
    And I send request to '/api/zoo/add' using 'POST' method
    And request data is:
      | key | value |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @fail
  Scenario: Add zoo with non existing coordinates
    Given I am logged in as Admin
    And I send request to '/api/zoo/add' using 'POST' method
    And request data is:
      | key       | value      |
      | name      | newTestZoo |
      | latitude  | 198        |
      | longitude | -213       |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @success
  Scenario: Remove zoo
    Given I am logged in as Admin
    And I send request to '/api/zoo/remove' using 'DELETE' method
    And request data is:
      | key | value |
      | id  | 1     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @success
  Scenario: Remove zoo as user
    Given I send request to '/api/zoo/remove' using 'DELETE' method
    And I am logged in as User
    And zoo with id '1' exist
    And request data is:
      | key | value |
      | id  | 1     |
    When request is sent
    Then the response status code should be 401
    And response success field should be false