<?php declare(strict_types = 1);

namespace App\Module\V1;

use Apitte\Core\Annotation\Controller as Apitte;
use Apitte\Core\Exception\Api\ServerErrorException;
use Apitte\Core\Http\ApiRequest;
use Apitte\Core\Http\ApiResponse;
use App\Domain\Api\Facade\ProductsFacade;
use App\Domain\Api\Request\UpdateProductReqDto;
use Doctrine\DBAL\Exception\DriverException;
use Nette\Http\IResponse;
use App\Model\Utils\Caster;


/**
 * @Apitte\Path("/products")
 * @Apitte\Tag("Products")
 */
class ProductUpdateController extends BaseV1Controller
{

	private ProductsFacade $productsFacade;

	public function __construct(ProductsFacade $productsFacade)
	{
		$this->productsFacade = $productsFacade;
	}

	/**
	 * @Apitte\OpenApi("
	 *   summary: Update new product.
	 * ")
	 * @Apitte\Path("/update/{id}")
	 * @Apitte\Method("POST")
     *  @Apitte\RequestParameters({
	 *      @Apitte\RequestParameter(name="id", in="path", type="int", description="Product ID")
	 * })
	 * @Apitte\RequestBody(entity="App\Domain\Api\Request\UpdateProductReqDto")
	 */
	public function update(ApiRequest $request, ApiResponse $response): ApiResponse
	{
		/** @var UpdateProductReqDto $dto */
		$dto = $request->getParsedBody();
        $id = Caster::toInt($request->getParameter('id'));

		try {
			$this->productsFacade->update($id, $dto);

			return $response->withStatus(IResponse::S201_Created)
				->withHeader('Content-Type', 'application/json');
		} catch (DriverException $e) {
			throw ServerErrorException::create()
				->withMessage('Cannot update product')
				->withPrevious($e);
		}
	}

}
