<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller as Apitte;
use Apitte\Core\Exception\Api\ServerErrorException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Api\Facade\OrdersFacade;
use App\Domain\Api\Request\CreateOrderReqDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;

/**
 * @Apitte\Path("/orders")
 * @Apitte\Tag("Orders")
 */
class OrderCreateController extends BaseV1Controller
{

	private OrdersFacade $ordersFacade;

	public function __construct(OrdersFacade $ordersFacade)
	{
		$this->ordersFacade = $ordersFacade;
	}

	/**
	 * @Apitte\OpenApi("
	 *   summary: Create new order.
	 * ")
	 * @Apitte\Path("/create")
	 * @Apitte\Method("POST")
	 * @Apitte\RequestBody(entity="App\Domain\Api\Request\CreateOrderReqDto")
	 */
	public function create(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var CreateOrderReqDto $dto */
		$dto = $request->getParsedBody();

		try {
			$this->ordersFacade->create($dto);

			return $response->withStatus(IResponse::S201_Created)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot create order')
				->withPrevious($e);
		}
	}

}
