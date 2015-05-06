<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
    
    /**
     * @Given I go to :arg1
     */
    public function iGoTo($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should get a successful response with format :arg1
     */
    public function iShouldGetASuccessfulResponseWithFormat($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a field :arg1 with value :arg2
     */
    public function iShouldSeeAFieldWithValue($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Then I should see a field :arg1
     */
    public function iShouldSeeAField($arg1)
    {
        throw new PendingException();
    }    
}
