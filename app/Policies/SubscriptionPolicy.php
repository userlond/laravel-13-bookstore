<?php

namespace App\Policies;

use App\Enums\UserType;
use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {}

    public function index(User $user): bool
    {
        return $this->canSubscribe($user);
    }

    public function store(User $user): bool
    {
        return $this->canSubscribe($user);
    }

    public function destroy(User $user, Subscription $subscription): bool
    {
        return $this->canSubscribe($user);
    }

    private function canSubscribe(User $user): bool
    {
        return $user->role == UserType::CUSTOMER->value;
    }
}
