Feature: Application Configuration
    In order to configure the application
    As a developer
    I can define and use configuration options

    Scenario: Set and get configuration options
        Given an application object
        And I set the config option "foo" to "bar"
        Then I should get "bar" for config option "foo"
        Then I should get NULL for config option "baz"

    Scenario: Load configuration options
        Given an application object
        And I load configuration options from "fixtures/config-1.json"
        Then I should get "bar" for config option "foo"
        Then I should get NULL for config option "baz"

    Scenario: Combine multiple configuration files
        Given an application object
        And I load configuration options from "fixtures/config-1.json"
        And I load configuration options from "fixtures/config-2.json"
        Then I should get "baz" for config option "foo"
        Then I should get "test" for config option "bat"
        Then I should count 2 entries for config option "permissions" 
