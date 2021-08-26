<?php


namespace App\State\ContextStates;


class StatesFactory
{
    public static function create($shippingStatusCode)
    {
        switch ($shippingStatusCode) {
            case $shippingStatusCode == 'REJECTED_PAYMENT':
                return new RejectedPaymentState();
            case $shippingStatusCode == 'PENDING_PAYMENT':
                return new PendingPaymentShippingState();
            case $shippingStatusCode == 'PRODUCT_ORDER_CONFIRMED':
                return new CreatedShippingState();
            case $shippingStatusCode == 'PACKED':
                return new PackedShippingState();
            case $shippingStatusCode == 'ASSIGNED':
                return new AssignedShippingState();
            case $shippingStatusCode == 'IN_COLLECTION':
                return new InCollectionShippingState();
            case $shippingStatusCode == 'COLLECTED':
                return new CollectedShippingState();
            case $shippingStatusCode == 'ON_ROAD':
                return new OnRoadShippingState();
            case $shippingStatusCode == 'AVAILABLE_IN_NODE':
                return new AvailableNodeShippingState();
            case $shippingStatusCode == 'DELIVERED_TO_CUSTOMER':
                return new DeliveredToCustomerShippingState();
            case $shippingStatusCode == 'QUALIFIED':
                return new QualifiedShippingState();
            case $shippingStatusCode == 'CLOSED':
                return new ClosedShippingState();
            case $shippingStatusCode == 'NOT_WITHDRAWN_BY_CUSTOMER':
                return new NotWithdrawnByCustomerState();
            case $shippingStatusCode == 'WITHDRAWN_BY_CUSTOMER':
                return new WithdrawnByCustomerState();
            case $shippingStatusCode == 'ACCEPTED':
                return new AcceptedShippingState();
            case $shippingStatusCode == 'NOT_DELIVERED':
                return new NotDeliveredShippingState();
            case $shippingStatusCode == 'RETURNED_TO_NODE':
                return new ReturnedToNode();
            default:
                return false;
        }
    }
}
