<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

require __DIR__ . '/../../../Magento/Sales/_files/default_rollback.php';
require __DIR__ . '/../../../Magento/Catalog/_files/product_simple.php';
/** @var \Magento\Catalog\Model\Product $product */

$addressData = include __DIR__ . '/../../../Magento/Sales/_files/address_data.php';

$objectManager = \Magento\TestFramework\Helper\Bootstrap::getObjectManager();

$billingAddress = $objectManager->create(\Magento\Sales\Model\Order\Address::class, ['data' => $addressData]);
$billingAddress->setAddressType('billing');

$shippingAddress = clone $billingAddress;
$shippingAddress->setId(null)->setAddressType('shipping');

$payment = $objectManager->create(\Magento\Sales\Model\Order\Payment::class);
$payment->setMethod('checkmo');

/** @var \Magento\Sales\Model\Order\Item $orderItem */
$orderItem = $objectManager->create(\Magento\Sales\Model\Order\Item::class);
$orderItem->setProductId($product->getId())->setQtyOrdered(2);
$orderItem->setBasePrice($product->getPrice());
$orderItem->setPrice($product->getPrice());
$orderItem->setRowTotal($product->getPrice());
$orderItem->setProductType('simple');

/** @var \Magento\Sales\Model\Order $order */
$order = $objectManager->create(\Magento\Sales\Model\Order::class);
$order->setIncrementId(
   '100000001'
)->setState(
   \Magento\Sales\Model\Order::STATE_PROCESSING
)->setStatus(
   $order->getConfig()->getStateDefaultStatus(\Magento\Sales\Model\Order::STATE_PROCESSING)
)->setSubtotal(
   100
)->setGrandTotal(
   100
)->setBaseSubtotal(
   100
)->setBaseGrandTotal(
   100
)->setCustomerIsGuest(
   true
)->setCustomerEmail(
   'customer@null.com'
)->setBillingAddress(
   $billingAddress
)->setShippingAddress(
   $shippingAddress
)->setStoreId(
   $objectManager->get(\Magento\Store\Model\StoreManagerInterface::class)->getStore()->getId()
)->addItem(
   $orderItem
)->setPayment(
   $payment
);

$giftCards = [
    [
        "i" => 1,
        "c" => 'TESTCODE1',
        "a" => 10,
        "ba" => 10,
    ],
    [
        "i" => 2,
        "c" => 'TESTCODE2',
        "a" => 15,
        "ba" => 15,
    ],
];

$objectManager->create(\Magento\GiftCardAccount\Helper\Data::class)
    ->setCards($order, $giftCards);

$order->setBaseGiftCardsAmount(20);
$order->setGiftCardsAmount(20);
$order->setBaseGiftCardsInvoiced(10);
$order->setGiftCardsInvoiced(10);
$order->setBaseGiftCardsRefunded(5);
$order->setGiftCardsRefunded(5);

$order->save();
