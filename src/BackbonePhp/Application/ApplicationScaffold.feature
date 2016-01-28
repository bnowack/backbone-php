Feature: Application scaffold
    In order to create applications quickly
    As a developer
    I get a working BackboneJS scaffold out of the box

    @ui
    Scenario: Config-free 404 page
        When I am on "/does-not-exist"
        Then I should get the response code 404
        And I should see "Page not found" in the body element

    @ui
    Scenario: Accessing the default homepage
        When I am on "/"
        Then I should get a successful response with format "html"
        And I should see "Welcome - BackbonePHP" in the title element
        And I should see "Welcome to BackbonePHP" in the body element
