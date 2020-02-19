<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\OrganisationCreated;
use App\Organisation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
     * Create a new organisation and send an email notification
     *
     * @param array $attributes
     *
     * @return Organisation
     */
    public function createOrganisation(array $attributes): Organisation
    {
        $organisation = new Organisation();
        $organisation->name = $attributes['name'];
        $organisation->owner_user_id = auth()->user()->id;
        $organisation->trial_end = Carbon::now()->addDays(30);
        $organisation->save();

        // May be better to put in a queue rather than send from here
        Mail::to(auth()->user())->send(new OrganisationCreated($organisation));

        return $organisation;
    }

    /**
     * Get a collection of organisations optionally filtered
     *
     * Filter is defined in the http query parameter.  Can bee 'subbed', 'trial', 'all' or not provided.
     * The default is 'all'.
     *
     * @param Request $request
     * @return Collection
     */
    public function listOrganisations(Request $request): Collection
    {
        $query = Organisation::query();

        if ($request->has('filter')) {
            switch ($request->input('filter')) {
                case 'subbed':
                    $query->where('subscribed', 1);
                    break;
                case 'trial':
                    // Assume that trial should end on midnight of the last trial day
                    // rather than at whatever time during the day it was created
                    $query->whereDate('trial_end', '>=', Carbon::today()->toDateString());
                    break;
            }
        }
        return $query->get();
    }
}
