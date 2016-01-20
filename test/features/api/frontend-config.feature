Feature: Frontend-Config API
    In order to access the application configuration
    As a developer
    I can retrieve the configuration via an API

    @ui
    Scenario: Retrieve the frontend configuration
        Given I go to "/api/config"
        Then I should get a successful response with format "json"
        And I should see a JSON field "appBase" with value "/"
        And I should see a JSON field "models"
