Hi {{ $organisation->owner->name }},

Your new organisation {{ $organisation->name }} was created successfully.

Your trial ends on {{ $organisation->trial_end->format('d M Y') }}.
