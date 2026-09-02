DEVELOPER PORTFOLIO CMS
========================

STACK
-----
PHP + MySQL + Bootstrap 5 + JavaScript + Bootstrap Icons

INSTALLATION
------------
1. Copy this folder into:
   C:\xampp\htdocs\developer-portfolio

2. Start Apache and MySQL in XAMPP.

3. Open phpMyAdmin:
   http://localhost/phpmyadmin

4. Import:
   database/portfolio.sql

5. Visit:
   http://localhost/developer-portfolio/setup_admin.php

6. Create your admin account.

7. IMPORTANT:
   Delete setup_admin.php after creating the admin.

8. Admin login:
   http://localhost/developer-portfolio/auth/login.php

9. Public portfolio:
   http://localhost/developer-portfolio/

PROJECT UPLOADS
---------------
Use Admin Dashboard > Add Project.
Upload JPG/JPEG/PNG/WEBP screenshots up to 5MB.

EDIT YOUR PERSONAL DETAILS
--------------------------
Update the text in index.php and about.php.
Update social links in includes/footer.php.
Place your profile image in assets/images if you want to add one.

DATABASE
--------
The CMS stores:
- admins
- projects
- skills
- contact messages

SECURITY NOTES
--------------
- Admin passwords use password_hash/password_verify.
- Project forms use prepared statements.
- Uploaded project images are restricted by extension and size.
- Delete setup_admin.php after first use.
- For production, also add CSRF protection, stricter upload MIME validation,
  HTTPS and server-side authorization hardening.

BRANDING
--------
Portfolio name: Emiabata Mukhtar
Professional title: Website Developer & Full-Stack Web Developer
