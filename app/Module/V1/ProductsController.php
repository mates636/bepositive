<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller as Apitte;
use Apitte\Core\Http\ApiRequest;
use App\Domain\Api\Facade\ProductsFacade;
use App\Domain\Api\Response\ProductResDto;
use App\Model\Utils\Caster;

/**
 * @Apitte\Path("/products")
 * @Apitte\Tag("Products")
 */
class ProductsController extends BaseV1Controller
{

	private ProductsFacade $productsFacade;

	public function __construct(ProductsFacade $productsFacade)
	{
		$this->productsFacade = $productsFacade;
	}

	/**
	 * @Apitte\OpenApi("
	 *   summary: List products.
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
		return $this->productsFacade->findAll(
			Caster::toInt($request->getParameter('limit', 10)),
			Caster::toInt($request->getParameter('offset', 0))
		);
	}

}
