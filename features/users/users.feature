@users

Feature: Report resolving

  @success
  Scenario: Ban a user
    Given I send request to '/api/user/1/ban/' using 'POST' method
    And I am logged in as Admin
    And User with id '1' exist
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response message field should be 'user.banned.success'

  @fail
  Scenario: Ban a non existing user
    Given I send request to '/api/user/123/ban/' using 'POST' method
    And I am logged in as Admin
    And user with id '123' not exists
    When request is sent
    Then the response status code should be 404
    And response success field should be false