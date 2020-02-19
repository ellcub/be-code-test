<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrganisationRequest;
use App\Organisation;
use App\Services\OrganisationService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * Class OrganisationController
 * @package App\Http\Controllers
 */
class OrganisationController extends ApiController
{
    /**
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

    public function listAll(OrganisationService $service)
    {
        $query = Organisation::query();

        if ($this->request->has('filter')) {
            switch ($this->request->input('filter')) {
                case 'subbed':
                    $query->where('subscribed', 1);
                    break;
                case 'trial':
                    // Assume that trial should on on midnight of the last trial day
                    // rather than at whatever time during the day it was created
                    $query->whereDate('trial_end', '>=', Carbon::today()->toDateString());
                    break;
            }
        }

        $organisations = $query->get();

        return json_encode($organisations);
    }
}
