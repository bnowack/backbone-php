<?php

namespace BackbonePhp\Controller;

/**
 * BackbonePHP Controller Class
 */
class StatusController extends Controller
{

    /**
     * Processes a status request
     * 
     * @param \BackbonePhp\Request $request Request
     * @param \BackbonePhp\Response $response Response
     * @param \stdClass $route Route object
     * @return \BackbonePhp\Controller Controller instance
     */
    public function handleStatusRequest($request, $response, $route)
    {
        $content = (object)[
            "status" => "ok",
            "timestamp" => time()
        ];
        $response
            ->setType('application/json')
            ->setBody($content)
        ;
        return $this;
    }

}
