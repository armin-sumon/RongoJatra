-- SQL script to update existing RongoJatra database for enhanced booking system
-- Run this script to add new fields and tables for the booking management system

-- Add new columns to existing tblbooking table
ALTER TABLE `tblbooking` 
ADD COLUMN `CancellationReason` text DEFAULT NULL AFTER `CancelledBy`,
ADD COLUMN `AdminRemark` text DEFAULT NULL AFTER `CancellationReason`;

-- Update default status to 2 (pending) for new bookings
ALTER TABLE `tblbooking` 
MODIFY COLUMN `status` int(11) DEFAULT 2;

-- Create chat messages table for confirmed bookings
CREATE TABLE IF NOT EXISTS `tblchatmessages` (
  `MessageId` int(11) NOT NULL AUTO_INCREMENT,
  `BookingId` int(11) DEFAULT NULL,
  `SenderType` enum('user','admin') DEFAULT 'user',
  `Message` text DEFAULT NULL,
  `MessageDate` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`MessageId`),
  KEY `BookingId` (`BookingId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Update existing bookings to have pending status if they don't have a status
UPDATE `tblbooking` SET `status` = 2 WHERE `status` IS NULL;

-- Add some sample cancellation reasons for testing
INSERT INTO `tblbooking` (`PackageId`, `UserEmail`, `FromDate`, `ToDate`, `Comment`, `RegDate`, `status`, `CancelledBy`, `CancellationReason`, `AdminRemark`) VALUES
(1, 'test@example.com', '2024-01-15', '2024-01-20', 'Sample booking for testing', NOW(), 0, 'Admin', 'No seats available & full vacancy', 'Booking cancelled due to unavailability');

-- Add welcome message for confirmed bookings
INSERT INTO `tblbooking` (`PackageId`, `UserEmail`, `FromDate`, `ToDate`, `Comment`, `RegDate`, `status`, `CancelledBy`, `CancellationReason`, `AdminRemark`) VALUES
(4, 'confirmed@example.com', '2024-02-01', '2024-02-05', 'Confirmed booking sample', NOW(), 1, NULL, NULL, 'Welcome to RongoJatra! Your booking is confirmed.');

-- Add sample chat messages for confirmed booking
INSERT INTO `tblchatmessages` (`BookingId`, `SenderType`, `Message`, `MessageDate`) VALUES
(LAST_INSERT_ID(), 'admin', 'Your booking has been confirmed! Welcome to RongoJatra. Our team will assist you with your travel arrangements.', NOW()),
(LAST_INSERT_ID(), 'user', 'Thank you! I am excited about this trip.', NOW()),
(LAST_INSERT_ID(), 'admin', 'Great! We will send you detailed itinerary soon.', NOW());

-- Show completion message
SELECT 'Database updated successfully! New booking system features are now available.' as Status;
