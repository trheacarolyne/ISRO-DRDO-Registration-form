ISRO & DRDO Research Careers Portal
A student-built web portal prototype exploring a simplified recruitment journey for India's space and defence research organisations: ISRO and DRDO. The project combines informational pages with a mock application and assessment flow, using a navy/blue-and-gold visual theme.

Features
- Home page introducing ISRO, DRDO and research careers
- About page with organisation information and the prototype eligibility flow
- Application form with personal, educational and experience fields
- Upload fields for UG marks card (required in the demo), PG marks card and PhD certificate (optional)
- Experience-based demo routing:
  - 5 years or less: verification and screening route
  - More than 5 years: interview route
- Resident verification demo
- Short scientific screening quiz
- AISME (proposed All India Scientific Merit Examination) demo quiz
- Interview slot booking form
- Responsive styling, navigation and light/dark mode toggle
  
Built With
- PHP
- HTML
- CSS
- JavaScript
- MySQL
- PDO for PHP database access
- XAMPP (recommended local development environment)

ISRO_DRDO_Styled_Portal/
- index.php                 # Homepage
- about.php                # ISRO, DRDO and prototype eligibility overview
- application.php           # Application form and document uploads
- verification.php          # Residency verification demo
- screening.php            # Scientific screening quiz
- aisme.php               # AISME demonstration exam
- interview.php            # Interview booking form
- config.php              # MySQL/PDO connection settings
- database.sql             # Database setup SQL (see database compatibility note)
-  README.md
-  assets/
│   - style.css            # Site styles and theme
│   -script.js            # Client-side interactions
├── includes/
│   - header.php           # Shared navigation/header
│   -footer.php           # Shared footer
- uploads/                 # Uploaded demonstration documents
