<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller as Apitte;
use Apitte\Core\Exception\Api\ServerErrorException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Api\Facade\CustomersFacade;
use App\Domain\Api\Request\UpdateCustomerReqDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;
use App\Model\Utils\Caster;


/**
 * @Apitte\Path("/customers")
 * @Apitte\Tag("Customers")
 */
class CustomerUpdateController extends BaseV1Controller
{

	private CustomersFacade $customersFacade;

	public function __construct(CustomersFacade $customersFacade)
	{
		$this->customersFacade = $customersFacade;
	}

	/**
	 * @Apitte\OpenApi("
	 *   summary: Update new customer.
	 * ")
	 * @Apitte\Path("/update/{id}")
	 * @Apitte\Method("POST")
     *  @Apitte\RequestParameters({
	 *      @Apitte\RequestParameter(name="id", in="path", type="int", description="Customer ID")
	 * })
	 * @Apitte\RequestBody(entity="App\Domain\Api\Request\UpdateCustomerReqDto")
	 */
	public function update(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var UpdateCustomerReqDto $dto */
		$dto = $request->getParsedBody();
        $id = Caster::toInt($request->getParameter('id'));

		try {
			$this->customersFacade->update($id, $dto);

			return $response->withStatus(IResponse::S201_Created)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot update customer')
				->withPrevious($e);
		}
	}

}
