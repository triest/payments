# payments

Дмитрий, доброго дня!  Ниже тестовое задание, результат можно выложить на гит, если что :  Написать модуль пополнения баланса
1) Развернуть чистый ларавель. Поднять БД. (Отредактировать стандартную миграцию - добавить к стандартным юзерам колонку balance) 2) Написать контроллер + шаблон, для отображения формы (поля формы в ниже). Клиент заполняет форму, после этого отправляет запрос к платежной системе, для совершения оплаты. (Сохраняем его запрос в БД) 3) Написать контроллер, который обрабатывают ответ от платежной системы (Проверка запроса, пополнение баланса юзера) 4) И так сделать для 2-х вариантов платежных систем
XYZPayment’s   Доп поля формы оплаты:   — Сумма оплаты   — Имя плательщиа (не обязательное поле)
  Переход к оплате:   — GET запрос на https://xyz-payment.ru/pay     Параметры запроса: sum, order_id (номер заказа в нашей системе), name (имя плательщика если указано)
  Обработка ответа:   — Ответ приходит POST запросом (form). Возвращаются параметры: order_id, sum, name, transaction_id, sign     transaction_id - ИД транзакции на стороне платежной системы     sign - Подпись от платежной системы. Проверка подписи через сравнение с секретным ключем.   — Зачисление денег на баланс пользователю (если все хорошо)
OLDPay   Доп поля формы оплаты:   — Сумма оплаты   — Имя плательщиа
  Переход к оплате:   — Мы отправляем POST запрос на https://old-pay.ru/api/create   — Параметры запроса: sum, order_id, name   — В ответ получаем JSON {"status":"success", "redirect_to": ""}   — Перенаправляем пользователя на этот .
  Обработка ответа:   — Ответ приходит JSON строкой. Возвращаются параметры: {"order_id": "", "payment_id": ""}   — Проверка оплаты через доп GET запрос https://old-pay.ru/api/get-status?id=     в заголовке (X-Secret-Key) передаем секретный ключ   — Ответ на GET запрос в виде JSON строки с параметрами {"status": "", "sum":"", "order_id":""}   — Зачисление денег на баланс пользователю (если все хорошо)
5) Секретные ключи - это строки из настроек системы, храним в .env файле. (SECRET_XYZ и SECRET_OLD)
