<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin || $user->isSeller;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        return $user->isAdmin
            || ($user->isBuyer && optional($user->buyer)->id == $order->buyer_id)
            || ($user->isSeller && optional($user->seller)->id == $order->seller_id);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        return $user->isBuyer && optional($user->buyer)->id == $order->buyer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Order  $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        //
    }

    /**
     * Accept Payment by Seller
     *
     * @param User $user
     * @param Order $order
     */
    public function acceptPayment(User $user, Order $order){
        return $user->isSeller && optional($user->seller)->id == $order->seller_id && $order->status_code == Order::PAYMENT_IN_PROCESS;
    }

    /**
     * Deny Payment by Seller
     *
     * @param User $user
     * @param Order $order
     */
    public function denyPayment(User $user, Order $order){
        return $user->isSeller && optional($user->seller)->id == $order->seller_id && $order->status_code == Order::PAYMENT_IN_PROCESS;
    }

    /**
     * Set Status to In Delivery
     *
     * @param User $user
     * @param Order $order
     */
    public function deliver(User $user, Order $order){
        return $user->isSeller && optional($user->seller)->id == $order->seller_id && $order->status_code == Order::ORDER_BEING_PROCESSED;
    }

    /**
     * Delivery Complete
     *
     * @param User $user
     * @param Order $order
     */
    public function deliveryComplete(User $user, Order $order){
        return (
                ($user->isSeller && optional($user->seller)->id == $order->seller_id)
                || ($user->isBuyer && optional($user->buyer)->id == $order->buyer_id)
            )
            && $order->status_code == Order::IN_DELIVERY;
    }

    /**
     * Cancel by buyer
     *
     * @param User $user
     * @param Order $order
     */
    public function cancel(User $user, Order $order){
        return (
                ($user->isSeller && optional($user->seller)->id == $order->seller_id)
                || ($user->isBuyer && optional($user->buyer)->id == $order->buyer_id)
            )
            && ($order->status_code == Order::PAYMENT_PENDING);
    }

    /**
     * Request refund by buyer or seller
     *
     * @param User $user
     * @param Order $order
     */
    public function requestRefund(User $user, Order $order){
        return (
                ($user->isSeller && optional($user->seller)->id == $order->seller_id)
                || ($user->isBuyer && optional($user->buyer)->id == $order->buyer_id)
            )
            && ($order->status_code == Order::PAYMENT_IN_PROCESS);
    }

    /**
     * Process refund by buyer or seller
     *
     * @param User $user
     * @param Order $order
     */
    public function refund(User $user, Order $order){
        return ($user->isSeller && optional($user->seller)->id == $order->seller_id)&& $order->status_code == Order::REQUEST_REFUND;
    }

    /**
     * Refund complete by seller or user
     *
     * @param User $user
     * @param Order $order
     */
    public function refundComplete(User $user, Order $order){
        return (
                ($user->isSeller && optional($user->seller)->id == $order->seller_id)
                || ($user->isBuyer && optional($user->buyer)->id == $order->buyer_id)
            )
            && $order->status_code == Order::REFUND_BEING_PROCESSED;
    }
}
