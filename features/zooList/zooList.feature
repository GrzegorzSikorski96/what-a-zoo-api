Feature: Zoos List

    Background:
        Given a global administrator named 'Admin'
        And a normal user named 'User'
        And 'User' visited 'testZoo' zoo with id equal to 1

    @success
    Scenario: Get list of all zoos
        Given I am logged in as User
        And I send request to '/api/zoos' using 'GET' method
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response 'zoos' field should not be empty

    @fail
    Scenario: Get list of all zoos when not logged in
        Given I send request to '/api/zoos' using 'GET' method
        When request is sent
        Then the response status code should be 400
        And the response success field should be false

    @success
    Scenario: Get list of visited zoos
        Given I am logged in as User
        And I send request to '/api/zoos/visited' using 'GET' method
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response 'zoos' field should filled with one entry 'testZoo'

    @success
    Scenario: Get one zoo with its reviews
        Given I am logged in as User
        And I send request to '/api/zoo/1' using 'GET' method
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response 'zoo' field should be 'testZoo'
        And the response 'reviews' field should not be empty

    @fail
    Scenario: Add zoo as normal user
        Given I am logged in as User 
        And I send request to '/api/zoo/add' using 'POST' method
        And request data is:
        | key       | value       |
        | name      | newTestZoo  |
        | latitude  | 38          |
        | longitude | 58          | 
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
        And the response 'zoo' field should be empty

    @success
    Scenario: Add zoo as administrator
        Given I am logged in as Admin
        And I send request to '/api/zoo/add' using 'POST' method
        And request data is:
        | key       | value       |
        | name      | newTestZoo  |
        | latitude  | 38          |
        | longitude | 58          | 
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response 'zoo.name' field should be 'newTestZoo'
        And the response 'zoo.latitude' field should equal 38
        And the response 'zoo.longitude' field should equal 58

    @fail
    Scenario: Add zoo without coordinates
        Given I am logged in as Admin
        And I send request to '/api/zoo/add' using 'POST' method
        And request data is:
        | key | value |
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
        And the response 'zoo' field should be empty

    @fail    
    Scenario: Add zoo with non existing coordinates
        Given I am logged in as Admin
        And I send request to '/api/zoo/add' using 'POST' method
        And request data is:
        | key       | value       |
        | name      | newTestZoo  |
        | latitude  | 198         |
        | longitude | -213        | 
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
        And the response 'zoo' field should be empty

    @success
    Scenario: Remove zoo
        Given I am logged in as Admin
        And I send request to '/api/zoo/remove' using 'DELETE' method
        And request data is:
        | key       | value |
        | id        | 1     |
        When request is sent 
        Then the response status code should be 200
        And the response success field should be true

    @success
    Scenario: Add review
        Given I am logged in as User
        And I send request to '/api/zoo/addReview' using 'POST' method
        And request data is:
        | key    | value             |
        | rating | 5                 |
        | review | Super zoo, daje 5 |
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response 'review.rating' field should equal 5 

    @success
    Scenario: Add review without comment
        Given I am logged in as User
        And I send request to '/api/zoo/addReview' using 'POST' method
        And request data is:
        | key    | value |
        | rating | 5 |
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
        And the response 'review.rating' field should equal 5 

    @fail
    Scenario: Add review without rating
        Given I am logged in as User
        And I send request to '/api/zoo/addReview' using 'POST' method
        And request data is:
        | key    | value             |
        | review | Super zoo, daje 5 |
        When request is sent
        Then the response status code should be 400
        And the response success field should be false
        And the response 'review' field should be empty

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
        And the response success field should be false

    @success
    Scenario: Remove my review
        Given I am logged in as User
        And I send request to '/review/remove' using 'DELETE'
        And request data is:
        | key | value|
        | id  | 1    |
        When request is sent
        Then the response status code should be 200
        And the response success field should be true

    @fail
    Scenario: Remove somebody else reviews as normal user
        Given I am logged in as User
        And I send request to '/review/remove' using 'DELETE'
        And request data is:
        | key | value|
        | id  | 123  |
        When request is sent
        Then the response status code should be 400
        And the response success field should be false

    @success
    Scenario: Remove somebody else reviews as administrator
        Given I am logged in as Admin
        And I send request to '/review/remove' using 'DELETE'
        And request data is:
        | key | value|
        | id  | 123  |
        When request is sent
        Then the response status code should be 200
        And the response success field should be true

    @success
    Scenario: Report review
        Given a review with id equal to 1 
        And I am logged in as User
        And I send request to '/api/report/add' using 'POST' method
        And request data is:
        | key       | value |
        | review_id | 1     |
        When request is sent
        Then the response status code should be 200
        And the response success field should be true
    
    @fail
    Scenario: Report review with empty data
        And I am logged in as User
        And I send request to '/api/report' using 'GET' method
        And request data is:
        | key | value |
        When request is sent
        Then the response status code should be 400
        And the response success field should be false