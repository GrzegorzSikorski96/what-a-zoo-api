@routes
Feature: Requesting routes

  @success
  Scenario: Success: Entering home page
    Given I send request to '/api' using 'GET' method
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Fail: Trying to use non existing route
    Given I send request to '/routeThatWillNeverEverBeCreatedAndUsedByAnyone' using 'GET' method
    When request is sent
    Then the response status code should be 404
    And response success field should be false
