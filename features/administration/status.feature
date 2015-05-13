Feature: Status page
    In order to monitor the application
    As an application maintainer
    I can access a status page with system information

        Given I go to "/administration/status"
    Scenario: View status page
        Then I should get a successful response with format "json"
        And I should see a field "status" with value "ok"
        And I should see a field "timestamp"
