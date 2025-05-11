<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttendeeRequest;
use App\Http\Resources\AttendeeResource;
use App\Services\AttendeeService;
use Illuminate\Http\JsonResponse;

class AttendeeController extends Controller
{
    /**
     * @var AttendeeService
     */
    protected $attendeeService;

    /**
     * AttendeeController constructor.
     *
     * @param AttendeeService $attendeeService
     */
    public function __construct(AttendeeService $attendeeService)
    {
        $this->attendeeService = $attendeeService;
    }

    /**
     * Store a newly created attendee in storage.
     *
     * @param StoreAttendeeRequest $request
     * @return JsonResponse
     */
    public function store(StoreAttendeeRequest $request): JsonResponse
    {
        $attendee = $this->attendeeService->createAttendee($request->validated());
        
        return (new AttendeeResource($attendee))
            ->response()
            ->setStatusCode(201);
    }
}