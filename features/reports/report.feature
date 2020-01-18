@report

Feature: Report

  @success
  Scenario: Report review
    Given I send request to '/api/review/report' using 'POST' method
    And I am logged in as User
    And review with id 16 exist
    And review with id 16 author is not logged user
    And request data is:
      | key | value |
      | id  | 16    |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Report review with empty data
    Given I send request to '/api/review/report' using 'POST' method
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
      | key | value |
      | id  | 1929  |
    When request is sent
    Then the response status code should be 404
    And response success field should be false

  @success
  Scenario: Solve Report as not offensive
    Given  I send request to '/api/report/resolve' using 'POST' method
    And I am logged in as Admin
    And user with id 13 exist
    And report with id 13 reported by user with id 13 about review with id 13 exist
    And request data is:
      | key       | value |
      | id        | 14    |
      | action_id | 1     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @success
  Scenario: Solve Report and remove review
    Given I send request to '/api/report/resolve' using 'POST' method
    And I am logged in as Admin
    And user with id 17 exist
    And review with id 17 exist
    And report with id 17 reported by user with id 17 about review with id 17 exist
    And request data is:
      | key       | value |
      | id        | 17    |
      | action_id | 2     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And review with id 17 is deleted

  @success
  Scenario: Solve Report and remove review and author
    Given I send request to '/api/report/resolve' using 'POST' method
    And I am logged in as Admin
    And user with id 25 exist
    And review with id 25 exist
    And report with id 25 reported by user with id 25 about review with id 25 exist
    And request data is:
      | key       | value |
      | id        | 25    |
      | action_id | 3     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And review with id 25 is deleted
    And review with id 25 author is deleted

  @fail
  Scenario: Resolve not existing report
    Given  I send request to '/api/report/resolve' using 'POST' method
    And I am logged in as Admin
    And report with id 2133 not exist
    And request data is:
      | key       | value |
      | id        | 2133  |
      | action_id | 2     |
    When request is sent
    Then the response status code should be 404
    And response success field should be false