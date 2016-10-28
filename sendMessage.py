from socket import *
import sys

print (sys.argv)
ipAddress = sys.argv[1]
message = sys.argv[2]
port = 3333
sock = socket(AF_INET, SOCK_DGRAM)
sock.bind (('',0))
sock.setsockopt (SOL_SOCKET, SO_BROADCAST, 1)
sock.sendto(message, (ipAddress, port))
print 'Sent ' + message + ' to ' + ipAddress + ':' + str(port) + '\n'   
print 'done'