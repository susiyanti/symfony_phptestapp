<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Created by PhpStorm.
 * User: susiyanti
 * Date: 6/19/16
 * Time: 4:04 PM
 */

/**
 * @ORM\Table(name="battle_user")
 * @ORM\Entity()
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return mixed
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * @param mixed $nama
     */
    public function setNama($nama)
    {
        $this->nama = $nama;
    }

    /**
     * @return mixed
     */
    public function getAlamat()
    {
        return $this->alamat;
    }

    /**
     * @param mixed $alamat
     */
    public function setAlamat($alamat)
    {
        $this->alamat = $alamat;
    }
    
    
}