import pymysql
import csv
import xlsx


def connectDB():  # Подключаем бд
    return pymysql.connect("a0481790.xsph.ru", "a0481790_mail", "kj19sj3n", "a0481790_mail")


def CheckState():  # ищем ожидающих
    connection = connectDB()
    with connection.cursor() as cursor:
        cursor.execute("SELECT `path`, `name` FROM `tables` WHERE `status` = 0")
        return cursor.fetchone()


def EditState(filename, state):
    connection = connectDB()
    with connection.cursor() as cursor:
        cursor.execute("UPDATE `tables` SET `status` = %s WHERE `name` = %s",  (state, filename))

while(1):
    res = CheckState()
    if res == None:
        continue
    path = res[0]
    filename = res[1]

    if path[8:11] == 'cvs':
        EditState(filename, 1)
        if csv.cvsGO('/var/www/html/' + path + filename, filename) == 1:
            EditState(filename, 2)
    elif path[8:11] == 'xls':
        EditState(filename, 1)
        if xlsx.cvsGO('/var/www/html/' + path + filename, filename) == 1:
            EditState(filename, 2)