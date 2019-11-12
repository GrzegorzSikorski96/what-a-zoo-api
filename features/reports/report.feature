@report

Feature: Report resolving

  @success
  Scenario: Setting Report as offensive
    Given  I send request to '/api/reports/resolve' using 'POST' method
    And I am logged in as Admin
    And request data is:
      | key       | value |
      | id        | 1     |
      | offensive | true  |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @success
  Scenario: Setting Report as offensive
    Given  I send request to '/api/reports/resolve' using 'POST' method
    And I am logged in as Admin
    And request data is:
      | key       | value |
      | id        | 1     |
      | offensive | false |
    When request is sent
    Then the response status code should be 200
    And response success field should be true