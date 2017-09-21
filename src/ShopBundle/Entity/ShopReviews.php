<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShopReviews
 *
 * @ORM\Table(name="shop_reviews", indexes={@ORM\Index(name="fk_shop", columns={"fk_shop"})})
 * @ORM\Entity(repositoryClass="ShopBundle\Repository\shop_reviewsRepository")
 */
class ShopReviews
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="order_id", type="string", length=128, nullable=true)
     */
    private $orderId;

    /**
     * @var integer
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    private $rating;

    /**
     * @var string
     *
     * @ORM\Column(name="review", type="text", length=65535, nullable=true)
     */
    private $review;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", length=65535, nullable=true)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=512, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=256, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="client_id", type="string", length=512, nullable=true)
     */
    private $clientId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="order_day", type="datetime", nullable=true)
     */
    private $orderDay;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=256, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=256, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="screen_name", type="string", length=256, nullable=true)
     */
    private $screenName;

    /**
     * @var integer
     *
     * @ORM\Column(name="submitted", type="bigint", nullable=true)
     */
    private $submitted;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=192, nullable=true)
     */
    private $hash;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \ShopBundle\Entity\Shops
     *
     * @ORM\ManyToOne(targetEntity="ShopBundle\Entity\Shops")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_shop", referencedColumnName="id")
     * })
     */
    private $fkShop;


}

