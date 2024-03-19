<?php declare(strict_types = 1);

namespace App\Domain\Order;

use App\Model\Database\Entity\AbstractEntity;
use App\Model\Database\Entity\TCreatedAt;
use App\Model\Database\Entity\TId;
use App\Model\Database\Entity\TUpdatedAt;
use App\Model\Exception\Logic\InvalidArgumentException;
use App\Model\Utils\DateTime;
use Doctrine\ORM\Mapping as ORM;
use Nette\Utils\Random;

/**
 * @ORM\Entity(repositoryClass="OrderRepository")
 * @ORM\Table(name="`order`")
 * @ORM\HasLifecycleCallbacks
 */
class Order extends AbstractEntity
{

	use TId;
	use TCreatedAt;
	use TUpdatedAt;


	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $productid;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $customerid;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $orderstate;

	/** @ORM\Column(type="string", length=255, nullable=FALSE, unique=false) */
	private string $price;


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

	public function getCustomerId(): string
	{
		return $this->customerid;
	}

	public function setCustomerId($customerid) 
	{
        $this->customerid = $customerid;
        return $this;
    } 

	public function getProductId(): string
	{
		return $this->productid;
	}

	public function setProductId($productid) 
	{
        $this->productid = $productid;
        return $this;
    } 

	
	public function getOrderState(): string
	{
		return $this->orderstate;
	}

	public function setOrderState($orderstate) 
	{
        $this->orderstate = $orderstate;
        return $this;
    } 

	public function getPrice(): string
	{
		return $this->price;
	}

	public function setPrice($price) 
	{
        $this->price = $price;
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
