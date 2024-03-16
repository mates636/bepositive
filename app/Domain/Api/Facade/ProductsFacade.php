<?php declare(strict_types = 1);

namespace App\Domain\Api\Facade;

use App\Domain\Api\Request\CreateProductReqDto;
use App\Domain\Api\Request\UpdateProductReqDto;
use App\Domain\Api\Response\ProductResDto;
use App\Domain\Product\Product;
use App\Model\Database\EntityManagerDecorator;
use App\Model\Exception\Runtime\Database\EntityNotFoundException;
use App\Model\Security\Passwords;




final class ProductsFacade
{

	public function __construct(private EntityManagerDecorator $em)
	{
	}

	/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 * @return ProductResDto[]
	 */
	public function findBy(array $criteria = [], array $orderBy = ['id' => 'ASC'], int $limit = 10, int $offset = 0): array
	{
		$entities = $this->em->getRepository(Product::class)->findBy($criteria, $orderBy, $limit, $offset);
		$result = [];

		foreach ($entities as $entity) {
			$result[] = ProductResDto::from($entity);
		}

		return $result;
	}

	/**
	 * @return ProductResDto[]
	 */
	public function findAll(int $limit = 10, int $offset = 0): array
	{
		return $this->findBy([], ['id' => 'ASC'], $limit, $offset);
	}

		/**
	 * @param mixed[] $criteria
	 * @param string[] $orderBy
	 */
	public function findOneBy(array $criteria, ?array $orderBy = null): ProductResDto
	{
		$entity = $this->em->getRepository(Product::class)->findOneBy($criteria, $orderBy);

		if ($entity === null) {
			throw new EntityNotFoundException();
		}

		return ProductResDto::from($entity);
	}

	public function findOne(int $id): ProductResDto
	{
		return $this->findOneBy(['id' => $id]);
	}

	public function create(CreateProductReqDto $dto): Product
	{

		$product = (new Product())->setName($dto->name)
									->setValue($dto->value)
									->setStockDesign($dto->stockdesign);

		$this->em->persist($product);
		$this->em->flush($product);

		return $product;
	}

	public function update(int $id, UpdateProductReqDto $dto): Product
	{
		$product = new Product();

		$product = $this->em->getRepository(Product::class)->find($id);

		if ($product === null) {
			throw new EntityNotFoundException();
		}

		if($dto->name){
			$product->setName($dto->name);
		}
		if($dto->value){
			$product->setValue($dto->value);
		}
		if($dto->stockdesign){
			$product->setStockDesign($dto->stockdesign);
		}
		
		$this->em->flush($product);

		return $product;
	}

	public function delete(int $id): Product
	{

		$product = $this->em->getRepository(Product::class)->find($id);

		if ($product === null) {
			throw new EntityNotFoundException();
		}


		$this->em->remove($product);
		$this->em->flush($product);

		return $product;
	}
	
	
}
