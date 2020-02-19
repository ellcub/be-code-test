<?php

declare(strict_types=1);

namespace App\Mail;

use App\Organisation;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrganisationCreated extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Organisation
     */
    public $organisation;

    /**
     * @var User
     */
    public $user;


    /**
     * Create a new message instance.
     *
     * @param Organisation $organisation
     */
    public function __construct(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('New organisation created')
            ->text('emails.organisation-created');
    }
}
