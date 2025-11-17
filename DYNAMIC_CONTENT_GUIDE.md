# Dynamic Content Integration - Bislig Tourism Website

## Overview
All the static HTML pages have been successfully converted to dynamic PHP pages that fetch data from the MySQL database. This means that any changes made through the admin panel (add, edit, or delete) will automatically be reflected on the public-facing pages.

## Files Created

### 1. **accommodations.php**
- Fetches accommodation data from the `accommodations` table
- Displays: name, description, location, phone, rating, and badge
- Orders by rating (highest first)

### 2. **destinations.php**
- Fetches destination data from the `destinations` table
- Displays: name, description, location, rating, and optional image
- Orders by rating (highest first)

### 3. **restaurants.php**
- Fetches restaurant data from the `restaurants` table
- Displays: name, description, location, phone, email, and badge
- Orders by ID (most recent first)

### 4. **attractions.php**
- Fetches attraction data from the `attractions` table
- Displays: name, description, location, rating, and badge
- Orders by rating (highest first)

### 5. **festivals.php**
- Fetches festival data from the `festivals` table
- Displays: name, description, location, date, and patron saint
- Orders by ID (most recent first)

### 6. **transportation.php**
- Fetches transportation data from the `transportation` table
- Displays: name, description, operating hours, and rating
- Orders by rating (highest first)

### 7. **emergency.php**
- Fetches emergency contacts from the `emergency_contacts` table
- Displays: name, phone, and description
- Orders by ID (ascending)

## Files Updated

### **index.html**
- Updated all navigation links from `.html` to `.php`
- Updated all internal page links (CTA buttons, feature cards, footer links)

## How It Works

1. **Admin Panel**: Administrators can log in to the admin panel and manage all content:
   - Add new entries
   - Edit existing entries
   - Delete entries

2. **Database Storage**: All changes are stored in the MySQL database (`bislig_db`)

3. **Dynamic Display**: The PHP pages automatically fetch the latest data from the database and display it on the website

4. **Real-time Updates**: When an admin adds, edits, or deletes content, the changes are immediately visible on the public pages

## Database Connection

All PHP pages use the database connection from `admin/database.php`:
```php
include 'admin/database.php';
```

This connects to:
- Host: localhost
- Database: bislig_db
- User: root
- Password: (empty by default)

## Features

✅ **Dynamic Content**: All content is pulled from the database
✅ **Admin Control**: Admins can manage all content through the admin panel
✅ **Graceful Fallback**: If no data exists, a friendly message is displayed
✅ **Security**: All output is sanitized using `htmlspecialchars()`
✅ **Consistent Design**: All pages maintain the original design and layout

## Testing

To test the system:

1. Access the admin panel: `http://localhost/bislig/admin/admin.php`
2. Log in with your admin credentials
3. Add, edit, or delete content in any section
4. View the public pages (e.g., `http://localhost/bislig/accommodations.php`)
5. Verify that the changes appear immediately

## Note

The original `.html` files have been kept intact. You can delete them if you want, or keep them as backups. The new `.php` files are now the active pages that should be used.
