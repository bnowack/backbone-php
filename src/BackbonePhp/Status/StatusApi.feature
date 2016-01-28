Feature: Status API
    In order to monitor the application
    As an application maintainer
    I can access a status page with system information

    @ui
    Scenario: View status page
        Given I go to "/api/status"
        Then I should get a successful response with format "json"
        And I should see a JSON field "status" with value "ok"
        And I should see a JSON field "timestamp"
