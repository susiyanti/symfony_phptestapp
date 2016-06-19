<?php
/**
 * Created by PhpStorm.
 * User: susiyanti
 * Date: 6/17/16
 * Time: 10:53 AM
 */

namespace AppBundle\Api;


use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiProblemException extends HttpException
{
    private $apiProblem;

    public function __construct(ApiProblem $apiProblem, \Exception $previous = null, array $headers = array(), $code = 0)
    {
        $this->apiProblem = $apiProblem;
        parent::__construct($apiProblem->getStatusCode(), $apiProblem->getTitle(), $previous, $headers, $code);
    }

    /**
     * @return ApiProblem
     */
    public function getApiProblem()
    {
        return $this->apiProblem;
    }

    
}