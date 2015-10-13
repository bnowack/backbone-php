<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Tester\Exception\PendingException;

use PHPUnit_Framework_TestCase as Assertions;

use BackbonePhp\Behat\ProjectContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends ProjectContext implements Context, SnippetAcceptingContext
{

    /**
     * Initializes context.
     */
    public function __construct()
    {
        parent::__construct();
        $this->testDir = __DIR__ . '/../../';
    }

}
