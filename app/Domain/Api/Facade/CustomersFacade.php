<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreateCustomerReqDto;
use App\Domain\Api\Response\CustomerResDto;
use App\Domain\Customer\Customer;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;



final class CustomersFacade
{

	public function __construct(private EntityManagerDecorator $em)
	{
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 * @return CustomerResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getRepository(Customer::class)->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = CustomerResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return CustomerResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

		/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null): CustomerResDto
	{
		$entity = $this->em->getRepository(Customer::class)->findOneBy($criteria, $orderBy);

		if ($entity === null) {
			throw new EntityNotFoundException();
		}

		return CustomerResDto::from($entity);
	}

	public function findOne(int $id): CustomerResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreateCustomerReqDto $dto): Customer
	{
		$customer = new Customer(
			$dto->firstname,
			$dto->lastname,
			$dto->email,
			$dto->telephone
		);

		$this->em->persist($customer);
		$this->em->flush($customer);

		return $customer;
	}

}