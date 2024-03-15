<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller as Apitte;
use Apitte\Core\Exception\Api\ServerErrorException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Api\Facade\CustomersFacade;
use App\Domain\Api\Request\CreateCustomerReqDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;

/**
 * @Apitte\Path("/customers")
 * @Apitte\Tag("Customers")
 */
class CustomerCreateController extends BaseV1Controller
{

	private CustomersFacade $customersFacade;

	public function __construct(CustomersFacade $customersFacade)
	{
		$this->customersFacade = $customersFacade;
	}

	/**
	 * @Apitte\OpenApi("
	 *   summary: Create new customer.
	 * ")
	 * @Apitte\Path("/create")
	 * @Apitte\Method("POST")
	 * @Apitte\RequestBody(entity="App\Domain\Api\Request\CreateCustomerReqDto")
	 */
	public function create(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var CreateCustomerReqDto $dto */
		$dto = $request->getParsedBody();

		try {
			$this->customersFacade->create($dto);

			return $response->withStatus(IResponse::S201_Created)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot create customer')
				->withPrevious($e);
		}
	}

}
