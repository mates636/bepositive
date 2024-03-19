<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateOrderReqDto
{

	/** @Assert\NotBlank */
	public string $productid;

	/** @Assert\NotBlank */
	public string $customerid;

	/** @Assert\NotBlank */
	public string $orderstate;

	/** @Assert\NotBlank */
	public string $price;


}
