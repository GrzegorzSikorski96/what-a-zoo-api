@feed

Feature: Feed

  @success
  Scenario: get news when authenticated
    Given I send request to '/api/news' using 'GET' method
    And authenticated by email 'test@example.com' and password 'secret'
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response 'data.news' field should be array

  @fail
  Scenario: Get news when not logged in
    Given I send request to '/api/news' using 'GET' method
    When request is sent
    Then the response status code should be 401
    And response success field should be false