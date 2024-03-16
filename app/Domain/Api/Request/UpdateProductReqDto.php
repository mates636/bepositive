<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateProductReqDto
{

	public string $name;

	public string $value;

	public string $stockdesign;

}
