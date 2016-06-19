<?php
/**
 * Created by PhpStorm.
 * User: susiyanti
 * Date: 6/17/16
 * Time: 11:05 AM
 */

namespace AppBundle\EventListener;


use AppBundle\Api\ApiProblem;
use AppBundle\Api\ApiProblemException;
use AppBundle\Api\ResponseFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * @var
     */
    private $debug;
    private $responseFactory;

    /**
     * ApiExceptionSubscriber constructor.
     */
    public function __construct($debug, ResponseFactory $responseFactory)
    {
        $this->debug = $debug;
        $this->responseFactory = $responseFactory;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        if (strpos($event->getRequest()->getPathInfo(), '/api') !== 0) {
            return;
        }
        $e = $event->getException();
        if ($e instanceof ApiProblemException) {
            $apiProblem = $e->getApiProblem();
        }else {
            $statusCode = $e instanceof HttpExceptionInterface ? $e->getStatusCode() : 500;
            if ($statusCode == 500 && $this->debug){
                return;
            }
            $apiProblem = new ApiProblem(
                $statusCode
            );
        }
        if ($e instanceof HttpExceptionInterface) {
            $apiProblem->set('detail', $e->getMessage());
        }
        $response = $this->responseFactory->createResponse($apiProblem);
        return $response;

    }
}