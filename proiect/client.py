import socket

domain = socket.AF_INET
type = socket.SOCK_DGRAM
protocol = 0

sock = socket.socket(domain, type, protocol)

client_data = b'hello Jaynos'
length = 4096
flags = 0
server_address = ('192.168.160.1', 5555)

sock.sendto(client_data, server_address)

server_data, server_address = sock.recvfrom(length)

print(f"Received from: '{server_address[0]}:{server_address[1]}' => {server_data.decode()}")

sock.close()
