<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking: <?= htmlspecialchars($booking->booking_ref) ?> | Print View</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 20px;
        }
        
        .print-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* Header */
        .print-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #198754;
            margin-bottom: 30px;
        }
        
        .print-header h1 {
            font-size: 28pt;
            color: #198754;
            margin-bottom: 5px;
        }
        
        .print-header .tagline {
            font-size: 12pt;
            color: #666;
        }
        
        .print-header .booking-ref {
             margin-top: 15px;
             font-size: 14pt;
             color: #0d6efd;
             font-weight: bold;
         }
         
         /* Summary Row */
         .summary-row {
             display: grid;
             grid-template-columns: repeat(3, 1fr);
             gap: 15px;
             margin-bottom: 25px;
             padding: 15px;
             background: #f8f9fa;
             border-radius: 8px;
         }
         
         .summary-col {
             display: flex;
             flex-direction: column;
         }
         
         .summary-item {
             display: flex;
             flex-direction: column;
         }
         
         .summary-label {
             font-size: 10pt;
             color: #666;
             text-transform: uppercase;
             letter-spacing: 0.5px;
             margin-bottom: 3px;
             font-weight: 600;
         }
         
         .summary-value {
             font-size: 12pt;
             font-weight: 600;
             color: #333;
         }
         
         /* Section */
         .section {
             margin-bottom: 25px;
             page-break-inside: avoid;
         }
        
        .section-title {
            font-size: 14pt;
            font-weight: bold;
            color: #198754;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        
        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 12px;
        }
        
        .info-box {
            background: #f8f9fa;
            padding: 12px 15px;
            border-radius: 6px;
            border-left: 3px solid #198754;
        }
        
        .info-box h3 {
            font-size: 11pt;
            color: #666;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-box p {
            font-size: 12pt;
            font-weight: 600;
            color: #333;
        }
        
        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .data-table th,
        .data-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        
        .data-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #555;
            width: 40%;
        }
        
        .data-table td {
            font-weight: 500;
        }
        
        /* Pricing Table */
        .pricing-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .pricing-table th,
        .pricing-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .pricing-table th {
            text-align: left;
            background: #f8f9fa;
            font-weight: 600;
        }
        
        .pricing-table td:last-child {
            text-align: right;
            font-weight: 600;
        }
        
        .pricing-table tfoot tr {
            background: #198754;
            color: white;
        }
        
        .pricing-table tfoot th,
        .pricing-table tfoot td {
            font-size: 14pt;
            padding: 15px;
            border: none;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 11pt;
        }
        
        .status-pending { background: #ffc107; color: #000; }
        .status-confirmed { background: #17a2b8; color: #fff; }
        .status-deposit_paid { background: #0d6efd; color: #fff; }
        .status-paid { background: #0d6efd; color: #fff; }
        .status-completed { background: #198754; color: #fff; }
        .status-cancelled { background: #dc3545; color: #fff; }
        
        /* Special Requests */
        .special-requests {
            background: #fff3cd;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #ffc107;
        }
        
        /* Footer */
        .print-footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            text-align: center;
            color: #666;
            font-size: 10pt;
        }
        
        .print-footer .company-name {
            font-size: 12pt;
            font-weight: bold;
            color: #198754;
            margin-bottom: 5px;
        }
        
        /* Print-specific styles */
        @media print {
            body {
                padding: 0;
                font-size: 10pt;
            }
            
            .no-print {
                display: none !important;
            }
            
            .print-container {
                max-width: 100%;
            }
            
            .section {
                page-break-inside: avoid;
            }
            
            .summary-row {
                background: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                border: 1px solid #ddd;
            }
            
            .info-box {
                background: #f0f0f0 !important;
                border-left: 3px solid #198754 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .print-header {
                page-break-after: avoid;
            }
            
            .pricing-table tfoot tr {
                background: #198754 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        
        /* Print button */
        .print-actions {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .print-actions button {
            padding: 10px 25px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        
        .btn-print {
            background: #198754;
            color: white;
        }
        
        .btn-close-print {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Print Actions -->
    <div class="print-actions no-print">
        <button class="btn-close-print" onclick="window.close()">Close</button>
        <button class="btn-print" onclick="window.print()">🖨️ Print</button>
    </div>

    <div class="print-container">
         <!-- Header -->
         <div class="print-header">
             <?php if (!empty($settings['site_logo'])): ?>
                 <img src="<?= base_url('assets/images/' . $settings['site_logo']) ?>" alt="<?= htmlspecialchars($settings['site_name'] ?? 'Company Logo') ?>" style="max-height: 80px; margin-bottom: 10px;">
             <?php endif; ?>
             <h1><?= htmlspecialchars($settings['site_name'] ?? 'Osiram Safari Adventure') ?></h1>
             <p class="tagline"><?= htmlspecialchars($settings['site_tagline'] ?? 'Your Safari Adventure Awaits') ?></p>
             <p class="booking-ref">Booking Reference: <?= htmlspecialchars($booking->booking_ref) ?></p>
         </div>

         <!-- Status & Booking Info Summary (Top Right) -->
         <div class="summary-row">
             <div class="summary-col">
                 <div class="summary-item">
                     <span class="summary-label">Booking Date</span>
                     <span class="summary-value"><?= date('M d, Y', strtotime($booking->created_at)) ?></span>
                 </div>
             </div>
             <div class="summary-col">
                 <div class="summary-item">
                     <span class="summary-label">Status</span>
                     <?php
                     $status_classes = [
                         'pending' => 'status-pending',
                         'confirmed' => 'status-confirmed',
                         'deposit_paid' => 'status-deposit_paid',
                         'paid' => 'status-paid',
                         'completed' => 'status-completed',
                         'cancelled' => 'status-cancelled'
                     ];
                     $status_class = $status_classes[$booking->status] ?? 'status-pending';
                     ?>
                     <span class="status-badge <?= $status_class ?>" style="display: inline-block;">
                         <?= ucfirst(str_replace('_', ' ', $booking->status)) ?>
                     </span>
                 </div>
             </div>
             <div class="summary-col">
                 <div class="summary-item">
                     <span class="summary-label">Payment Status</span>
                     <span class="summary-value"><?= ucfirst($booking->payment_status ?? 'Unpaid') ?></span>
                 </div>
             </div>
         </div>

         <!-- Customer Information -->
         <div class="section">
             <h2 class="section-title">👤 Customer Information</h2>
             <table class="data-table">
                 <tr>
                     <th>Full Name</th>
                     <td><?= htmlspecialchars($booking->customer_name) ?></td>
                 </tr>
                 <tr>
                     <th>Email Address</th>
                     <td><?= htmlspecialchars($booking->customer_email) ?></td>
                 </tr>
                 <tr>
                     <th>Phone Number</th>
                     <td><?= htmlspecialchars($booking->customer_phone) ?></td>
                 </tr>
                 <tr>
                     <th>Country</th>
                     <td><?= htmlspecialchars($booking->customer_country ?? 'Not specified') ?></td>
                 </tr>
             </table>
         </div>

         <!-- Package Details -->
         <div class="section">
             <h2 class="section-title">📦 Package Information</h2>
             <table class="data-table">
                 <tr>
                     <th>Package Name</th>
                     <td><?= htmlspecialchars($booking->package_name ?? 'N/A') ?></td>
                 </tr>
                 <tr>
                     <th>Duration</th>
                     <td><?= $booking->duration_days ?? 'N/A' ?> Days</td>
                 </tr>
                 <tr>
                     <th>Category</th>
                     <td><?= ucfirst($booking->category ?? 'N/A') ?></td>
                 </tr>
                 <tr>
                     <th>Destinations</th>
                     <td><?= htmlspecialchars($booking->destinations ?? 'N/A') ?></td>
                 </tr>
             </table>
         </div>

         <!-- Travel Details -->
         <div class="section">
             <h2 class="section-title">✈️ Travel Details</h2>
             <div class="info-grid">
                 <div class="info-box">
                     <h3>Travel Start Date</h3>
                     <p><?= date('l, F d, Y', strtotime($booking->travel_date)) ?></p>
                 </div>
                 <div class="info-box">
                     <h3>End Date</h3>
                     <p><?= date('l, F d, Y', strtotime($booking->end_date ?? $booking->travel_date)) ?></p>
                 </div>
                 <div class="info-box">
                     <h3>Duration</h3>
                     <p><?= $booking->duration_days ?? 'N/A' ?> Days</p>
                 </div>
                 <div class="info-box">
                     <h3>Travelers</h3>
                     <p>
                         <?= $booking->travelers_adults ?> Adult<?= $booking->travelers_adults > 1 ? 's' : '' ?>
                         <?php if ($booking->travelers_children > 0): ?>
                             <br><?= $booking->travelers_children ?> Child<?= $booking->travelers_children > 1 ? 'ren' : '' ?>
                         <?php endif; ?>
                     </p>
                 </div>
                 <div class="info-box">
                     <h3>Accommodation</h3>
                     <p><?= ucfirst($booking->accommodation_preference ?? 'Mid-range') ?></p>
                 </div>
                 <div class="info-box">
                     <h3>Total Travelers</h3>
                     <p><?= ($booking->travelers_adults + $booking->travelers_children) ?> Person<?= ($booking->travelers_adults + $booking->travelers_children) > 1 ? 's' : '' ?></p>
                 </div>
             </div>
         </div>

         <!-- Pricing -->
         <div class="section">
             <h2 class="section-title">💰 Pricing Breakdown</h2>
             <table class="pricing-table">
                 <thead>
                     <tr>
                         <th>Description</th>
                         <th style="text-align: right;">Amount</th>
                     </tr>
                 </thead>
                 <tbody>
                     <?php if (!empty($booking->base_price)): ?>
                     <tr>
                         <td>Base Price</td>
                         <td>$<?= number_format($booking->base_price, 2) ?></td>
                     </tr>
                     <?php endif; ?>
                     <?php if (!empty($booking->adult_total)): ?>
                     <tr>
                         <td>Adults (<?= $booking->travelers_adults ?>)</td>
                         <td>$<?= number_format($booking->adult_total, 2) ?></td>
                     </tr>
                     <?php endif; ?>
                     <?php if ($booking->travelers_children > 0 && !empty($booking->children_total)): ?>
                     <tr>
                         <td>Children (<?= $booking->travelers_children ?>)</td>
                         <td>$<?= number_format($booking->children_total, 2) ?></td>
                     </tr>
                     <?php endif; ?>
                     <?php if (!empty($booking->single_supplement) && $booking->single_supplement > 0): ?>
                     <tr>
                         <td>Single Supplement</td>
                         <td>$<?= number_format($booking->single_supplement, 2) ?></td>
                     </tr>
                     <?php endif; ?>
                 </tbody>
                 <tfoot>
                     <tr>
                         <th>TOTAL AMOUNT DUE</th>
                         <td>$<?= number_format($booking->total_price, 2) ?> USD</td>
                     </tr>
                 </tfoot>
             </table>
         </div>

         <!-- Special Requests -->
         <?php if (!empty($booking->special_requests)): ?>
         <div class="section">
             <h2 class="section-title">📝 Special Requests</h2>
             <div class="special-requests">
                 <?= nl2br(htmlspecialchars($booking->special_requests)) ?>
             </div>
         </div>
         <?php endif; ?>

         <!-- Footer -->
         <div class="print-footer">
             <p class="company-name"><?= htmlspecialchars($settings['site_name'] ?? 'Osiram Safari Adventure') ?></p>
             <p>📍 <?= htmlspecialchars($settings['site_address'] ?? 'Box 15907 Arusha, Tanzania') ?></p>
             <p>📞 <?= htmlspecialchars($settings['site_phone'] ?? '+255 789 356 961') ?> | ✉️ <?= htmlspecialchars($settings['site_email'] ?? 'welcome@osiramsafari.com') ?></p>
             <p style="margin-top: 10px; font-size: 9pt;">Printed on <?= date('F d, Y \a\t H:i') ?></p>
         </div>
     </div>
</body>
</html>
