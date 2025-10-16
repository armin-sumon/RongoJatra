# RongoJatra Enhanced Booking System

## Overview
This enhanced booking system provides a complete solution for managing travel package bookings with user and admin controls, including pending status, cancellation options, and chat functionality for confirmed bookings.

## Features Implemented

### 1. Booking Status Management
- **Pending Status**: All new bookings start with "Pending" status (status = 2)
- **Confirmed Status**: Admin can confirm bookings (status = 1)
- **Cancelled Status**: Either user or admin can cancel bookings (status = 0)

### 2. User Booking Management
- **My Bookings Page**: Users can view all their bookings at `/my-bookings.php`
- **Cancel Option**: Users can cancel pending bookings with reason
- **Chat Access**: Users can chat with admin for confirmed bookings
- **Status Tracking**: Real-time status updates

### 3. Admin Controls
- **Booking Management**: Enhanced admin panel at `/admin/manage-bookings.php`
- **Status Control**: Admin can confirm or cancel any booking
- **Cancellation Reasons**: Admin can specify reasons for cancellation
- **Chat System**: Admin can communicate with users for confirmed bookings
- **Welcome Messages**: Automatic welcome message sent when booking is confirmed

### 4. Chat System
- **Real-time Communication**: Chat between users and admin for confirmed bookings
- **Message History**: All messages are stored and displayed chronologically
- **User/Admin Distinction**: Messages are clearly marked by sender type
- **Automatic Welcome**: System sends welcome message upon confirmation

## Database Changes

### New Fields Added to `tblbooking`:
- `CancellationReason` (text): Reason for cancellation
- `AdminRemark` (text): Admin comments and remarks
- `status` (int): Default value changed to 2 (pending)

### New Table `tblchatmessages`:
- `MessageId` (int, primary key)
- `BookingId` (int, foreign key)
- `SenderType` (enum: 'user', 'admin')
- `Message` (text)
- `MessageDate` (timestamp)

## Files Modified/Created

### Modified Files:
1. **database.sql** - Updated schema with new fields and tables
2. **booking.php** - Changed initial status to pending (2)
3. **admin/manage-bookings.php** - Enhanced with chat and cancellation controls
4. **includes/header.php** - Added "My Bookings" link for logged-in users

### New Files:
1. **my-bookings.php** - User booking management page
2. **update_database.sql** - SQL script to update existing database

## Installation Instructions

### 1. Database Update
Run the SQL script to update your existing database:
```sql
-- Execute the contents of update_database.sql
```

### 2. File Deployment
- Upload all modified and new files to your web server
- Ensure proper file permissions are set

### 3. Configuration
- No additional configuration required
- System uses existing database connection

## Usage Guide

### For Users:
1. **Make a Booking**: Book a package through the normal process
2. **View Status**: Check "My Bookings" to see pending status
3. **Cancel if Needed**: Cancel pending bookings with reason
4. **Chat with Admin**: For confirmed bookings, use chat feature

### For Admins:
1. **Review Bookings**: Check admin panel for new pending bookings
2. **Confirm/Cancel**: Update booking status with appropriate actions
3. **Add Reasons**: Specify cancellation reasons when needed
4. **Chat with Users**: Communicate with users for confirmed bookings

## Booking Status Flow

```
User Books Package → Pending Status (2)
                    ↓
            Admin Reviews Booking
                    ↓
    ┌─────────────────┬─────────────────┐
    ↓                 ↓                 ↓
Confirmed (1)    Cancelled (0)    Remains Pending (2)
    ↓                 ↓                 ↓
Chat Available    Reason Required    User Can Cancel
```

## Chat System Features

### For Confirmed Bookings Only:
- **User Messages**: Appear on the right side (gray background)
- **Admin Messages**: Appear on the left side (blue background)
- **Timestamps**: All messages show date and time
- **Message History**: Complete conversation history maintained
- **Auto-scroll**: Chat container scrolls to show latest messages

## Cancellation Reasons

### Common Reasons Include:
- "No seats available & full vacancy"
- "User requested cancellation"
- "Package discontinued"
- "Weather conditions"
- "Administrative reasons"

## Security Features

- **Input Validation**: All user inputs are validated and sanitized
- **SQL Injection Protection**: Prepared statements used throughout
- **XSS Prevention**: All outputs are properly escaped
- **Session Management**: Proper session handling for user authentication

## Browser Compatibility

- **Modern Browsers**: Chrome, Firefox, Safari, Edge
- **Mobile Responsive**: Works on tablets and smartphones
- **Bootstrap Framework**: Consistent UI across devices

## Support and Maintenance

### Regular Tasks:
- Monitor booking statuses
- Respond to user chat messages
- Update cancellation reasons as needed
- Backup chat message history

### Troubleshooting:
- Check database connection if chat doesn't work
- Verify file permissions for new PHP files
- Ensure JavaScript is enabled for modal functionality

## Future Enhancements

Potential improvements for future versions:
- Email notifications for status changes
- SMS notifications for urgent communications
- File attachment support in chat
- Booking modification requests
- Payment integration
- Multi-language support

---

**Note**: This system maintains backward compatibility with existing bookings while adding new functionality for enhanced user experience and admin control.
