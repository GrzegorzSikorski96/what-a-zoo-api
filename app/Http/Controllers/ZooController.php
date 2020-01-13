<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\IdRequest;
use App\Http\Requests\Zoo;
use App\Services\ZooService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ZooController
 * @package App\Http\Controllers
 */
class ZooController extends Controller
{
    /**
     * @var ZooService
     */
    protected $zooService;

    /**
     * ZooController constructor.
     * @param ApiResponse $apiResponse
     * @param ZooService $zooService
     */
    public function __construct(ApiResponse $apiResponse, ZooService $zooService)
    {
        parent::__construct($apiResponse);
        $this->zooService = $zooService;
    }

    /**
     * @return JsonResponse
     */
    public function zoos(): JsonResponse
    {
        $zoos = $this->zooService->zoos();

        return $this->apiResponse
            ->setData([
                'zoos' => $zoos,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param int $zooId
     * @return JsonResponse
     */
    public function zooWithReviews(int $zooId): JsonResponse
    {
        $data = $this->zooService->zooWithReviews($zooId);

        return $this->apiResponse
            ->setData($data)
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Zoo $zooRequest
     * @return JsonResponse
     */
    public function create(Zoo $zooRequest): JsonResponse
    {
        $zoo = $this->zooService->create($zooRequest->all());

        return $this->apiResponse
            ->setData([
                'zoo' => $zoo
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param IdRequest $id
     * @return JsonResponse
     * @throws Exception
     */
    public function remove(IdRequest $id): JsonResponse
    {
        $this->zooService->remove($id->all()['id']);

        return $this->apiResponse
            ->setMessage(__('messages.remove.success'))
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @return JsonResponse
     */
    public function visited(): JsonResponse
    {
        $visited = $this->zooService->visited();

        return $this->apiResponse
            ->setMessage(__('messages.remove.success'))
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function visit(Request $request): JsonResponse
    {
        $this->zooService->visit($request->all()['zoo_id']);

        return $this->apiResponse
            ->setMessage(__('messages.visited.success'))
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function unVisit(Request $request): JsonResponse
    {
        $this->zooService->unVisit($request->all()['zoo_id']);

        return $this->apiResponse
            ->setMessage(__('messages.unVisited.success'))
            ->setSuccessStatus()
            ->getResponse();
    }
}
