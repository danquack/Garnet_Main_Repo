#!/bin/env python
import os
import logging
from logging import Logger
import subprocess
import argparse
import datetime

class MySQLDumpError(Exception):
   """ An Exception Return Code for Mysql Dump """
   pass

class GoogleDriveUploadError(Exception):
   """ An Exception Return Code for Google Drive Upload """
   pass

def dump_database(timestring):
   """ A function to dump the database into tmp
   :param timestring: time string for backup
   :return upload to drive success
   """
   cmd = "mysqldump --all-databases > /tmp/{0:s}.sql".format(timestring)
   logging.debug("Executing command:" + cmd)
   process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

   # wait for the process to terminate
   out, err = process.communicate()
   errcode = process.returncode
   if errcode:
       raise MySQLDumpError(errcode)
   else:
       logging.debug("Backup Success:" + out)
       return upload_to_drive(timestring)

def upload_to_drive(timestring):
   """ A function to upload files to google drive """
   cmd = "./gdrive-linux-386 upload -p 1PodI4Dxc1dyEu1j1rNtgUdiIqgiQQtMA /tmp/{0:s}.sql".format(timestring)
   logging.debug("Uploading to Google Drive: {0:s}.sql".format(timestring))
   process = subprocess.Popen(cmd, shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

   # wait for the process to terminate
   out, err = process.communicate()
   errcode = process.returncode
   if errcode:
       raise GoogleDriveUploadError(errcode)
   else:
       logging.debug("Upload Success")
       return out

def main():
   today = datetime.datetime.now()
   time = today.isoformat().split(".")[0]
   logging.info("Backup Executing: " +  time)
   try:
       dump_database(time)
   except MySQLDumpError as e:
       logging.error('ERROR: Mysql Exception with {}'.format(e))
       raise e
   except GoogleDriveUploadError as e:
       logging.error('ERROR: Google Drive Exception with {}'.format(e))
       raise e
   except Exception as e:
       logging.error(e)
       raise e
   logging.info("Backup Successful")

if __name__ == "__main__":
   parser = argparse.ArgumentParser(description='Backup Database and send backup to google drive.')
   parser.add_argument('-d', '--debug', dest='debug', action='store_true', help='debug function')
   args = parser.parse_args()
   if args.debug:
       logging.basicConfig(level=logging.DEBUG)
    logging.debug("Debug Option Enabled")
   else:
       logging.basicConfig(level=logging.NOTSET)
   main()

