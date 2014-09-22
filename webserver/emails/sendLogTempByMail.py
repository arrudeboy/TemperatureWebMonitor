#!/usr/bin/python
from datetime import datetime
import smtplib, sys, os

from email.mime.text import MIMEText


os.system("shutdown.sh")


USERNAME = "arturofelixchari@gmail.com"
PASSWORD = "mypasswd"

MAILTO = ''

with open('/mnt/sda1/webexample/admin_emails.config') as data:
    datalines = (line.rstrip('\n') for line in data)
    for line in datalines:
        MAILTO += line
        MAILTO += ', '

MAILTO = MAILTO[:-2]


msg = MIMEText('S1 Temp. = '+str(sys.argv[1])+'\nS2 Temp. = '+str(sys.argv[2])+'\nS3 Temp. = '+str(sys.argv[3]))
                                                                                                                                          
                                                                                                             
msg['Subject'] = 'TempLog ['+datetime.now().strftime('%Y-%m-%d %H:%M:%S')+']'
msg['From'] = USERNAME
msg['To'] = MAILTO    

server = smtplib.SMTP('smtp.gmail.com:587')
server.ehlo_or_helo_if_needed()
server.starttls()
server.ehlo_or_helo_if_needed()
server.login(USERNAME,PASSWORD)
server.sendmail(USERNAME, MAILTO.split(","), msg.as_string())

server.quit()
