<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller as Apitte;
use Apitte\Core\Http\ApiRequest;
use App\Domain\Api\Facade\OrdersFacade;
use App\Domain\Api\Response\OrderResDto;
use App\Model\Utils\Caster;

/**
 * @Apitte\Path("/orders")
 * @Apitte\Tag("Orders")
 */
class OrdersController extends BaseV1Controller
{

	private OrdersFacade $ordersFacade;

	public function __construct(OrdersFacade $ordersFacade)
	{
		$this->ordersFacade = $ordersFacade;
	}

	/**
	 * @Apitte\OpenApi("
	 *   summary: List orders.
	 * ")
	 * @Apitte\Path("/")
	 * @Apitte\Method("GET")
	 * @Apitte\RequestParameters({
	 * 		@Apitte\RequestParameter(name="limit", type="int", in="query", required=false, description="Data limit"),
	 * 		@Apitte\RequestParameter(name="offset", type="int", in="query", required=false, description="Data offset")
	 * })
	 * @return UserResDto[]
	 */
	public function index(ApiRequest $request): array
	{
		return $this->ordersFacade->findAll(
			Caster::toInt($request->getParameter('limit', 10)),
			Caster::toInt($request->getParameter('offset', 0))
		);
	}

}
