@registration
Feature: Registration system

  @success
  Scenario: Success: Register new account
    Given I send request to '/api/register' using 'POST' method
    And user with email 'test@example.com' not exists
    And request data is:
      | key                   | value            |
      | name                  | test             |
      | surname               | testSurname      |
      | email                 | test@example.com |
      | password              | secret           |
      | password_confirmation | secret           |
    When request is sent
    Then the response status code should be 200
    And response success field should be true
    And response message should be 'registration.success'

  @fail
  Scenario: Fail: Trying to register account with already used email
    Given I send request to '/api/register' using 'POST' method
    And user with email 'test@example.com' exists
    And request data is:
      | key                   | value            |
      | name                  | test             |
      | surname               | testSurname      |
      | email                 | test@example.com |
      | password              | secret           |
      | password_confirmation | secret           |
    When request is sent
    Then the response status code should be 400
    And response success field should be false
    And response message should be 'registration.failed'

  @fail
  Scenario: Fail: Trying to register account with to short password
    Given I send request to '/api/register' using 'POST' method
    And user with email 'test@example.com' not exists
    And request data is:
      | key                   | value            |
      | name                  | test             |
      | surname               | testSurname      |
      | email                 | test@example.com |
      | password              | secre            |
      | password_confirmation | secre            |
    When request is sent
    Then the response status code should be 400
    And response success field should be false
    And response message should be 'registration.failed'

  @fail
  Scenario: Fail: Trying to register account with bad passwords
    Given I send request to '/api/register' using 'POST' method
    And user with email 'test@example.com' not exists
    And request data is:
      | key                   | value            |
      | name                  | test             |
      | surname               | testSurname      |
      | email                 | test@example.com |
      | password              | secret           |
      | password_confirmation | notsecret        |
    When request is sent
    Then the response status code should be 400
    And response success field should be false
    And response message should be 'registration.failed'

  @fail
  Scenario: Fail: Trying to register account with bad email
    Given I send request to '/api/register' using 'POST' method
    And request data is:
      | key                   | value       |
      | name                  | test        |
      | surname               | testSurname |
      | email                 | bademail    |
      | password              | secret      |
      | password_confirmation | secret      |
    When request is sent
    Then the response status code should be 400
    And response success field should be false
    And response message should be 'registration.failed'
