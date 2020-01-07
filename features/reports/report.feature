@report

Feature: Report

  @success
  Scenario: Report review
    Given I send request to '/api/review/report' using 'POST' method
    And I am logged in as User
    And review with id '1' exist
    And request data is:
      | key       | value |
      | review_id | 1     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Report review with empty data
    Given I send request to '/api/report' using 'GET' method
    And I am logged in as User
    And request data is:
      | key | value |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @false
  Scenario: Report not existing review
    Given I send request to '/api/review/report' using 'POST' method
    And I am logged in as User
    And Review with id '1929' not exist
    And request data is:
      | key       | value |
      | review_id | 1929  |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @success
  Scenario: Setting Report as offensive
    Given  I send request to '/api/report/resolve' using 'POST' method
    And I am logged in as Admin
    And report with id '1' exist
    And request data is:
      | key       | value |
      | id        | 1     |
      | offensive | true  |
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And review with id '1' should be deleted

  @success
  Scenario: Setting Report as not offensive
    Given  I send request to '/api/report/resolve' using 'POST' method
    And I am logged in as Admin
    And report with id '1' exist
    And request data is:
      | key       | value |
      | id        | 1     |
      | offensive | false |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Resolve not existing report
    Given  I send request to '/api/report/resolve' using 'POST' method
    And I am logged in as Admin
    And report with id '1' not exist
    And request data is:
      | key       | value |
      | id        | 1     |
      | offensive | false |
    When request is sent
    Then the response status code should be 400
    And response success field should be false