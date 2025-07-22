<?php

namespace App\Enums\Admin;

enum ReviewApprovedStatus: string
{
    case APPROVED = 'approved';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}
