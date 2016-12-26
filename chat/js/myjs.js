
$(document).ready(function () {
    //id последнего загруженного сообщения
    var messageId = 0;
    //обработка нажатия enter
    $('#text').keypress(function (e) {
        if (e.keyCode == 13)
            $('#sendButton').trigger("click");
    });
    //функция отправки пост-запроса, закодированного как json
    function sendData(data, callback) {
        $.post("chatController.php", JSON.stringify(data)).done(callback);
    }
    //функция для экранирования html тегов в сообщениях пользователей
    var escape = document.createElement('textarea');
    function escapeHTML(html) {
        escape.textContent = html;
        return escape.innerHTML;
    }
    /**
     * функция для получения сообщения с сервера
     * отправляем id последнего сообщения, отображающегося у клиента (хранится в messageId)
     * и идентификатор действия (getMessages) для облегчения обработки на сервере
     * получаем json строку с массивом сообщений, id которых больше отправленного,
     * и id последнего сообщения в БД
     * добавляем новые сообщения на страницу,
     * сохраняем текущий id в messageId
     *
     */
    function getMessages() {
        var data = {func: "getMessages",
            messageId: messageId};
        sendData(data, function (data) {
            var newData = JSON.parse(data);
            var messages = newData.data;
            for (var i = 0; i < messages.length; i++) {
                var newMessage = $("<div>");
                newMessage.html("<b>" + escapeHTML(messages[i].nick) + ":</b> " + escapeHTML(messages[i].text));
                $("#messageLog").prepend(newMessage);
            }
            messageId = +newData.nextMessageId;
        });
    }
    /**
     * отправка нового сообщения на сервер
     * передаем json с ником и сообщением через функцию sendData,
     * и идентификатор действия (addMessage) для облегчения обработки на сервере
     * после чего вызывается функция getMessages
     *
     */
    $("#sendButton").click(function () {
        var data = {func: "addMessage",
            nick: $("#nick").val(),
            text: $("#text").val()};
        sendData(data, function (data) {
            getMessages();
        });
        $("#text").val("");
    });

    //опрос сервера на новые сообщения каждые 2 секунды
    setInterval(getMessages, 2000);

});
