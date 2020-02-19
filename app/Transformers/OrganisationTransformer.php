<?php

declare(strict_types=1);

namespace App\Transformers;

use App\Organisation;
use Carbon\Carbon;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

/**
 * Class OrganisationTransformer
 * @package App\Transformers
 */
class OrganisationTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'user'
    ];

    /**
     * @param Organisation $organisation
     *
     * @return array
     */
    public function transform(Organisation $organisation): array
    {
        return [
            'id' => (int)$organisation->id,
            'name' => $organisation->name,
            'trail_end' => $organisation->trial_end != null ? Carbon::parse($organisation->trial_end)->timestamp : null,
            'subscribed' => (bool)$organisation->subscribed,
            'created_at' => $organisation->created_at != null ? Carbon::parse(
                $organisation->created_at
            )->timestamp : null,
            'updated_at' => $organisation->created_at != null ? Carbon::parse(
                $organisation->created_at
            )->timestamp : null
        ];
    }

    /**
     * @param Organisation $organisation
     *
     * @return Item
     */
    public function includeUser(Organisation $organisation)
    {
        return $this->item($organisation->owner, new UserTransformer());
    }
}
