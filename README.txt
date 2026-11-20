ISRO & DRDO RESEARCH CAREERS PORTAL — STUDENT PROJECT

DESIGN
This version follows the blue/navy and gold design, content sections, navigation,
dark-mode toggle, and image-led cards from the HTML reference pages supplied.

INSTALLATION (WINDOWS + XAMPP)
1. Extract this folder into C:\xampp\htdocs\
2. Start Apache and MySQL in XAMPP.
3. Use the existing database named isro_drdo_portal.
4. If the existing database has the schema from your project, do NOT import database.sql again.
5. Open http://localhost/ISRO_DRDO_Styled_Portal/

DATABASE
config.php connects to:
Host: localhost
Database: isro_drdo_portal
Username: root
Password: (blank)

If your MySQL password is not blank, edit config.php.

APPLICATION FLOW
- Application details are inserted into applications.
- Uploaded UG/PG/PhD documents are recorded in application_documents.
- Experience <= 5 years redirects to verification.php.
- Experience > 5 years redirects to interview.php.
- Screening and AISME demo scores are stored in test_results.
- Interview bookings are stored in interview_bookings.

IMAGES
The site uses image URLs from images.unsplash.com. Internet access is needed for those
images to load. The site itself runs locally through XAMPP.

IMPORTANT
This is an academic prototype, not an official ISRO/DRDO recruitment service.
Do not upload real identity documents or sensitive personal information.
