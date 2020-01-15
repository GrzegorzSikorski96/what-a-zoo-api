@reportList

Feature: Reports

  @success
  Scenario: Accessing report panel as Admin
    Given I send request to '/api/reports' using 'GET' method
    And I am logged in as Admin
    When request is sent
    Then the response status code should be 200
    And  response success field should be true
    And response 'data.reports' field should not be empty

  @fail
  Scenario: Accessing report panel as user
    Given I send request to '/api/reports' using 'GET' method
    And I am logged in as User
    When request is sent
    Then the response status code should be 403
    And  response success field should be false

  @fail
  Scenario: Get reports when unauthorized
    Given I send request to '/api/reports' using 'GET' method
    When request is sent
    Then the response status code should be 401
    And response success field should be false

