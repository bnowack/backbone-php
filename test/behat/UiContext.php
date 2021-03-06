<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Tester\Exception\PendingException;

use PHPUnit_Framework_TestCase as Assertions;

/**
 * Defines application features from the specific context.
 */
class UiContext extends FeatureContext implements Context, SnippetAcceptingContext
{

    /**
     * Initializes context.
     */
    public function __construct()
    {
        parent::__construct();
    }
 
}
