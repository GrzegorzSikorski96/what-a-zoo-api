@friendsList

Feature: Friend List

  @success
  Scenario: Get friend list when authenticated
    Given I send request to '/api/friends' using 'GET' method
    And authenticated by email 'test@example.com' and password 'secret'
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'data.friends' field type should be array

  @fail
  Scenario: Get friends list when unauthenticated
    Given I send request to '/api/friends' using 'GET' method
    When request is sent
    Then the response status code should be 401
    And response success field should be false
