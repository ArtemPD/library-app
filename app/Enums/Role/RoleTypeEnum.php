<?php

namespace App\Enums\Role;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum RoleTypeEnum: string
{
    use Values, Names, InvokableCases;

    case PUBLISHER = 'publisher';

}
