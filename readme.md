Football Agent Management System
A comprehensive user management system for a Football Agent website built with PHP and MySQL as part of Assignment 2.

🎯 Assignment Requirements Completed
✅ User Roles & Database
4 User Roles: Admin, Player, Agent, Club Manager

Database Design: Proper table structure with relationships

Sample Data: 2 users per role (8 total users)

✅ CRUD Operations
Create: Add new users and player profiles through admin panel

Read: View all users with filtering and player management

Update: Edit user information and player profiles

Delete: Remove users and player profiles with confirmation

✅ Technical Features
Secure Authentication with session management

Role-based Access Control

Password Hashing for security

Input Validation and error handling

Responsive Design matching website theme

Database Export functionality for assignment submission

🚀 Quick Start Guide
Prerequisites
XAMPP/WAMP/MAMP installed

PHP 7.4+

MySQL/MariaDB

Web browser

Installation Steps
Setup Database

bash
# Import the database (if you have SQL file)
# Or run the setup script
http://localhost/your-project/php/setup_database.php
Access the System

Main URL: http://localhost/your-project/

Login URL: http://localhost/your-project/php/login.php

Demo Login Credentials

text
All users use password: 'password'

Admin: 
- admin1 / password
- admin2 / password

Player:
- musa_tombo / password  
- kai_kamara / password

Agent:
- nelson_agent / password
- sarah_agent / password

Club Manager:
- club_manager1 / password
- club_manager2 / password
📁 CORRECT Project Structure
text
football_agent_system/
├── index.html                 # Homepage
├── services.html              # About/Services page
├── contact.html               # Contact page
├── styles.css                 # Main stylesheet
│
├── php/                       # ALL PHP FILES GO HERE
│   ├── login.php              # User login
│   ├── logout.php             # Logout script
│   ├── register.php           # Player registration
│   ├── connect.php            # Database connection
│   ├── dashboard.php          # User dashboard
│   ├── profile.php            # User profile management
│   │
│   ├── admin/                 # Admin panel
│   │   ├── dashboard.php      # Admin dashboard
│   │   ├── users.php          # User management
│   │   ├── create_user.php    # Create new user
│   │   ├── edit_user.php      # Edit user
│   │   ├── players.php        # Player management
│   │   ├── create_player_profile.php  # Create player profile
│   │   ├── edit_player.php    # Edit player profile
│   │   
│   │
│   ├── includes/              # Authentication & security
│   │   ├── auth_check.php     # Authentication check
│   │   └── admin_check.php    # Admin role check
│   │
│   ├── models/                # Database models
│   │   ├── UserModel.php      # User CRUD operations
│   │   └── PlayerModel.php    # Player profile management
│   │
│   └── tables/                # Database table structures
│       ├── users_table.php
│       ├── players_table.php
│       ├── agents_table.php
│       └── club_managers_table.php
│
├── images/                    # Website images
│   ├── logo.png
│   ├── img1.jpg, img2.jpg, etc.
│   └── p1.jpg, p2.jpg, p3.jpg (player images)
│
└── README.md                  # This file
👥 User Roles & Permissions
🛠️ Admin
Full system access and user management

Create, read, update, delete all users

Player profile management

Database export functionality

System statistics and overview

⚽ Player
Personal dashboard with statistics

Profile viewing and basic editing

Player registration system

View assigned agent information

🤝 Agent
Player management capabilities

Client portfolio overview

Contract negotiation tools

Player statistics tracking

🏢 Club Manager
Team management interface

Player scouting features

Contract offer management

Club information management

🔧 Technical Implementation
Database Schema
sql
-- Main tables structure
users (id, username, email, password, role, first_name, last_name, phone, address, ...)
players (id, user_id, position, height, weight, current_club, agent_id, stats, video_url, ...)
agents (id, user_id, license_number, years_experience, ...)
club_managers (id, user_id, club_name, club_location, ...)
Security Features
Password Hashing: Using password_hash() and password_verify()

SQL Injection Prevention: Prepared statements with MySQLi

XSS Protection: Input sanitization and output escaping

Session Management: Secure session handling with role checks

Role-based Access: Different dashboards and permissions per role

Key PHP Features
Object-oriented programming with Models

MVC-like architecture

Form validation and error handling

File upload handling (for future expansion)

Responsive design with CSS Grid/Flexbox

🎮 How to Use the System
For Admins:
Login at php/login.php

Access Admin Dashboard from user dashboard

Manage Users through the user management interface

Create Player Profiles for player users

Export Database for assignment submission

For Players:
Register at php/register.php or login with existing account

Access Dashboard to view personal information

Update Profile with contact information

View Player Stats and assigned agent

Important URLs:
Login: http://localhost/your-project/php/login.php

User Dashboard: http://localhost/your-project/php/dashboard.php

Admin Panel: http://localhost/your-project/php/admin/dashboard.php

Player Management: http://localhost/your-project/php/admin/players.php

For Assignment Submission:
Login as Admin and go to Admin Dashboard

Click "Export Database" to download SQL file

Include in submission:

All source code files

Database export SQL file

Screenshots of working system

This README file

📊 Database Features
Sample Data Included
2 Admin users

2 Player users with detailed profiles

2 Agent users

2 Club Manager users

Player Statistics Tracking
Goals, assists, matches played

Yellow/red cards

Physical attributes (height, weight)

Position and preferred foot

Video highlights URLs

Agent assignments

🔄 CRUD Operations Demo
User Management (Admin)
✅ Create: Add new users with different roles

✅ Read: View all users in table format

✅ Update: Edit user information and roles

✅ Delete: Remove users with confirmation

Player Profile Management
✅ Create: Add detailed football profiles to players

✅ Read: View players in table or card view

✅ Update: Edit player stats and information

✅ Delete: Remove player profiles

🛡️ Security Measures
Authentication System

Session-based login

Password hashing

Automatic logout

Authorization

Role-based access control

Admin-only areas protected

User-specific data isolation

Input Validation

Form data sanitization

SQL injection prevention

XSS protection

Error Handling

User-friendly error messages

No sensitive data exposure

Proper logging (for production)

🌐 Browser Compatibility
✅ Chrome 90+

✅ Firefox 88+

✅ Safari 14+

✅ Edge 90+

✅ Mobile responsive design

📝 Assignment Submission Checklist
All source code files included

Database export SQL file generated

System works with demo accounts

CRUD operations functional

Role-based access working

No errors or warnings

Documentation complete

🐛 Troubleshooting
Common Issues:
Database Connection Error

Check XAMPP/WAMP is running

Verify database credentials in php/connect.php

Login Not Working

Ensure using correct demo credentials

Check session is enabled in PHP

Access login via php/login.php

Page Not Found

Verify file paths and URLs

All PHP files should be in php/ folder

Permission Errors

Ensure file permissions are correct

Check database user privileges

Important Notes:
All PHP files are in the php/ folder

Access login via php/login.php not root login.php

HTML files remain in root directory

📞 Contact & Support
Football Agent Sierra Leone
📍 15 Goderich Street, Freetown, Sierra Leone
📧 nelson@footballagent.sl
📞 +232 79 826-564

Developed for Educational Purposes
© 2025 Football Agent Sierra Leone - Assignment 2 Submission