<?php

namespace App\Http\Controllers;

use App\Http\Requests\CertificateStoreRequest;
use App\Http\Resources\CertificateResource;
use App\Repositories\Certificate\CertificateRepositoryInterface;
use Exception;
// use Illuminate\Http\Client\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CertificateController extends Controller
{

    protected $certificateRepository;

    public function __construct(CertificateRepositoryInterface $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return CertificateResource::collection($this->certificateRepository->all());
        // return new CertificateResource($this->certificateRepository->all());
        // return $this->certificateRepository->all();

        $certificate = $this->certificateRepository->all();

        if (!$certificate) {
            return response()->json([
                'error' => 'No certificates available.'
            ], 404);
        }

        return CertificateResource::collection($certificate);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CertificateStoreRequest $request): CertificateResource
    {
        $certificate = $request->validated();

        return new CertificateResource($this->certificateRepository->create($certificate));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): CertificateResource
    {
        return new CertificateResource($this->certificateRepository->show($id));
    }

    public function verify(Request $request)
    {
        // return response()->json([
        //     'response' => $request->code
        // ], 200);

        // $code = urldecode($request->code);
        $certificate = $this->certificateRepository->findByCode($request->code);
        // Log::info('certificate query:', ['code' => $code]);

        if (!$certificate) {
            return response()->json([
                'error' => 'not found'
            ], 404);
        }
        // return new CertificateResource($this->certificateRepository->findByCode($request->code));
        return response()->json([
            'data' => $certificate
        ], 200);
        // try {
        //     return new CertificateResource($this->certificateRepository->findByCode($request->code));
        // } catch (Exception $e) {
        //     //throw $th;
        //     return response()->json([
        //         'error' => 'GAADA'
        //     ], 404);
        // }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
