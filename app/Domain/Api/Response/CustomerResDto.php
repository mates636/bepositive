<?php declare(strict_types = 1);

namespace App\Domain\Api\Response;

use App\Domain\Customer\Customer;
use DateTimeInterface;

final class CustomerResDto
{

	public int $id;

	public string $firstname;

	public string $lastname;

	public string $email;

	public string $telephone;

	public ?DateTimeInterface $lastLoggedAt = null;

	public static function from(Customer $customer): self
	{
		$self = new self();
		$self->id = $customer->getId();
		$self->firstname = $customer->getFirstname();
		$self->lastname = $customer->getLastname();
		$self->email = $customer->getEmail();
		$self->telephone = $customer->getTelephone();
		$self->lastLoggedAt = $customer->getLastLoggedAt();

		return $self;
	}

}
