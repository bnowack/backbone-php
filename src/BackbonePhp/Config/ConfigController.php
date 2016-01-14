<?php

namespace BackbonePhp\Config;

use \BackbonePhp\Request\Request;
use \BackbonePhp\Response\Response;
use \BackbonePhp\Controller\Controller;

/**
 * Config Controller Class
 */
class ConfigController extends Controller
{

    /**
     * Dumps all frontend-relevant config
     * 
     * @param Request $request Request
     * @param Response $response Response
     * @param \stdClass $route Route object
     * @return Controller Controller instance
     */
    public function handleFrontendConfigRequest($request, $response, $route)
    {
        $content = $this->config->getFrontendData();
        $response
            ->setCode(200)
            ->setType('application/json')
            ->setBody($content)
        ;
        return $this;
    }

}
