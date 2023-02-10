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

- prevent file inclusion attack
    - local file inclusion
    - remote file inclusion
- passwords in database 
    - change them!
    - hash them!
- no credentials in php
- disable directory listing
    - '/secretTexts'
    - '/dir'
- avoid sql injection
    - 'login.php'
- disable info.php
- clean robots.txt
- disable logged_in cookie
    - also check during file upload
- remove backupblog.php
- update version
    - php -> check for exploit!
    - apache -> check for exploit!
    - mysql -> check for exploit!
- disable ports
    - ssh
    - mysql