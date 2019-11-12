@friend

Feature: Friend

  @success
  Scenario: Get friend
    Given I send request to '/api/friend/1' using 'GET' method
    And authenticated by email 'test@example.com' and password 'secret'
    And user with id '1' is friend
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response "friend" field should not be empty

  @fail
  Scenario: Get friend who is not in your friend
    Given I send request to '/api/friend/5' using 'GET' method
    And authenticated by email 'test@example.com' and password 'secret'
    And user with id '5' is not friend
    When request is sent
    Then the response status code should be 401
    And response success field should be false

  @success
  Scenario: Add friend
    Given I send request to '/api/friend/add' using 'POST' method
    And authenticated by email 'test@example.com' and password 'secret'
    And user with id '5' is not friend
    And request data is:
      | key       | value |
      | friend_id | 5     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response "friend" field should not be empty

  @fail
  Scenario: Add non existing friend
    Given I send request to '/api/friend/add' using 'POST' method
    And authenticated by email 'test@example.com' and password 'secret'
    And user with id '123123' not exists
    And request data is:
      | key       | value  |
      | friend_id | 123123 |
    When request is sent
    Then the response status code should be 404
    And response success field should be false

  @success
  Scenario: Remove friend
    And I send request to '/api/friend/remove' using 'DELETE' method
    And authenticated by email 'test@example.com' and password 'secret'
    And user with id '2' is friend
    And request data is:
      | key       | value |
      | friend_id | 2     |
    When request is sent
    Then the response status code should be 200
    And response success field should be true

  @fail
  Scenario: Remove friend you do not have
    And I send request to '/api/friend/remove' using 'DELETE' method
    And authenticated by email 'test@example.com' and password 'secret'
    And user with id '123' is not friend
    And request data is:
      | key       | value |
      | friend_id | 123   |
    When request is sent
    Then the response status code should be 400
    And response success field should be false