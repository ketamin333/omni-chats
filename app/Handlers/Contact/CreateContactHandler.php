<?php

namespace App\Handlers\Contact;

use App\Commands\Contact\CreateContactCommand;
use App\Events\ContactCreated;
use App\Handlers\Contact\Contracts\CreateContactHandlerInterface;
use App\Models\Contact;
use Illuminate\Contracts\Events\Dispatcher;

class CreateContactHandler implements CreateContactHandlerInterface
{
    public function __construct(
        protected Dispatcher $dispatcher,
    ) {}

    /**
     * Execute the CreateContact action.
     */
    public function handle(CreateContactCommand $command): Contact
    {
        $contact = Contact::create([
            'company_id' => $command->companyId,
            'username'   => $command->username,
            'phone'      => $command->phone,
            'email'      => $command->email,
        ]);

        $this->dispatcher->dispatch(new ContactCreated($contact));

        return $contact;
    }
}
