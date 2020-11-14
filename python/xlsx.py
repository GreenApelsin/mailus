import requests
import json
import os.path
import xlrd

def cvsGO(path, filename):
    setTitle = 0
    setError = ''
    setErrorState = ''
    wb = xlrd.open_workbook(path)
    sheet = wb.sheet_by_index(0)
    cols = len(sheet.row(0))
    rows = len(sheet.col(0))

    for i in range(1, cols):
        col_adr = sheet.row(0)[i].value
        if str(col_adr) == 'ADRESS':
            num_col_adr = i

    for i in range(1, rows):
        lst =  sheet.col(num_col_adr)[i].value
        url = "https://address.pochta.ru/validate/api/v7_1"
        headers = {
            "Content-type": "application/json",
            "AuthCode": "53fb9daa-7f06-481f-aad6-c6a7a58ec0bb"}
        data = {
            "version": "demo",
            "addr": [{"val": lst}]
        }
        answer = requests.post(url, data=json.dumps(data), headers=headers)
        response = answer.json()
        try:
            address_norm = response['addr']['outaddr']
        except Exception as e:
            setErrorState = "Не корректный адрес"
            setError = lst
            continue
        index = str(response['addr']['outaddr'])[:6]
        state = ''
        if response['state'] == '301':
            state = "Адрес подтвержден"
        elif response['state'] == '201':
            state = "Адрес не подтвержден полностью"
        elif response['state'] == '202':
            state = "Превышено время ожидания обработки запроса"
        elif response['state'] == '203':
            state = "Адрес отклонён при ручной верификации"
        elif response['state'] == '404':
            state = "Ящик в указанном ОПС не найден"
        elif response['state'] == '302':
            state = "Неполный адрес"
        elif response['state'] == '303':
            state = "Возможны несколько вариантов адреса"
            # хочу проверить только полностью прогнать файл, интересно сколько уйдёт на обрпботку
        elif response['state'] == 'REQ001' or response['state'] == 'REQ002' or response['state'] == 'REQ003':
            state = "Внутренняя ошибка формата"

        with open('/var/www/html/uploads/xls/done' + str(filename).split('.')[0] + '.csv', 'a', newline='\n', encoding='utf-8-sig') as fd:
            if setTitle == 0:
                fd.write("ADRESS;INDEX;New_ADRESS;STATUS\n")
                setTitle = 1
            if setError != '':
                fd.write(";"";" + setError + ";" + setErrorState + '\n')
                setError = setErrorState = ''
            fd.write(address_norm + ";" + index + ";" + lst + ";" + state + '\n')
    return 1