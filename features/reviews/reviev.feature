@review
Feature: Review

  @success
  Scenario: Add review
    Given I send request to '/api/zoo/addReview' using 'POST' method
    And I am logged in as User
    And zoo with id '1' exist
    And request data is:
      | key    | value             |
      | rating | 5                 |
      | review | Super zoo, daje 5 |
      | zoo_id | 1                 |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @success
  Scenario: Add review without comment
    Given I am logged in as User
    And I send request to '/api/zoo/addReview' using 'POST' method
    And request data is:
      | key    | value |
      | rating | 5     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Add review without rating
    Given I am logged in as User
    And I send request to '/api/zoo/addReview' using 'POST' method
    And request data is:
      | key    | value             |
      | review | Super zoo, daje 5 |
    When request is sent
    Then the response status code should be 400
    And response success field should be false
    And response 'review' field should be empty

  @fail
  Scenario: Add review with too many stars
    Given I am logged in as User
    And I send request to '/api/zoo/addReview' using 'POST' method
    And request data is:
      | key    | value             |
      | rating | 1000              |
      | review | Super zoo, daje 5 |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @success
  Scenario: Remove my review
    Given I am logged in as User
    And I send request to '/review/remove' using 'DELETE' method
    And review with id '1' exist
    And request data is:
      | key | value |
      | id  | 1     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Remove somebody else reviews as normal user
    Given I am logged in as User
    And I send request to '/review/remove' using 'DELETE' method
    And review with id '123' exist
    And request data is:
      | key | value |
      | id  | 123   |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @success
  Scenario: Remove somebody else reviews as administrator
    Given I am logged in as Admin
    And I send request to '/review/remove' using 'DELETE' method
    And review with id '123' exist
    And request data is:
      | key | value |
      | id  | 123   |
    When request is sent
    Then the response status code should be 200
    And response success field should be true


