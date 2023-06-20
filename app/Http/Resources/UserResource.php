<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray(Request $request): array
    {
        $subscription = $this->subscriptions()->orderByDesc('id')->first();
        return [
            'id' => $this->id,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'subscription' => [
                'exists' => (bool) $subscription,
                'status' => $subscription?->stripe_status,
                'quantity' => $subscription?->quantity,
                'created_at' => $subscription?->created_at,
                'trial_ends_at' => $subscription?->trial_ends_at,
                'ends_at' => $subscription?->ends_at,
            ]
//            'notifications_count' => $this->notifications_count,
//            'tokens_count' => $this->tokens_count,
//            'permissions_count' => $this->permissions_count,
//            'read_notifications_count' => $this->read_notifications_count,
//            'roles_count' => $this->roles_count,
//            'unread_notifications_count' => $this->unread_notifications_count,
        ];
    }

}
