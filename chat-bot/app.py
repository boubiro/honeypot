import telepot
import logging
import requests
import threading
import logging.config

from telegram.ext import ParseMode
from queue import Queue
from telepot.loop import MessageLoop

logging.config.fileConfig('public/config/logging.config.ini')


def handle(msg):
    command = ''
    content_type, chat_type, chat_id = telepot.glance(msg)
    logging.info('----------Got Connection From User [{}]-------'.format(chat_id))
    file_name = get_filename(str(chat_id))
    img_path = IMG_PATH + file_name

    logging.info('content_type is: {}'.format(content_type))
    logging.info('chat_id is: {}'.format(chat_id))

    if command == '/start':
        bot.sendMessage (chat_id, str("fuck u"))
    
    elif command == '/keluhan':
        bot.sendMessage (chat_id, str("fuck u too"))

if __name__ == "__main__":
    bot = telepot.Bot('1134714364:AAGubrGz9t9RP_Y7NUF0taViVT68w9nHhwE')
    queue_1 = Queue()
    MessageLoop(bot, handle).run_as_thread()

    t2 = threading.Thread(target=send_recv_img, args=(queue_1), name='Thread 2')
    t2.start()