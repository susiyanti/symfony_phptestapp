<?php

namespace AppBundle\Controller;

use AppBundle\Api\ApiProblemException;
use AppBundle\Api\ApiProblem;
use AppBundle\AppBundle;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/users", name="list_user")
     * @Method("GET")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getRepository('AppBundle:User');
        $users = $em->findAll();
        $data = array("users"=>array());
        foreach ($users as $u) {
            $data['users'][] = $this->serialize($u);
        }
        $response = $this->createApiResponse($data, 200);
        return $response;
    }

    /**
     * @Route("/users")
     * @Method("POST")
     */
    public function newAction(Request $request)
    {
        $user = new User();
        //$form = $this->createForm(new UserType(), $user);
//        $form = $this->createFormBuilder($user)
  //          ->add('uuid', TextType::class)
    //        ->add('nama', TextType::class)
      //      ->add('alamat', TextType::class)
        //    ->getForm();
        //$this->processForm($request, $form);

       // if(!$form->isValid()){
         //   $this->throwApiProblemValidationException($form);
        //}
//        $data = $request->query->get("nama");
        $user->setNama($request->request->get("nama"));
        $user->setAlamat($request->request->get("alamat"));
        $user->setUuid($request->request->get("uuid"));
        $em = $this ->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $response = $this->createApiResponse($user, 201);
        return $response;
    }

    private function processForm(Request $request, FormInterface $form)
    {
        $data = json_decode($request->getContent(), true);
        //$data = $request->getContent();
        if($data === null){
            $apiProblem = new ApiProblem(400, ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
            throw new ApiProblemException($apiProblem);
        }
        $clearMissing = $request->getMethod() != 'PATCH';
        $form->submit($data, $clearMissing);
    }

    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }

    private function throwApiProblemValidationException(FormInterface $form)
    {
        $apiProblem = new ApiProblem(
            400,
            ApiProblem::TYPE_VALIDATION_ERROR
        );

        $errors = $this->getErrorsFromForm($form);

        $apiProblem->set('errors',$errors);

        throw new ApiProblemException($apiProblem);
    }

    protected function serialize($data, $format='json')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);
        #$serializer = $this->get("serializer");
        $serializer = $this->container->get('jms_serializer');
        $jsonContent = $serializer->serialize($data,$format, $context);
        return $jsonContent;
    }

    protected function createApiResponse($data, $statusCode = 200)
    {
        $json = $this->serialize($data);
        return new Response($json, $statusCode, array(
            'Content-Type' => 'application/json'
        ));
    }
}

