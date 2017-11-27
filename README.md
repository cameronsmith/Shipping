# Shipping
A project showing shipping and dispatch examples.

## Usage

#### Consignment

This package is to be used with the `Consignment` interface. An example interface and 
stubbed object have been provided in `UKCASmith\Shipping\Contracts\Consignment`. However, 
in production any references would be replaced with the real thing.

This object will contain the full customer's address and etc, but in this case we only have 
two public methods: `setCourierType` and `getCourierType`

```
$order1 = (new ConsignmentOrder)->setCourierType(CourierFactory::ROYAL_MAIL);
$order2 = (new ConsignmentOrder)->setCourierType(CourierFactory::ANC);
```

#### Order Dispatching

You should make sure that no dispatch is currently open by performing the `getBatchStatus` 
call otherwise an exception could be thrown.

```
$orderDispatch = new OrderDispatch;

if (!$orderDispatch->getBatchStatus()) {
    $orderDispatch->open();
}
```

Adding a consignment to an order dispatch can be performed by doing the following, which 
will return the consignment number for the order:

```
$order1ConsignmentNumber = $this->orderDispatch->addConsignment($order1);
```

Once all your consignments have been added you can close the dispatch and close all 
couriers:

```
if ($orderDispatch->getBatchStatus()) {
    $orderDispatch->close();
}
```

#### Full Example:

```
$order1 = (new ConsignmentOrder)->setCourierType(CourierFactory::ROYAL_MAIL);
$order2 = (new ConsignmentOrder)->setCourierType(CourierFactory::ANC);

$orderDispatch = new OrderDispatch;

if (!$orderDispatch->getBatchStatus()) {
    $orderDispatch->open();
}

$order1ConsignmentNumber = $this->orderDispatch->addConsignment($order1);
$order1ConsignmentNumber = $this->orderDispatch->addConsignment($order2);

if ($orderDispatch->getBatchStatus()) {
    $orderDispatch->close();
}

```

## Testing

For testing or a full working example of how this package works you can perform:

```
./vendor/bin/phpunit
```