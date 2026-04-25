<?php

namespace App\Handlers\Contact\Contracts;

use App\Commands\Contact\CreateContactCommand;
use App\Models\Contact;

interface CreateContactHandlerInterface
{
    public function handle(CreateContactCommand $command): Contact;
}
