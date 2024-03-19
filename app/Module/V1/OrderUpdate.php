<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller as Apitte;
use Apitte\Core\Exception\Api\ServerErrorException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Api\Facade\OrdersFacade;
use App\Domain\Api\Request\UpdateOrderReqDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;
use App\Model\Utils\Caster;


/**
 * @Apitte\Path("/orders")
 * @Apitte\Tag("Orders")
 */
class OrderUpdateController extends BaseV1Controller
{

	private OrdersFacade $ordersFacade;

	public function __construct(OrdersFacade $ordersFacade)
	{
		$this->ordersFacade = $ordersFacade;
	}

	/**
	 * @Apitte\OpenApi("
	 *   summary: Update new order.
	 * ")
	 * @Apitte\Path("/update/{id}")
	 * @Apitte\Method("POST")
     *  @Apitte\RequestParameters({
	 *      @Apitte\RequestParameter(name="id", in="path", type="int", description="Order ID")
	 * })
	 * @Apitte\RequestBody(entity="App\Domain\Api\Request\UpdateOrderReqDto")
	 */
	public function update(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var UpdateOrderReqDto $dto */
		$dto = $request->getParsedBody();
        $id = Caster::toInt($request->getParameter('id'));

		try {
			$this->ordersFacade->update($id, $dto);

			return $response->withStatus(IResponse::S201_Created)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot update order')
				->withPrevious($e);
		}
	}

}
