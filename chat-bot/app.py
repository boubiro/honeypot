import time
import telepot
import logging
import requests
import threading
import logging.config
import mysql.connector

from telepot.loop import MessageLoop

logging.config.fileConfig('public/config/logging.config.ini')

def getConnection():
    mydb = mysql.connector.connect(
        host="111.92.169.31",
        user="snort",
        password="snort26"
    )

    mycursor = mydb.cursor()

    mycursor.execute("SELECT * FROM sr_redirected_ip")

    myresult = mycursor.fetchall()

    for x in myresult:
        print(x)


def handle(msg):
    command = ''
    content_type, chat_type, chat_id = telepot.glance(msg)
    logging.info('----------Got Connection From User [{}]-------'.format(chat_id))

    if 'text' in msg:
        command = msg['text']

    logging.info('content_type is: {}'.format(content_type))
    logging.info('chat_id is: {}'.format(chat_id))

    if command == '/view':
        bot.sendMessage (chat_id, str("fuck u"))
        getConnection()


if __name__ == "__main__":
    bot = telepot.Bot('1134714364:AAGubrGz9t9RP_Y7NUF0taViVT68w9nHhwE')
    MessageLoop(bot, handle).run_as_thread()

    print ('Listening ...')

    # Keep the program running.
    while 1:
        time.sleep(10)