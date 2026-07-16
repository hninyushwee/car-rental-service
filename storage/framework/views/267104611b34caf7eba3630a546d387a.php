Booking Confirmed - Invoice #<?php echo e($booking->booking_number); ?>


Booking Details:
  Number: #<?php echo e($booking->booking_number); ?>

  Status: <?php echo e(ucfirst($booking->status)); ?>

  Date: <?php echo e($booking->created_at->format('M d, Y')); ?>


Customer:
  Name: <?php echo e($booking->user->name); ?>

  Email: <?php echo e($booking->user->email); ?>

<?php if($booking->user->phone): ?>
  Phone: <?php echo e($booking->user->phone); ?>

<?php endif; ?>

Booking Items:
<?php $__currentLoopData = $booking->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$vehicleName = $item->vehicle ? trim(($item->vehicle->brand->name ?? '') . ' ' . $item->vehicle->model) : 'N/A';
$days = $item->start_date && $item->end_date ? max(1, \Carbon\Carbon::parse($item->start_date)->diffInDays(\Carbon\Carbon::parse($item->end_date)) + 1) : 1;
$itemTotal = $days * $item->vehicle_daily_rate * ($item->quantity ?? 1);
if ($item->has_driver && $item->driver_daily_rate) {
$itemTotal += $days * $item->driver_daily_rate * ($item->quantity ?? 1);
}
?>
  <?php echo e($vehicleName); ?> | <?php echo e($item->start_date ? \Carbon\Carbon::parse($item->start_date)->format('M d') : '-'); ?> - <?php echo e($item->end_date ? \Carbon\Carbon::parse($item->end_date)->format('M d') : '-'); ?> | Driver: <?php echo e($item->has_driver ? ($item->driver->name ?? 'Auto-assigned') : 'No'); ?> | Qty: <?php echo e($item->quantity ?? 1); ?> | MMK <?php echo e(number_format($itemTotal, 2)); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

  Subtotal: MMK <?php echo e(number_format($booking->subtotal_price, 2)); ?>

<?php if((float) $booking->discount_amount > 0): ?>
  Discount: -MMK <?php echo e(number_format($booking->discount_amount, 2)); ?>

<?php endif; ?>
  Total: MMK <?php echo e(number_format($booking->total_price, 2)); ?>

<?php $totalPaid = $booking->payments->sum('amount'); $remaining = max(0, $booking->total_price - $totalPaid); ?>
  Total Paid: MMK <?php echo e(number_format($totalPaid, 2)); ?>

  Remaining Balance: MMK <?php echo e(number_format($remaining, 2)); ?>


<?php if($booking->car_deposit_snapshot || $booking->driver_deposit_snapshot): ?>
Deposit Info:
<?php if($booking->car_deposit_snapshot): ?>
  Car Rental Deposit: MMK <?php echo e(number_format($booking->car_deposit_snapshot, 2)); ?>

<?php endif; ?>
<?php if($booking->driver_deposit_snapshot): ?>
  Driver Service Deposit: MMK <?php echo e(number_format($booking->driver_deposit_snapshot, 2)); ?>

<?php endif; ?>
<?php endif; ?>

Thank you for choosing our service. Your booking has been confirmed and is now being processed.

&copy; <?php echo e(date('Y')); ?> SkyLine Car Rental. All rights reserved.
To unsubscribe, visit <?php echo e(config('app.url')); ?>/contact<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/emails/booking-invoice-plain.blade.php ENDPATH**/ ?>