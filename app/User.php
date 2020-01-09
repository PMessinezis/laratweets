<?php

namespace App;

use JsonSerializable;
use App\Traits\SavesModel;
use App\Traits\EntityReturnsAll;
use Doctrine\ORM\Mapping as ORM;
use LaravelDoctrine\ORM\Serializers\Jsonable;
use Illuminate\Contracts\Auth\Authenticatable;


/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User implements Authenticatable, JsonSerializable
{
    use SavesModel;
    use Jsonable;
    use EntityReturnsAll;

    public function getAuthIdentifierName()
    {
        return 'id';
    }


    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * * @ORM\Column(type="string")
     */
    protected $remember_token;

    /**
     * * @ORM\Column(type="string")
     */
    protected $email;

    /**
     * * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * * @ORM\Column(type="string")
     */
    protected $provider;

    /**
     * * @ORM\Column(type="string")
     */
    protected $provider_id;

    /**
     * * @ORM\Column(type="string")
     */
    protected $provider_token;

    /**
     * * @ORM\Column(type="string")
     */
    protected $provider_secret;

    /**
     * * @ORM\Column(type="string")
     */
    protected $provider_screen_name;

    /**
     * * @ORM\Column(type="string")
     */
    protected $provider_avatar;

    /**
     * * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * * @ORM\Column(type="datetime")
     */
    protected $updated_at;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($remember_token)
    {
        $this->remember_token = $remember_token;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function getProviderId()
    {
        return $this->provider_id;
    }

    public function setProviderId($provider_id)
    {
        $this->provider_id = $provider_id;
    }

    public function getProviderToken()
    {
        return $this->provider_token;
    }

    public function setProviderToken($provider_token)
    {
        $this->provider_token = $provider_token;
    }

    public function getProviderSecret()
    {
        return $this->provider_secret;
    }

    public function setProviderSecret($provider_secret)
    {
        $this->provider_secret = $provider_secret;
    }

    public function getProviderScreenName()
    {
        return $this->provider_screen_name;
    }

    public function setProviderScreenName($provider_screen_name)
    {
        $this->provider_screen_name = $provider_screen_name;
    }

    public function getProviderAvatar()
    {
        return $this->provider_avatar;
    }

    public function setProviderAvatar($provider_avatar)
    {
        $this->provider_avatar = $provider_avatar;
    }

    public function getDisplayName()
    {
        return $this->provider_screen_name ?? $this->name;
    }
}
