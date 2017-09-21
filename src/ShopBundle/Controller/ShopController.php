<?php
/**
 * Created by PhpStorm.
 * User: cw
 * Date: 08.09.2017
 * Time: 11:40
 */

namespace ShopBundle\Controller;

use DateTime;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use function is_numeric;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ShopBundle\Entity\Shops;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends FOSRestController
{


    /**
     * @Method ({"POST"})
     * @ApiDoc(
     *     section="shop",
     *    description="Creating a shop",
     *      parameters={
     *          {"name"="id", "dataType"="integer", "required"="true", "description"="shop id"},
     *          {"name"="interfacePassword", "dataType"="string", "required"="true", "description"="password"}
     *      }
     *     )
     * @Route("/shop")
     * @param Request $request
     * @return View
     */
    public function postShop(Request $request)
    {

        $shop = new Shops();
        $id = $request->get('id');
        $interfacePassword = $request->get('interfacePassword');

        $shop->setId($id);
        $shop->setInterfacePassword($interfacePassword);
        $shop->setLastSync(new DateTime());
        $shop->setLastSyncResponseCode(Response::HTTP_OK);
        $shop->setLastProcessed(new DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($shop);
        $em->flush();
        return new View('Shop Added Successfully', Response::HTTP_OK);

    }

    /**
     * @Method ({"GET"})
     * @ApiDoc(
     *     section="shop",
     *    description="Lists all shops. Filtered by pagesize",
     *    filters={
     *     {"name"="firstElement", "dataType"="integer", "required"="true", "default"="1", "description"="item to start with"},
     *     {"name"="items", "dataType"="integer", "required"="true", "default"="3", "description"="number of items to list"}
     *     }
     *
     * )
     * @Route("/shop")
     * @param Request $request
     * @return View|object|Shops
     */
    public function getShop(Request $request)
    {
        $firstElement = $request->query->get('firstElement');
        $items = $request->query->get('items');

        if ($firstElement < 1)
            return new View('first element must be > 0 ', Response::HTTP_NOT_FOUND);
        if ($items < 0)
            return new View('number of items must be >= 0 ', Response::HTTP_NOT_FOUND);
        $query = $this->getDoctrine()->getRepository('ShopBundle:Shops')->getByBorders($firstElement, $items);
        return $query;
    }

    /**
     * @Method ({"GET"})
     * @ApiDoc(
     *     section="review",
     *     description="Lists all reviews of a shop, depending on id and password. Filtered by pagesize; possible to filter by creation- or updating date.",
     *
     *    requirements={
     *     {"name"="id", "dataType"="integer", "required"="true", "default"="1234", "description"="id of searched shop"},
     *     {"name"="password", "dataType"="string", "required"="true", "default"="password", "description"="password of searched shop"}
     *     },
     *
     *    filters={
     *     {"name"="first_element", "dataType"="integer", "required"="true", "default"="1", "description"="entry to start with"},
     *     {"name"="items", "dataType"="integer", "required"="true", "default"="3", "description"="number of items to list"},
     *     {"name"="creation", "dataType"="datetime", "required"="false", "default"="2017-08-13 13:56:59", "description"="date of creation"},
     *     {"name"="creation_to", "dataType"="datetime", "required"="false", "default"="2017-08-13 13:56:59", "description"="if creation is set, results between those dates will be listed"},
     *     {"name"="update", "dataType"="datetime", "required"="false", "default"="2017-08-13 13:56:59", "description"="date of last update "},
     *     {"name"="update_to", "dataType"="datetime", "required"="false", "default"="2017-08-13 13:56:59", "description"="if update is set, results between those dates will be listed"},
     *     }
     *
     * )
     * @Route("/shop/{id}/reviews")
     * @param Request $request
     * @param int $id
     * @return View|object|\ShopBundle\Entity\ShopReviews
     */
    public function getReview(Request $request, $id)
    {
        $password = $request->query->get('password');
        $firstElement = $request->query->get('first_element');
        $items = $request->query->get('items');
        $creation = $request->query->get('creation');
        $update = $request->query->get('update');
        $creationTo = $request->query->get('creation_to');
        $updateTo = $request->query->get('update_to');

        if (!is_numeric($id) or $id === null)
            return new View('Pleas enter id as a number!', Response::HTTP_NOT_FOUND);
        if ($password === null)
            return new View('Pleas enter a password', Response::HTTP_NOT_FOUND);
        if ($firstElement < 1)
            return new View('first element must be > 0 ', Response::HTTP_NOT_FOUND);
        if ($items < 1)
            return new View('number of items must be > 0 ', Response::HTTP_NOT_FOUND);

        if ($creation !== null and DateTime::createFromFormat('Y-m-d H:i:s', $creation) === FALSE) {
            return new View('creation has no valid date format!', Response::HTTP_NOT_FOUND);
        }
        if ($update !== null and DateTime::createFromFormat('Y-m-d H:i:s', $update) === FALSE) {
            return new View('update has no valid date format!', Response::HTTP_NOT_FOUND);
        }
        if ($creationTo !== null and DateTime::createFromFormat('Y-m-d H:i:s', $creationTo) === FALSE) {
            return new View('creation_to has no valid date format!', Response::HTTP_NOT_FOUND);
        }
        if ($updateTo !== null and DateTime::createFromFormat('Y-m-d H:i:s', $updateTo) === FALSE) {
            return new View('update_to has no valid date format!', Response::HTTP_NOT_FOUND);
        }

        $query = $this->getDoctrine()->getRepository('ShopBundle:ShopReviews')->getByShop($id, $password, $firstElement, $items);
        if (empty($query))
            return new View('Either, there is no shop with that id, or you entered a wrong password!', Response::HTTP_NOT_FOUND);
        if ($creation !== null) {
            $creationTo = ($creationTo === null ? $creation : $creationTo);
            $query = $this->getDoctrine()->getRepository('ShopBundle:ShopReviews')->getByCreationBetween($id, $password, $firstElement, $items, $creation, $creationTo);
        }
        if ($creation === null and $update !== null) {
            $updateTo = ($updateTo === null ? $update : $updateTo);
            $query = $this->getDoctrine()->getRepository('ShopBundle:ShopReviews')->getByUpdateBetween($id, $password, $firstElement, $items, $update, $updateTo);
        }
        if($creation !== null and $update !== null)
        {
            $creationTo = ($creationTo === null ? $creation : $creationTo);
            $updateTo = ($updateTo === null ? $update : $updateTo);
            $query = $this->getDoctrine()->getRepository('ShopBundle:ShopReviews')->getByCreationAndUpdateDate($id, $password, $firstElement, $items, $creation, $creationTo, $update, $updateTo);
        }
        return $query;
    }


}