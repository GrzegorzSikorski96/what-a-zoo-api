<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Requests\IdRequest;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ReportController
 * @package App\Http\Controllers
 */
class ReportController extends Controller
{
    /**
     * @var ReportService
     */
    protected $reportService;

    /**
     * ReviewController constructor.
     * @param ApiResponse $apiResponse
     * @param ReportService $reportService
     */
    public function __construct(ApiResponse $apiResponse, ReportService $reportService)
    {
        parent::__construct($apiResponse);
        $this->reportService = $reportService;
    }

    public function report(int $id): JsonResponse
    {
        $report = $this->reportService->report($id);

        return $this->apiResponse
            ->setData([
                'report' => $report,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    public function reports(): JsonResponse
    {
        $reports = $this->reportService->reports();

        return $this->apiResponse
            ->setData([
                'reports' => $reports,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    /**
     * @param IdRequest $request
     * @return JsonResponse
     */
    public function create(IdRequest $request): JsonResponse
    {
        $report = $this->reportService->create($request->all()['id']);

        return $this->apiResponse
            ->setData([
                'report' => $report,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }

    public function resolve(Request $request): JsonResponse
    {
        $report = $this->reportService->resolve($request->all()['id'], $request->all()['action_id']);

        return $this->apiResponse
            ->setData([
                'report' => $report,
            ])
            ->setSuccessStatus()
            ->getResponse();
    }
}
