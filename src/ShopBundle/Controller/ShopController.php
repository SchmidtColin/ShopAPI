<?php
/**
 * Created by PhpStorm.
 * User: cw
 * Date: 08.09.2017
 * Time: 11:40
 */

namespace ShopBundle\Controller;



use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
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
     *    description="Creating a shop",
     *      parameters={
     *          {"name"="interfacePassword", "dataType"="string", "required"="", "description"="password"},
     *          {"name"="lastSync", "dataType"="datetime", "required"="", "description"="last synchronisation"},
     *          {"name"="lastSyncResponseCode", "dataType"="integer", "required"="", "description"="last response code"},
     *          {"name"="lastProcessed", "dataType"="datetime", "required"="", "description"="last processed"}
     *      }
     *     )
     * @Route("/shop")
     * @param Request $request
     * @return View
     */
    public function postShop(Request $request)
    {
        $shop = new Shops();
        $interfacePassword = $request->get('interfacePassword');
        $lastSync = $request->get('lastSync');
        $lastSyncResponseCode = $request->get('lastSyncResponseCode');
        $lastProcessed = $request->get('lastProcessed');

        $shop->setInterfacePassword($interfacePassword);
        $shop->setLastSync($lastSync);
        $shop->setLastSyncResponseCode($lastSyncResponseCode);
        $shop->setLastProcessed($lastProcessed);

        $em = $this->getDoctrine()->getManager();
        $em->persist($shop);
        $em->flush();
        return new View('Shop Added Successfully', Response::HTTP_OK);

    }

    /**
     * @Method ({"GET"})
     * @ApiDoc(
     *    description="Lists all shops.
     *                 Filtered by pagesize",
     *    filters={
     *     {"name"="page", "dataType"="integer", "required"="true", "default"="1", "description"="pagenumber"},
     *     {"name"="limit", "dataType"="integer", "required"="true", "default"="3", "description"="items per page"}
     *     }
     *
     * )
     * @Route("/shop/")
     * @param Request $request
     * @return View|object|Shops
     */
    public function getShop(Request $request)
    {
        $query = $this->getDoctrine()->getRepository('ShopBundle:Shops')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, $request->query->getInt('page',1),
            $request->query->getInt('limit', 3)
        );

        return $pagination;
    }

    /**
     * @Method ({"GET"})
     * @ApiDoc(
     *     description="Lists all reviews of a shop, depending on id and password.
     *                  Filtered by pagesize; possibile to filter by creation- or updating date.",
     *
     *    parameters={
     *     {"name"="id", "dataType"="integer", "required"="true", "description"="pagenumber"},
     *     {"name"="password", "dataType"="string", "required"="true", "description"="items per page"}
     *     },
     *
     *    filters={
     *     {"name"="page", "dataType"="integer", "required"="true", "default"="1", "description"="pagenumber"},
     *     {"name"="limit", "dataType"="integer", "required"="true", "default"="3", "description"="items per page"}
     *     }
     *
     * )
     * @Route("/shopReview/")
     * @param Request $request
     * @return View|object|\ShopBundle\Entity\ShopReviews
     */
    public function getReview(Request $request)
    {
        $id=$request->query->get('id');
        $password=$request->query->get('password');
        $query = $this->getDoctrine()->getRepository('ShopBundle:ShopReviews')->getByShop($id, $password);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, $request->query->getInt('page',1),
            $request->query->getInt('limit', 3)
        );
        return $pagination;
    }



}