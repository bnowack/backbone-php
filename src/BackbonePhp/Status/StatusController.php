<?php

namespace BackbonePhp\Status;

use \BackbonePhp\Request\Request;
use \BackbonePhp\Response\Response;
use \BackbonePhp\Controller\Controller;

/**
 * Status Controller Class
 */
class StatusController extends Controller
{

    /**
     * Processes a status request
     * 
     * @param Request $request Request
     * @param Response $response Response
     * @param \stdClass $route Route object
     * @return Controller Controller instance
     */
    public function handleStatusRequest($request, $response, $route)
    {
        $content = (object)[
            "status" => "ok",
            "timestamp" => time()
        ];
        $response
            ->setCode(200)
            ->setType('application/json')
            ->setBody($content)
        ;
        return $this;
    }

}
