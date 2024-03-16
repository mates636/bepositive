<?php declare(strict_types = 1);

namespace App\Domain\Product;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Random;

/**
 * @ORM\Entity(repositoryClass="ProductRepository")
 * @ORM\Table(name="`product`")
 * @ORM\HasLifecycleCallbacks
 */
class Product extends AbstractEntity
{

	use TId;
	use TCreatedAt;
	use TUpdatedAt;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $name;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $value;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=TRUE) */
	private string $stockdesign;


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

	
	public function getName(): string
	{
		return $this->name;
	}

	public function setName($name) 
	{
        $this->name = $name;
        return $this;
    } 

	public function getValue(): string
	{
		return $this->value;
	}

	public function setValue($value) 
	{
        $this->value = $value;
        return $this;
    }

	public function getStockDesign(): string
	{
		return $this->stockdesign;
	}

	public function setStockDesign($stockdesign) 
	{
        $this->stockdesign = $stockdesign;
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
