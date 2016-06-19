<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Created by PhpStorm.
 * User: susiyanti
 * Date: 6/19/16
 * Time: 4:04 PM
 */

/**
 * @ORM\Table(name="battle_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private $nama;

    /**
     * @ORM\Column(type="string")
     */
    private $alamat;
}