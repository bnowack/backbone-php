<?php
namespace BackbonePhp\Behat;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\MinkExtension\Context\MinkContext;

use PHPUnit_Framework_TestCase as Assertions;

use Behat\Testwork\Hook\Scope\BeforeSuiteScope;
use RuntimeException;

/**
 * Defines application features from the specific context.
 */
class ProjectContext extends MinkContext implements Context, SnippetAcceptingContext
{

    /**
     * @var int Web server pid
     */
    private static $httpdPid;
    
    /**
     * @var int ghost driver pid
     */
    private static $ghostDriverPid;
    
    /**
     * Initializes context.
     */
    public function __construct()
    {
    }

    /** 
     * Starts the CLI web server for UI tests
     * 
     * Add an 'httpd:    { port: 8888, root: %paths.base% }' suite setting to your `behat.yml` file.
     * 
     * @BeforeSuite
     */
    public static function startWebServer(BeforeSuiteScope $scope)
    {
        if ($scope->getSuite()->hasSetting('httpd')) {
            $config = $scope->getSuite()->getSetting('httpd');
            $port = $config['port'];
            $root = $config['root'];
            $host = 'localhost';
            $routerString = isset($config['router'])
                ? ' ' . $config['router']
                : '';
            // launch if not already up
            if (!self::serverIsUp($host, $port)) {
                $command = "php -S $host:$port -t $root$routerString >/dev/null 2>&1 & echo $!";
                $output = trim(shell_exec($command));
                self::$httpdPid = is_numeric($output) ? intval($output) : null;
                
            }
            // check that the server is running, wait up to 2 seconds
            $attempts = 0;
            do {
                $up = self::serverIsUp($host, $port);
                $attempts++;
                usleep(100000); // 0.1 sec
            }
            while (!$up && $attempts < 20);
            if (!$up) {
                self::stopProcess(self::$httpdPid);// just in case it *did* start but did not respond in time
                throw new RuntimeException("Could not start web server at $host:$port");
            }
        }
    }
    
    /**
     * Stops the Web server
     * 
     * @AfterSuite
     */
    public static function stopWebServer()
    {
        self::stopProcess(self::$httpdPid);
    }    

    /** 
     * Starts the phantomjs GhostDriver for UI tests
     * 
     * Add a 'ghostd:   { port: 8643 }' suite setting to your `behat.yml` file.
     * 
     * @BeforeSuite
     */
    public static function startGhostDriver(BeforeSuiteScope $scope)
    {
        if ($scope->getSuite()->hasSetting('ghostd')) {
            $config = $scope->getSuite()->getSetting('ghostd');
            $port = $config['port'];
            $host = 'localhost';
            // launch if not already up
            if (!self::serverIsUp($host, $port)) {
                $command = "phantomjs --webdriver=$port >/dev/null 2>&1 & echo $!";
                $output = trim(shell_exec($command));
                self::$ghostDriverPid = is_numeric($output) ? intval($output) : null;
            }
            // check that the server is running, wait up to 5 seconds
            $attempts = 0;
            do {
                $up = self::serverIsUp($host, $port);
                $attempts++;
                usleep(100000); // 0.1 sec
            }
            while (!$up && $attempts < 50);
            if (!$up) {
                self::stopProcess(self::$ghostDriverPid);// just in case it *did* start but did not respond in time
                throw new RuntimeException("Could not start ghost driver at $host:$port");
            }
        }
    }
    
    /**
     * Stops the ghost driver
     * 
     * @AfterSuite
     */
    public static function stopGhostDriver()
    {
        self::stopProcess(self::$ghostDriverPid);
    }    
    
    /**
     * Checks whether a server is running
     * 
     * @param string $host
     * @param string $port
     * @return boolean True if server is up, false otherwise
     */
    protected static function serverIsUp($host, $port)
    {
        set_error_handler(function() { return true; });
        $fp = fsockopen($host, $port);
        restore_error_handler();
        if ($fp) {
            fclose($fp);
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * Stops a system process
     * 
     * @param int $pid Process ID
     */
    protected static function stopProcess($pid)
    {
        if ($pid) {
            trim(shell_exec("kill " . $pid . " 2>&1"));
        }
    }
    
    /**
     * Returns a list of header values for the provided header name
     *
     * @param string $name Header name (case-insensitive)
     * @return null|array List of header values
     */
    protected function getResponseHeaders($name)
    {
        $headers = $this->getSession()->getResponseHeaders();
        foreach ($headers as $headerName => $headerValues) {
            if (strtolower($name) === strtolower($headerName)) {
                return $headerValues;
            }
        }
        return null;
    }
    
    /**
     * @Then I should get a successful response
     */
    public function iShouldGetASuccessfulResponse()
    {
        $session = $this->getSession();
        $actual = $session->getStatusCode();
        Assertions::assertGreaterThanOrEqual(200, $actual, 'The response should be successful');
        Assertions::assertLessThan(300, $actual, 'The response should be successful');
    }

    /**
     * @Then I should get a successful response with format :format
     */
    public function iShouldGetASuccessfulResponseWithFormat($format)
    {
        $this->iShouldGetASuccessfulResponse();
        $actual = $this->getResponseHeaders('content-type')[0];
        Assertions::assertRegExp("~$format~i", $actual, "Response type should match '$format'");
    }

}
