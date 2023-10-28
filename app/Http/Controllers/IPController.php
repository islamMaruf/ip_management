<?php

namespace App\Http\Controllers;

use APIResponse;
use App\Interfaces\IPRepositoryInterface;
use App\Http\Requests\StoreIPRequest;
use App\Http\Requests\UpdateIPRequest;
use Exception;

class IPController extends Controller
{
    public $ipRepository;

    public function __construct(IPRepositoryInterface $ipRepositoryInterface)
    {
        $this->ipRepository = $ipRepositoryInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $ips = $this->ipRepository->all();
            return APIResponse::okResponse($ips, 'IPs fetched successfully');
        } catch (Exception $exception) {
            return APIResponse::errorResponse([], 'IPs can not be fetched');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIPRequest $request)
    {
        try {
            $ip = $this->ipRepository->create($request->validated());
            return APIResponse::createdResponse($ip, 'IP created successfully');
        } catch (Exception $exception) {
            return APIResponse::errorResponse([], 'IP can not be created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $ip = $this->ipRepository->find($id);
            return APIResponse::okResponse($ip, 'IP fetch successfully');
        } catch (Exception $exception) {
            return APIResponse::errorResponse([], 'IP can not be fetched');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIPRequest $request, int $id)
    {
        try {
            $ip = $this->ipRepository->update($id, $request->validated());
            return APIResponse::okResponse($ip, 'IP updated successfully');
        } catch (Exception $exception) {
            return APIResponse::errorResponse([], 'IP can not be updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->ipRepository->delete($id);
            return APIResponse::noContentResponse('IP deleted successfully');
        } catch (Exception $exception) {
            return APIResponse::errorResponse([], 'IP can not be deleted');
        }
    }
}
