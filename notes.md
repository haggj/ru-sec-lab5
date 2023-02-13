# Lab 5


# Setup

- connect to vulcan with -X: `ssh -X jonash22@vulcan.hir.is`
- start virtualbox `virtualbox`
    - this opens a GUI on the local machine

# Server files

- `admin.php`

| File | Auth? | Forms? | Database? | Issues |
| --- | --- | --- | --- | --- |
| `admin.php` | Yes (no functionality without) | Yes, upload files | Yes. store files in db table `blogs` | upload file names to database are  **not** filtered; leaks db password; sql injection |
| `backupblog.php` | Yes (allows upload) | Yes, upload files to fs (`dir/`) | no | nothing found? |
| `blog.php` | No | No | Yes | leaks db passwords; lfi; rfi |
| `login.php` | No | Yes, login | Yes, verifies credentials | leaks db passwords; sql injection; weak cookie |
| `messages.php` | Yes, see all messages | No | Yes, loads entries | leaks db passwords |

# Things to protect



SYSTEM:
- update version
    - php -> check for exploit!
    - apache -> check for exploit!
    - mysql -> check for exploit!
- disable ports
    - ssh
    - mysql
- passwords in database 
    - change them!
    - DONE hash them!
- disable second database running at 33060
- change system users passwords

APACHE:
- disable access to files in dir
- disable directory listing
    - '/secretTexts'
    - '/dir'

PHP:
- disable uploads "php, phar, phtml"
- DONE no credentials in php
- DONE disable info.php
- DONE clean robots.txt
- DONE remove backupblog.php
- DONE disable php errors
- DONE disable logged_in cookie
    - also check during file upload
- DONE prevent file inclusion attack
    - DONE local file inclusion
    - DONE remote file inclusion
-- DONE avoid sql injection
    - DONE 'login.php'
    - DONE 'admin.php'