<?php declare(strict_types = 1);

namespace App\Domain\Api\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class DeleteCustomerReqDto
{

	/**
	 * @Assert\Email
	 */
	public string $email;

	public string $firstname;

	public string $lastname;

	public string $telephone;


}
