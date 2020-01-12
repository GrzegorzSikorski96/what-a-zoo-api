@zoos

Feature: Zoos

  @success
  Scenario: Get one zoo with its reviews
    Given I send request to '/api/zoo/1' using 'GET' method
    And I am logged in as User
    And Zoo with id 1 exist
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'data.zoo' field should not be empty
    And response 'data.reviews' field type should be array

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
    Then the response status code should be 403
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
    And response 'data.zoo.name' field should be 'newTestZoo'
    And response 'data.zoo.latitude' field should be 38
    And response 'data.zoo.longitude' field should be 58

  @fail
  Scenario: Add zoo without coordinates
    Given I send request to '/api/zoo/add' using 'POST' method
    And I am logged in as Admin
    And request data is:
      | key  | value   |
      | name | testZoo |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @fail
  Scenario: Add zoo with non existing coordinates
    Given I send request to '/api/zoo/add' using 'POST' method
    And I am logged in as Admin
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
    Given I send request to '/api/zoo/remove' using 'DELETE' method
    And I am logged in as Admin
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
    And Zoo with id 1 exist
    And request data is:
      | key | value |
      | id  | 1     |
    When request is sent
    Then the response status code should be 403
    And response success field should be false