<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreateOrderReqDto;
use App\Domain\Api\Request\UpdateOrderReqDto;
use App\Domain\Api\Response\OrderResDto;
use App\Domain\Order\Order;
use App\Domain\Customer\Customer;
use App\Domain\Product\Product;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;




final class OrdersFacade
{

	
	public function __construct(private EntityManagerDecorator $em)
	{
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 * @return OrderResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getRepository(Order::class)->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = OrderResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return OrderResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

		/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null): OrderResDto
	{
		$entity = $this->em->getRepository(Order::class)->findOneBy($criteria, $orderBy);

		if ($entity === null) {
			throw new EntityNotFoundException();
		}

		return OrderResDto::from($entity);
	}

	public function findOne(int $id): OrderResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreateOrderReqDto $dto): Order
	{


	$customer = $this->em->getRepository(Customer::class)->find($dto->customerid);

	if (!$customer) {
		throw new \Exception('Customer with ID ' . $dto->customerid . ' not found.');
	}
		

	 $product = $this->em->getRepository(Product::class)->find($dto->productid);

	 if (!$product) {
		 throw new \Exception('Product with ID ' . $dto->productid . ' not found.');
	 }


		$order = (new Order())->setProductId($dto->productid)
								->setCustomerId($dto->customerid)
								->setOrderState($dto->orderstate)
								->setPrice($dto->price);

		$this->em->persist($order);
		$this->em->flush($order);

		return $order;
	}

	public function update(int $id, UpdateOrderReqDto $dto): Order
	{
		$order = new Order();

		$order = $this->em->getRepository(Order::class)->find($id);

		// if ($order === null) {
		// 	throw new EntityNotFoundException();
		// }

		// $customer = $this->em->getRepository(Customer::class)->find($dto->customerid);

		// if (!$customer) {
		// 	throw new \Exception('Customer with ID ' . $dto->customerid . ' not found.');
		// }
			
	
		//  $product = $this->em->getRepository(Product::class)->find($dto->productid);
	
		//  if (!$product) {
		// 	 throw new \Exception('Product with ID ' . $dto->productid . ' not found.');
		//  }

		if($dto->orderstate){
			$order->setOrderState($dto->orderstate);
		}
		if($dto->price){
			$order->setPrice($dto->price);
		}
		
		$this->em->flush($order);

		return $order;
	}

	public function delete(int $id): Order
	{

		$order = $this->em->getRepository(Order::class)->find($id);

		if ($order === null) {
			throw new EntityNotFoundException();
		}

		$this->em->remove($order);
		$this->em->flush($order);

		return $order;
	}
	
	
}
