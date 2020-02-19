<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrganisationRequest;
use App\Organisation;
use App\Services\OrganisationService;
use Illuminate\Http\JsonResponse;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
     * Endpoint to create a new organisation
     *
     * @param OrganisationService $service
     *
     * @param CreateOrganisationRequest $request
     * @return JsonResponse
     */
    public function store(OrganisationService $service, CreateOrganisationRequest $request): JsonResponse
    {
        /** @var Organisation $organisation */
        $organisation = $service->createOrganisation($request->all());

        return $this
            ->transformItem('organisation', $organisation, ['user'])
            ->respond();
    }

    /**
     * Endpoint to list organisations
     *
     * @param OrganisationService $service
     * @return JsonResponse
     */
    public function listAll(OrganisationService $service)
    {
        /** @var Organisation $organisation */
        $organisations = $service->listOrganisations($this->request);

        return $this
            ->transformCollection('organisations', $organisations, ['user'])
            ->respond();
    }
}
