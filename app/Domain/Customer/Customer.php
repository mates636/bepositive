<?php declare(strict_types = 1);

namespace App\Domain\Customer;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Random;

/**
 * @ORM\Entity(repositoryClass="CustomerRepository")
 * @ORM\Table(name="`customer`")
 * @ORM\HasLifecycleCallbacks
 */
class Customer extends AbstractEntity
{

	use TId;
	use TCreatedAt;
	use TUpdatedAt;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $firstname;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $lastname;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=TRUE) */
	private string $email;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=TRUE) */
	private string $telephone;

	/**
	 * @var DateTime|NULL
	 * @ORM\Column(type="datetime", nullable=TRUE)
	 */
	private ?DateTime $lastLoggedAt = null;

	public function __construct()
	{

	}

	public function changeLoggedAt(): void
	{
		$this->lastLoggedAt = new DateTime();
	}

	
	public function getFirstName(): string
	{
		return $this->firstname;
	}

	public function setFirstName($firstname) 
	{
        $this->firstname = $firstname;
        return $this;
    } 

	public function getLastName(): string
	{
		return $this->lastname;
	}

	public function setLastName($lastname) 
	{
        $this->lastname = $lastname;
        return $this;
    }

	public function getEmail(): string
	{
		return $this->email;
	}

	public function setEmail($email) 
	{
        $this->email = $email;
        return $this;
    }

	public function getTelephone(): string
	{
		return $this->telephone;
	}

	public function setTelephone($telephone) 
	{
        $this->telephone = $telephone;
        return $this;
    }

	public function setId(int $id): void
	{
	    $this->id = $id;
	}

	public function getLastLoggedAt(): ?DateTime
	{
		return $this->lastLoggedAt;
	}

}
