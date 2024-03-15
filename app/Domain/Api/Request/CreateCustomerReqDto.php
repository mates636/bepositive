<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateCustomerReqDto
{

	/**
	 * @Assert\NotBlank
	 * @Assert\Email
	 */
	public string $email;

	/** @Assert\NotBlank */
	public string $firstname;

	/** @Assert\NotBlank */
	public string $lastname;

	/** @Assert\NotBlank */
	public string $telephone;

	// public ?string $password = null;

}
