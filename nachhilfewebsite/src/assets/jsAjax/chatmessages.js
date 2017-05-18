var deleteOldestMessage = function () {
    var element = $(".chat-messages");
    var message = $(".small-8")[0];
    message.remove();
    while (element.children()[0].className == element.children[1].className) {
        element.children[0].remove();
    }
};
var addNewMessage = function (message, date, id, isMe = true) {
    var element = $(".chat-messages");
    if (isMe) {
        element.append(`
    <div class='columns small-8 float-left'>
        <div class='data-label success round'>
        <input type='hidden' name='chatNachrichtID' value='` + id + `'>
        <p class='message-content'>` + date + `</p>
        <p class='message-content'>` + message + `</p>
    </div>
    </div>
    `);
    }
    else {
        element.append(`
    <div class='columns small-8 float-right'>
        <div class='data-label round'>
        <input type='hidden' name='chatNachrichtID' value='` + id + `'>
        <p class='message-content'>` + date + `</p>
        <p class='message-content'>` + message + `</p>
    </div>
    </div>
    `);
    }
};


var oldestDate = null;
var checkOldestDate = function (date) {
    if (oldestDate == null) {
        var elements = $("[name=oldest]");
        if (elements.length > 0) {
            oldestDate = $(elements[elements.length - 1]).text();
        }
    }
    if (oldestDate == null || date != oldestDate) {
        var element = $(".chat-messages");
        element.append(`<div class='row'><div class='columns small-offset-4 small-4 text-center'>
                        <div class='secondary data-label radius text-center'>
                        <p name="oldest" style='font-size: 75%' class='message-content text-center'>` + date + `</p>
                        </div>
                        </div></div><br>
                        `);
        oldestDate = date;
    }
};

var sendMessageFormHelper = new AjaxFormHelper($("#send-message-form"), "Senden fehlgeschlagen!", "ajax/sendMessage.php", function (result) {
    var currentdate = new Date();
    var day = currentdate.getDate();
    if(day < 10){
        day = "0"+day;
    }
    var month = currentdate.getMonth()+1;
    if(month < 10){
        month = "0"+month;
    }
    var date = day + "."
        + month + "."
        + currentdate.getFullYear();
    var hours = currentdate.getHours();
    if(hours < 10){
        hours = "0"+hours;
    }
    var minutes = currentdate.getMinutes();
    if(minutes < 10){
        minutes = "0"+minutes;
    }
    var time = hours + ":"
        + minutes + ":";
    checkOldestDate(date);
    var message = $("#message");
    addNewMessage(message.val(), time, result.id, true);
    message.val('');
    window.scrollTo(0, document.body.scrollHeight);
    toastr.success("Senden erfolgreich!");
});

var listen = function () {
    var elements = $("[name=chatNachrichtID]");
    var element = null;
    if (isNodeList(elements)) {
        element = elements[elements.length - 1];
    }
    else {
        element = elements;
    }
    var latest_id;
    if (element != null) {
        latest_id = $(element).val();
    }
    else {
        latest_id = 0;
    }
    runMyAjax("ajax/Getters/getNewestMessage.php", function (result) {
        runMyAjax("ajax/Getters/getLoggedInUser.php", function (results) {
            if (result.hasMessage) {
                if (result.hasMultiple == false) {
                    checkOldestDate(result.date);
                    if (results.id != result.sender) {
                        addNewMessage(result.message, result.zeit, result.id, false);
                    }
                }
                else {
                    result.messages.forEach(function (message) {
                        checkOldestDate(message['date']);
                        if (results.id != message['sender']) {
                            addNewMessage(message['message'], message['zeit'], message['id'], false);
                        }
                    })
                }
            }
        });
    }, {'sender': $("#reciever").val(), 'latest-id': latest_id})
};
$(document).ready(function (ev) {
    setInterval(listen, 2000);
});

/*
 $(document).on("click", "#reloadButton", function(ev){
 ev.preventDefault();
 runMyAjax("ajax/Getters/getMessages.php", function(result){
 runMyAjax("ajax/Getters/getLoggedInUser.php", function(results){
 var element = $(".chat-messages");
 element.empty();
 var oldestDate = null;
 result.messages.forEach(function(message){
 checkOldestDate(message.date);
 if(message.idEmpfänger == results.id){
 addNewMessage(message.inhalt, message.zeit, true);
 }
 else{
 addNewMessage(message.inhalt, message.zeit, false);
 }
 });
 });
 }, {'sender': $("#sender").val(), 'reciever': $("#reciever").val()})
 });
 */



