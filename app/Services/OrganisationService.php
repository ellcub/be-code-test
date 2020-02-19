<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\OrganisationCreated;
use App\Organisation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * Class OrganisationService
 * @package App\Services
 */
class OrganisationService
{
    /**
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

        Mail::to(auth()->user())->send(new OrganisationCreated($organisation));

        return $organisation;
    }
}
