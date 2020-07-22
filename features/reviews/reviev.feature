@review
Feature: Review

  @success
  Scenario: Add review
    Given I send request to '/api/zoo/addReview' using 'POST' method
    And I am logged in as User
    And Zoo with id '1' exist
    And Zoo with id 1 is visited
    And Logged user never add review to zoo with id 1
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
    Given I send request to '/api/zoo/addReview' using 'POST' method
    And I am logged in as User
    And Zoo with id '1' exist
    And Zoo with id 1 is visited
    And Logged user never add review to zoo with id 1
    And request data is:
      | key    | value |
      | rating | 5     |
      | zoo_id | 1     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Add review without rating
    Given I send request to '/api/zoo/addReview' using 'POST' method
    And I am logged in as User
    And Zoo with id '1' exist
    And Zoo with id 1 is visited
    And Logged user never add review to zoo with id 1
    And request data is:
      | key    | value             |
      | review | Super zoo, daje 5 |
      | zoo_id | 1                 |
    When request is sent
    Then the response status code should be 400
    And response success field should be false
    And response 'data.review' field should be null

  @fail
  Scenario: Add review with too many stars
    Given I send request to '/api/zoo/addReview' using 'POST' method
    And I am logged in as User
    And Zoo with id '1' exist
    And Zoo with id 1 is visited
    And Logged user never add review to zoo with id 1
    And request data is:
      | key    | value             |
      | rating | 1000              |
      | review | Super zoo, daje 5 |
      | zoo_id | 1                 |
    When request is sent
    Then the response status code should be 400
    And response success field should be false

  @success
  Scenario: Remove my review
    Given I send request to '/api/review/remove' using 'DELETE' method
    And I am logged in as User
    And review with id 5 exist
    And review with id 5 author is logged user
    And request data is:
      | key | value |
      | id  | 5     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Remove somebody else reviews as normal user
    Given I send request to '/api/review/remove' using 'DELETE' method
    And I am logged in as User
    And review with id 23 exist
    And review with id 23 author is not logged user
    And request data is:
      | key | value |
      | id  | 23    |
    When request is sent
    Then the response status code should be 403
    And response success field should be false

  @success
  Scenario: Remove somebody else reviews as administrator
    Given I send request to '/api/review/remove' using 'DELETE' method
    And I am logged in as Admin
    And review with id 30 exist
    And review with id 30 author is not logged user
    And request data is:
      | key | value |
      | id  | 30    |
    When request is sent
    Then the response status code should be 200
    And response success field should be true


