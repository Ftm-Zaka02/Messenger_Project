let wavesurfer;
let mediaRecorder, chunks = [], audioURL = "";
const footer = document.getElementById("footer");
const chatlist = document.getElementById("chatlist");
const emojiIcon = document.getElementById("emojiIcon");
const timerVoice = document.getElementById("timerVoice");
const dialogSection = document.getElementById("dialog");
const rootElement = document.getElementById("emojiMain");
const dialog = document.getElementById("dialog__message");
const footerVoice = document.getElementById("footerVoice");
const dialogIcon = document.getElementById("dialog__icon");
const ContactlistSection = document.getElementById("Contacts");
const footerChannels = document.getElementById("footerChannels");
const dialogIconattach = document.getElementById("dialog__attach");
const Contacts = chatlist.getElementsByClassName("chatlist__cadre");
let searchInput = document.getElementById('search_input')
let searchBox = document.getElementById('searchBox')


let activeChatlist;
let Messenger = document.getElementById("Messenger");

const ChatList = function () {
    let ClosedChatList = () => {
        chatlist.classList.remove("chatlist", "chatlist__Open");
        chatlist.classList.add("chatlist", "chatlist__Closed");
    };

    let OpenChatList = () => {
        chatlist.classList.remove("chatlist", "chatlist__Closed");
        chatlist.classList.add("chatlist", "chatlist__Open");
    };

    if (chatlist.classList[1] === "chatlist__Open") {
        ClosedChatList();
    } else {
        OpenChatList();
    }
};

const foldersISactive = function (chatType) {
    const active = document.getElementsByClassName("folders--is--active");
    active[0].classList.remove("folders--is--active");

    switch (chatType) {
        case "all":
            const activeAll = document.getElementsByClassName("folders__allchat");
            activeAll[0].classList.add("folders--is--active");
            for (let i = 0; i < Contacts.length; i++) {
                Contacts[i].style = "display: flex;";
            }

            break;
        case "pv":
            const activePv = document.getElementsByClassName("folders__pv");
            activePv[0].classList.add("folders--is--active");
            for (let i = 0; i < Contacts.length; i++) {
                ContactlistSection.appendChild(Contacts[i]);
            }
            let datePv;
            for (let i = 0; i < Contacts.length; i++) {
                datePv = Contacts[i].querySelector("span[date='pv']");
                if (datePv !== null) {
                    Contacts[i].style = "display: flex;";
                } else if (datePv === null) {
                    Contacts[i].style = "display: none;";
                }
            }

            break;
        case "group":
            const activeGroup = document.getElementsByClassName("folders__group");
            activeGroup[0].classList.add("folders--is--active");
            for (let i = 0; i < Contacts.length; i++) {
                ContactlistSection.appendChild(Contacts[i]);
            }
            let dateGroup;
            for (let i = 0; i < Contacts.length; i++) {
                dateGroup = Contacts[i].querySelector("span[date='group']");
                if (dateGroup !== null) {
                    Contacts[i].style = "display: flex;";
                } else if (dateGroup === null) {
                    Contacts[i].style = "display: none;";
                }
            }

            break;
        case "channel":
            const activeChannel = document.getElementsByClassName("folders__channel");
            activeChannel[0].classList.add("folders--is--active");
            for (let i = 0; i < Contacts.length; i++) {
                ContactlistSection.appendChild(Contacts[i]);
            }
            let dateChannel;
            for (let i = 0; i < Contacts.length; i++) {
                dateChannel = Contacts[i].querySelector("span[date='channel']");
                if (dateChannel !== null) {
                    Contacts[i].style = "display: flex;";
                } else if (dateChannel === null) {
                    Contacts[i].style = "display: none;";
                }
            }

            break;
        case "setting":
            const activeSetting = document.getElementsByClassName("folders__setting");
            activeSetting[0].classList.add("folders--is--active");

            let sectionAddContact = document.getElementById("messengerSettings");
            sectionAddContact.style = "display: block;";

            let Messenger = document.getElementById("messenger");
            Messenger.setAttribute("style", "display:none;");

            break;
    }
};

// const CreateFooterBox = () => {
//   let dialogAttach = document.createElement("div");
//   dialogAttach.setAttribute("id", "dialog__attach");
//   dialogAttach.classList.add("dialog__attach", "dialog__attach--file");
//   let inputFile = document.createElement("input");
//   inputFile.setAttribute("type", "file");
//   inputFile.setAttribute("name", "dialog__input--attach");
//   inputFile.setAttribute("id", "dialog__input--attach");
//   inputFile.setAttribute("class", "dialog__attach--input");
//   let spanIcon = document.createElement("span");
//   spanIcon.setAttribute("id", "dialog__icon");
//   spanIcon.setAttribute("class", "dialog__voice");
//   spanIcon.addEventListener("click", sendMesseg());
//   dialogAttach.appendChild(inputFile);
//   dialogAttach.appendChild(spanIcon);

//   let dialogMessage = document.createElement("div");
//   dialogMessage.setAttribute("class", "dialog__message");
//   dialogMessage.addEventListener("change", IconChanger());
//   let dialogMessageInput = document.createElement("textarea");
//   dialogMessageInput.setAttribute("name", "dialog__message");
//   dialogMessageInput.setAttribute("id", "dialog__message");
//   dialogMessageInput.setAttribute("class", "dialog__message--input");
//   dialogMessageInput.setAttribute("placeholder", "message...");
//   dialogMessage.appendChild(dialogMessageInput);

//   let dialogTools = document.createElement("div");
//   dialogTools.setAttribute("class", "dialog__tools");
//   let spanEmoji = document.createElement("span");
//   spanEmoji.setAttribute("class", "dialog__emoji");
//   dialogTools.appendChild(spanEmoji);

//   footer.appendChild(dialogAttach);
//   footer.appendChild(dialogMessage);
//   footer.appendChild(dialogTools);
// };
function createContactObject(info) {
    let name = info.name
    let firstName = name.split(" ")[0]
    let lastName = name.split(" ")[1]
    let contact = {
        "id": info.id,
        "nationalCode": "",
        "fName": firstName,
        "lName": lastName,
        "phone": info.phone,
        "fullNname": info.name,
        "userName": "",
        "profile": "../../resources/messenger/image/user.png",
        "chatType": "pv",
        "sender": "you",
        "lastMessage": "bye",
        "date": "12:00 ب.ط",
        "numberMessages": "10",
        "messageSendingStatus": ""
    }
    return contact;
}

const CreateContactBox = (object) => {
    let chatlistCard = document.createElement("div");
    chatlistCard.setAttribute('data-id', object.id)
    chatlistCard.classList.add("chatlist__cadre");
    chatlistCard.addEventListener("contextmenu", (e) => {
        e.preventDefault();
        const sectionTools = createContanctMenu(chatlistCard);
        chatlistCard.appendChild(sectionTools);
    });
    chatlistCard.addEventListener("click", () => {
        let chatlistisActive = document.getElementsByClassName("chatlist--is--active");
        let nameDialog = document.getElementById("dialog__name");
        activeChatlist = chatlistName.textContent;
        nameDialog.textContent = chatlistName.textContent;
        dialogSection.setAttribute("style", "display:block;");
        fetch("resources/messenger/js/jsonFiles/ChatList.json")
            .then(function (response) {
                return response.json();
            })
            .then(function (Contacts) {
                for (let i = 0; i < Contacts.length; i++) {
                    if (Contacts[i].Name === nameDialog.textContent) {
                        let dialogBody = document.getElementById("dialogBody");
                        let subChannel = document.getElementsByClassName("dialog__status");
                        let channels = chatlistCard.getElementsByClassName("chatlist__name--channel");
                        let group = chatlistCard.getElementsByClassName("chatlist__name--channel");
                        if (group.length > 0) {
                            subChannel[0].classList.add("dialog__header-right--channel");
                            footerChannels.style = "display: none;";
                            footer.style = "display:flex;";
                        } else {
                            subChannel[0].classList.remove("dialog__header-right--channel");
                            footerChannels.style = "display: none;";
                            footer.style = "display:flex;";
                        }
                        if (channels.length > 0) {
                            subChannel[0].classList.add("dialog__header-right--channel");
                            footerChannels.style = "display: block;";
                            footer.style = "display: none;";
                        } else {
                            footerChannels.style = "display: none;";
                            footer.style = "display: flex;";
                            subChannel[0].classList.remove("dialog__header-right--channel");
                        }
                        dialogBody.innerHTML = "";
                        for (let j = 0; j < Contacts[i].chatlist.length; j++) {
                            sendMesseg(Contacts[i].chatlist[j].text, "text", Contacts[i].chatlist[j].type);
                        }
                    }
                }
            });

        if (chatlistisActive.length >= 1) {
            chatlistisActive[0].classList.remove("chatlist--is--active");
        }

        chatlistCard.classList.add("chatlist--is--active");
    });

    let chatlistPhoto = document.createElement("div");
    chatlistPhoto.classList.add("chatlist__photo");

    let chatlistImg = document.createElement("img");
    chatlistImg.classList.add("chatlist__img");

    let chatlistInfo = document.createElement("div");
    chatlistInfo.classList.add("chatlist__info");

    let chatlistDetails = document.createElement("div");
    chatlistDetails.classList.add("chatlist__details");
    let chatlistName = document.createElement("span");
    chatlistName.classList.add("chatlist__name");
    let chatlistDate = document.createElement("span");
    chatlistDate.classList.add("chatlist__date");

    let chatlistMore = document.createElement("div");
    chatlistMore.classList.add("chatlist__more");
    let chatlistSender = document.createElement("span");
    chatlistSender.classList.add("chatlist__sender");
    let chatlistMessage = document.createElement("p");
    chatlistMessage.classList.add("chatlist__message");

    if (object.profile === undefined) {
        chatlistImg.src = "../../resources/messenger/image/user.png";
    } else if (object.profile !== "") {
        chatlistImg.src = object.profile;
    }

    chatlistName.textContent = object.fullNname;

    if (object.date === undefined) {
        chatlistDate.textContent = "";
    } else if (object.date !== "") {
        chatlistDate.textContent = object.date;
    }

    if (object.sender === undefined) {
        chatlistSender.textContent = "";
    } else if (object.sender !== "") {
        chatlistSender.textContent = `${object.sender} : `;
    }

    if (object.lastMessage === undefined) {
        chatlistMessage.textContent = "";
    } else if (object.lastMessage !== "") {
        chatlistMessage.textContent = object.lastMessage;
    }

    if (object.chatType === "group") {
        chatlistName.classList.add("chatlist__name--group");
        chatlistName.setAttribute("date", "group");
    } else if (object.chatType === "channel") {
        chatlistName.setAttribute("date", "channel");
        chatlistName.classList.add("chatlist__name--channel");
    } else if (object.chatType === "pv") {
        chatlistName.setAttribute("date", "pv");
    }

    chatlistPhoto.appendChild(chatlistImg);
    chatlistCard.appendChild(chatlistPhoto);
    chatlistDetails.appendChild(chatlistName);
    chatlistDetails.appendChild(chatlistDate);
    chatlistInfo.appendChild(chatlistDetails);
    chatlistMore.appendChild(chatlistSender);
    chatlistMore.appendChild(chatlistMessage);
    if (object.numberMessages !== "" && object.numberMessages !== undefined) {
        let chatlistBadge = document.createElement("span");
        chatlistBadge.classList.add("chatlist__badge");
        chatlistBadge.textContent = object.numberMessages;
        chatlistMore.appendChild(chatlistBadge);
    }
    chatlistInfo.appendChild(chatlistMore);
    chatlistCard.appendChild(chatlistInfo);
    ContactlistSection.appendChild(chatlistCard);
};


const refreshChatlist = function () {
    if (Contacts.length > 0) {
        ContactlistSection.innerHTML = "";
    }

    fetch("resources/messenger/js/jsonFiles/Contacts.json")
        .then(function (response) {
            return response.json();
        })
        .then(function (Contacts) {
            for (let i = 0; i < Contacts.length; i++) {
                CreateContactBox(Contacts[i]);
            }
        });
};

const IconChanger = function () {
    if (dialog.value.length > 0 && dialog.value !== "") {
        dialogIcon.setAttribute("class", "dialog__send");
        dialogIconattach.classList.remove("dialog__attach--file");
    } else {
        dialogIcon.setAttribute("class", "dialog__voice");
        dialogIconattach.classList.add("dialog__attach--file");
    }
};

const sendMesseg = (dialogg = dialog.value, type = "text", sender = 0, dataId, send_time) => {
    let dialogBody = document.getElementById("dialogBody");
    let messageSelf = document.createElement("div");
    let messageCard = document.createElement("div");

    if (sender === 1) {
        messageCard.classList.remove("message__card", "message__card--self");
        messageSelf.classList.remove("message", "message__self");

        messageSelf.classList.add("message", "message__other");
        messageCard.classList.add("message__card", "message__card--other");
    } else if (sender === 0) {
        messageSelf.classList.remove("message", "message__other");
        messageCard.classList.remove("message__card", "message__card--other");

        messageCard.classList.add("message__card", "message__card--self");
        messageSelf.classList.add("message", "message__self");
    }

    dialogBody.appendChild(messageSelf);

    let messagePhoto = document.createElement("div");
    messagePhoto.setAttribute("class", "message__photo");

    let messageImg = document.createElement("img");
    messageImg.src = "../../resources/messenger/image/user.png";
    messageImg.setAttribute("class", "message__img");

    messagePhoto.appendChild(messageImg);
    messageSelf.appendChild(messagePhoto);

    if (type === "voice") {
        let messageVoice = document.createElement("div");
        messageVoice.setAttribute("class", "dialog__message--voice");

        let messageVoiceControl = document.createElement("div");
        messageVoiceControl.setAttribute("class", "dialog__message--voice-control");
        let messageVoiceControlBtn = document.createElement("button");
        messageVoiceControlBtn.setAttribute("class", "dialog__message--playe");
        messageVoiceControlBtn.addEventListener("click", (startPlayingVoice = () => {
            messageVoiceControlBtn.style = "transition: all 2s;";
            wavesurfer.playPause();

            if (messageVoiceControlBtn.classList[0] === "dialog__message--pause") {
                messageVoiceControlBtn.setAttribute("class", "dialog__message--playe");
            } else {
                messageVoiceControlBtn.setAttribute("class", "dialog__message--pause");
            }

            wavesurfer.once("finsh", () => {
                wavesurfer.stop();
            });
        }));
        messageVoiceControl.appendChild(messageVoiceControlBtn);

        let messageVoiceWave = document.createElement("div");
        messageVoiceWave.setAttribute("class", "dialog__message--voice-Wave");
        let messageVoiceWaveForm = document.createElement("div");
        messageVoiceWaveForm.setAttribute("class", "dialog__message--play");
        messageVoiceWaveForm.id = "waveform";
        messageVoiceWave.appendChild(messageVoiceWaveForm);

        messageVoice.appendChild(messageVoiceControl);
        messageVoice.appendChild(messageVoiceWave);
        messageCard.appendChild(messageVoice);
    } else if (type === "text") {
        let messageText = document.createElement("span");
        let messageSendTime = document.createElement("span");
        messageSendTime.textContent = send_time;
        messageSendTime.setAttribute("class", "message__sendTime");
        messageText.setAttribute("class", "message__text");
        messageSelf.setAttribute("data-id", dataId);
        messageText.textContent = dialogg;
        messageCard.appendChild(messageText);
        messageCard.appendChild(messageSendTime);
        messageSelf.addEventListener("contextmenu", (e) => {
            e.preventDefault();
            const sectionTools = createMessageMenu(messageSelf);
            messageCard.appendChild(sectionTools);
        });
        dialog.value = null;
    } else if (type == "file") {
        let file = document.createElement("img");
        file.setAttribute("class", "message__image");
        messageSelf.setAttribute("data-id", dataId);
        file.src = dialogg;
        messageCard.appendChild(file);
        messageSelf.addEventListener("contextmenu", (e) => {
            e.preventDefault();
            const sectionTools = createMessageMenu(messageSelf);
            messageCard.appendChild(sectionTools);
        });
    }
    messageSelf.appendChild(messageCard);
};
const EmojiIconActiv = () => {
    const {createPicker} = window.picmo;

    const EmojiActiv = () => {
        emojiIcon.classList.remove("dialog__emoji");
        emojiIcon.classList.add("dialog__Keyboard", "dialog__emoji--activ");
        rootElement.style = "display:block;";
        const picker = createPicker({
            rootElement,
        });
        picker.addEventListener("emoji:select", (selection) => {
            dialog.value += selection.emoji;
        });
    };
    const EmojiInactiv = () => {
        emojiIcon.classList.add("dialog__emoji");
        emojiIcon.classList.remove("dialog__Keyboard", "dialog__emoji--activ");
        rootElement.style = "display:none;";
    };
    if (emojiIcon.classList[1] === "dialog__emoji--activ") {
        EmojiInactiv();
    } else if (emojiIcon.classList[1] !== "dialog__emoji--activ") {
        EmojiActiv();
    }
};

dialog.addEventListener("mousedown", () => {
    rootElement.style = "display:none;";
});

function timer() {
    let seconds = 0;
    let minutes = 0;
    let startTime = 0;
    setInterval(() => {
        let currentTime = Date.now();
        let elapsedTime = currentTime - startTime;
        if (elapsedTime >= 1000) {
            if (seconds >= 60) {
                minutes += 1;
                seconds = 0;
            } else {
                seconds += 1;
            }
            timerVoice.textContent = minutes + ":" + seconds;
            startTime = Date.now();
        }
    }, 1);
}

function stopTimer() {
    mediaRecorder.stop();
    clearInterval(timer);
}

if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    navigator.mediaDevices
        .getUserMedia({
            audio: true,
        })
        .then((stream) => {
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = (e) => {
                chunks.push(e.data);
            };

            mediaRecorder.onstop = () => {
                const blob = new Blob(chunks, {type: "audio/ogg; codecs=opus"});
                chunks = [];
                audioURL = window.URL.createObjectURL(blob);
                // document.querySelector('audio').src = audioURL
            };
        })
        .catch((error) => {
            alert(`Following error has occured : \n ${error}`);
        });
}
// ضبط شروع شود
const record = () => {
    timer();
    mediaRecorder.start();
    footerVoice.style = "display:block;";
};
// توقف ضبط
const stopRecording = () => {
    stopTimer();
    mediaRecorder.stop();
    footerVoice.style = "display:none;";
    if (audioURL !== "") {
        sendMesseg("", "voice", 0);
        const messageVoiceWaveF = document.querySelectorAll(".dialog__message--play");
        wavesurfer = WaveSurfer.create({
            container: messageVoiceWaveF[messageVoiceWaveF.length - 1],
            waveColor: "#3f3f49",
            progressColor: "#1e212a",
            cursorWidth: 2,
            barWidth: 1,
            barHeight: 20,
            barGap: 1,
            responsive: true,
            height: 25,
            barRadius: 30,
            url: audioURL,
        });
    } else {
        alert("دوباره ضبط کنید صدا ضبط نشده!!");
    }
};

//! insert data into database

$(document).ready(function () {
    $("#send_form").submit(function (event) {
        event.preventDefault();
        var values = $(this).serialize();
        $.ajax({
            type: "post",
            url: "messages/set",
            data: values + "&activeChatList=" + activeChatlist,
            success: function () {
                dialog.value = null;
            },
            error: function (error) {
                const errors = error.responseJSON.errors
                for (const errorKey in errors) {
                    errors[errorKey].forEach((error) => {
                        createPopupBox(error)
                    });
                }
            }
        });
    });
});

dialog.addEventListener("keydown", (event) => {
    if (event.key === "Enter") {
        $("#send_form").submit();
    }
});

//! delete data from database
function createDeletePopup(text, deleteType) {
    let box = document.createElement("section");
    box.id = "popup";
    let submitBtn = document.createElement("button");
    let closeBtn = document.createElement("button");
    box.textContent = text;
    closeBtn.classList.add("close-btn");
    submitBtn.classList.add("submit-add");
    submitBtn.textContent = "تایید";
    closeBtn.addEventListener("click", () => {
        dialogBody.removeChild(box);
    });
    if (deleteType == "single") {
        let div = document.createElement("div");
        let checkBox = document.createElement("input");
        checkBox.id = "deletCheckbox";
        let lbl = document.createElement("label");
        lbl.style.fontFamily = "shabnam";
        lbl.textContent = " حذف برای گیرنده";
        checkBox.setAttribute("type", "checkbox");
        checkBox.setAttribute("checked", "checked");
        div.style.marginTop = "35px";
        div.appendChild(checkBox);
        div.appendChild(lbl);
        box.appendChild(div);
    }
    box.appendChild(submitBtn);
    box.appendChild(closeBtn);
    box.classList.add("section-Contact");
    box.style.display = 'block'
    dialogBody.appendChild(box);
    return submitBtn;
}

function deleteMessageBox(messageBox) {
    let dataID = messageBox.getAttribute("data-id");
    let deleteType;
    let deletCheckbox = document.getElementById("deletCheckbox");
    if (deletCheckbox.checked == true) {
        deleteType = "physicalDelete";
    } else {
        deleteType = "softDelete";
    }
    $.ajax({
        type: "get",
        url: "messages/delete",
        dataType: "json",
        data: {dataID: dataID, deleteType: deleteType},
        success: function () {
            messageBox.remove();
            $("#popup").remove();
        },
        error: function (error) {
            const errors = error.responseJSON.errors
            for (const errorKey in errors) {
                errors[errorKey].forEach((error) => {
                    createPopupBox(error)
                });
            }
        }
    });
}

$("#deleteChat").click(() => {
    let submitBtn = createDeletePopup("آیا نسبت به حذف تاریخچه مطمئن هستید؟", "integrated");

    function deleteChatHistory() {
        $.ajax({
            type: "get",
            url: "messages/delete",
            dataType: "json",
            data: {chatListName: activeChatlist, deleteType: "integrated"},
            success: function (res) {
                let messages = document.getElementsByClassName("message");
                let len = messages.length - 1;
                for (let i = len; i >= 0; i--) {
                    let smg = messages[i];
                    smg.remove();
                }
            },
            error: function (error) {
                const errors = error.responseJSON.errors
                for (const errorKey in errors) {
                    errors[errorKey].forEach((error) => {
                        createPopupBox(error)
                    });
                }
            }
        });
        $("#popup").remove();
    }

    submitBtn.addEventListener("click", deleteChatHistory);
});

//! update data from database

function updateMessage(messageBox) {
    let span = messageBox.children[1].children[0];
    let dataID = messageBox.getAttribute("data-id");
    dialog.value = span.textContent;
    dialog.focus();
    const sendBtn = document
        .getElementById("dialog__icon")
        .addEventListener("click", (e) => {
            e.preventDefault();
            let newMessage = dialog.value;
            $.ajax({
                type: "get",
                url: "messages/update",
                dataType: "json",
                data: {dataID: dataID, newMessage: newMessage},
                success: function (response) {
                    if (response["data"]) span.textContent = newMessage;
                    dialog.value = null;
                },
                error: function (error) {
                    const errors = error.responseJSON.errors
                    for (const errorKey in errors) {
                        errors[errorKey].forEach((error) => {
                            createPopupBox(error)
                        });
                    }
                }
            });
        });
}

//! create message menu

function createMessageMenu(messageBox) {
    let dataID = messageBox.getAttribute("data-id");
    const sectionTools = document.createElement("section");
    sectionTools.classList.add("section-tools");
    const closeBtn = document.createElement("button");
    closeBtn.classList.add("close-btn");
    sectionTools.appendChild(closeBtn);
    closeBtn.addEventListener("click", () => {
        sectionTools.style.display = "none";
    });
    const table = document.createElement("table");
    for (let i = 0; i < 6; i++) {
        let tr = document.createElement("tr");
        let td = document.createElement("td");
        switch (i) {
            case 0:
                td.id = "message__tools--delete";
                td.textContent = "حذف";
                td.addEventListener("click", () => {
                    if (dataID) {
                        let submitBtn = createDeletePopup("پیام حذف شود؟", "single");
                        submitBtn.addEventListener("click", () => {
                            deleteMessageBox(messageBox);
                        });
                    }
                    sectionTools.style.display = "none";
                });
                break;
            case 1:
                td.id = "message__tools--edit";
                td.textContent = "ویرایش";
                td.addEventListener("click", () => {
                    if (dataID) {
                        updateMessage(messageBox);
                    }
                    sectionTools.style.display = "none";
                });
                break;
            case 2:
                td.id = "message__tools--forward";
                td.textContent = "هدایت";
                break;
            case 3:
                td.id = "message__tools--response";
                td.textContent = "پاسخ";
                break;
            case 4:
                td.id = "message__tools--copy";
                td.textContent = "کپی";
                break;
            case 5:
                td.id = "message__tools--pin";
                td.textContent = "سنجاق";
                break;
        }
        tr.appendChild(td);
        table.appendChild(tr);
    }
    sectionTools.appendChild(table);
    return sectionTools;
}

//! fetch data from database

let page = 1;
let uploaded = 0;
const uploadMessage = async () => {
    await $.ajax({
        type: "get", url: "messages/get", dataType: "json", data: {page: page}, success: function (response) {
            data = response["data"]["data"];
            for (let i = uploaded; i < data.length; i++) {
                let {id, text_message, content_name, user_id, send_time, chat_name} = data[i];

                function getTime(send_time) {
                    const date = new Date(send_time * 1000);
                    const time = [date.getHours(), date.getMinutes()];
                    return time.join(":");
                }

                if (chat_name == activeChatlist) {
                    if (content_name) {
                        if (user_id == 191) {
                            sendMesseg(content_name, "file", 0, id, getTime(send_time));
                        } else {
                            sendMesseg(content_name, "file", 1, id, getTime(send_time));
                        }
                    } else if (text_message) {
                        if (user_id == 191) {
                            sendMesseg(text_message, "text", 0, id, getTime(send_time));
                        } else {
                            sendMesseg(text_message, "text", 1, id, getTime(send_time));
                        }
                    }
                } else {
                    continue;
                }
            }
            if (data.length != 5) {
                uploaded = data.length;
            } else {
                page += 1;
                uploaded = 0;
            }
        }, error: function (error) {
            const errors = error.responseJSON.errors
            for (const errorKey in errors) {
                errors[errorKey].forEach((error) => {
                    createPopupBox(error)
                });
            }
        }
    });
};
$("#dialog__refresh").click(() => {
    uploadMessage();
});

// $(document).ready(function () {
//     setInterval(() => {
//         uploadMessage();
//     }, 10000);
// });
$("#dialog__attach").click(() => {
    let fileUploadForm = document.getElementById('uploadFileForm')
    fileUploadForm.style = 'display:block;'
    $("#uploadFileForm").submit(function (event) {
        event.preventDefault();
        var file = document.getElementById('file').files[0];
        var formData = $('#uploadFileForm').serialize();
        formData += "&activeChatList=" + activeChatlist;
        var combinedData = new FormData();
        combinedData.append('fileToUpload', file);
        formData = decodeURIComponent(formData.replace(/\+/g, ' '));
        $.each(formData.split('&'), function (index, field) {
            var kv = field.split('=');
            combinedData.append(kv[0], kv[1]);
        });
        $.ajax({
            url: 'messages/uploadFile',
            type: 'POST',
            data: combinedData,
            processData: false,
            contentType: false,
            success: function () {
                $("#uploadFileForm").remove();
            },
            error: function (error) {
                const errors = error.responseJSON.errors
                for (const errorKey in errors) {
                    errors[errorKey].forEach((error) => {
                        createPopupBox(error)
                    });
                }
            }
        });
    })
})

function createPopupBox(text) {
    let box = document.createElement("section");
    box.classList.add("section-Contact");
    box.style.zIndex = "10";
    box.style.display = "block";
    box.id = "popup";
    let submitBtn = document.createElement("button");
    box.textContent = text;
    submitBtn.classList.add("submit-add");
    submitBtn.textContent = "تایید";
    submitBtn.addEventListener("click", () => {
        Messenger.removeChild(box);
    });
    box.appendChild(submitBtn);
    Messenger.appendChild(box);
}


////////////////////////////contacts part
const addContact = function () {
    let sectionAddContact = document.getElementById("addContact");
    sectionAddContact.style = "display: block;height: 340px;";
    let Messenger = document.getElementById("messenger");
    let closebtn = document.getElementById("closed");

    closebtn.addEventListener("click",()=>{
        sectionAddContact.style = "display: none;";
        Messenger.removeAttribute("style", "display:block;");
    })


};

function createContanctMenu(contactBox) {
    let dataID = contactBox.getAttribute("data-id");
    const sectionTools = document.createElement("section");
    sectionTools.classList.add("section-tools");
    sectionTools.classList.add("contact-section-tools");
    const closeBtn = document.createElement("button");
    closeBtn.classList.add("close-btn");
    sectionTools.appendChild(closeBtn);
    closeBtn.addEventListener("click", () => {
        sectionTools.style.display = "none";
    });
    const table = document.createElement("table");
    for (let i = 0; i < 2; i++) {
        let tr = document.createElement("tr");
        let td = document.createElement("td");
        switch (i) {
            case 0:
                td.id = "contact__tools--delete";
                td.textContent = "حذف";
                td.addEventListener("click", () => {
                    if (dataID) {
                        let submitBtn = createDeletePopup("مخاطب حذف شود؟");
                        submitBtn.addEventListener("click", () => {
                            deleteContact(contactBox);
                            submitBtn.parentNode.remove()
                        });
                    }
                    sectionTools.style.display = "none";
                });
                break;
            case 1:
                td.id = "contact__tools--edit";
                td.textContent = "ویرایش";
                td.addEventListener("click", () => {
                    if (dataID) {
                        updateContact(contactBox);
                    }
                    sectionTools.style.display = "none";
                });
                break;
        }
        tr.appendChild(td);
        table.appendChild(tr);
    }
    sectionTools.appendChild(table);
    return sectionTools;
}

//set contact
$("#form-contact").submit(function (event) {
    event.preventDefault();
    var values = $(this).serialize();
    $.ajax({
        type: "post",
        dataType:"json",
        url: "contacts/set",
        data: values,
        success: function (response) {
            let data=response['data']
            const contactObject = {
                firstName: data['name'], phone: data['phone'], fullNname: data['name'], chatType: "pv",
            };

            CreateContactBox(contactObject);
            document.forms["form-contact"]["phone-Contact"].value = null;
            document.forms["form-contact"]["name-Contact"].value = null;
            let contctSection=document.getElementById("addContact")
            contctSection.style.display="none";
        },
        error: function (error) {
            const errors = error.responseJSON.errors
            for (const errorKey in errors) {
                errors[errorKey].forEach((error) => {
                    createPopupBox(error)
                });
            }
        }
    });
})

//get
let uploadedContact=0;
$("#refreshIcon").click(() => {
    searchInput.value=""
    $.ajax({
        type: "get",
        url: "contacts/get",
        dataType: "json",
        success: function (response) {
            let Contacts = response['data'];
            for (let i = uploadedContact; i < Contacts.length; i++) {
                let contactInfo = createContactObject(Contacts[i]);
                CreateContactBox(contactInfo)
            }
            uploadedContact=Contacts.length
        },
        error: function (error) {
            const errors = error.responseJSON.errors
            for (const errorKey in errors) {
                errors[errorKey].forEach((error) => {
                    createPopupBox(error)
                });
            }
        }
    })
})

function deleteContact(contactBox) {
    let dataID = contactBox.getAttribute("data-id");
    $.ajax({
        type: "get",
        url: "contacts/delete",
        data: {dataID: dataID},
        success: function () {
        },
        error: function (error) {
            const errors = error.responseJSON.errors
            for (const errorKey in errors) {
                errors[errorKey].forEach((error) => {
                    createPopupBox(error)
                });
            }
        }
    })
}

function updateContact(contactBox) {
    let dataID = contactBox.getAttribute("data-id");
    let sectionEditContact = document.getElementById("editContact");
    sectionEditContact.style = "display: block;height: 340px;";
    let Messenger = document.getElementById("messenger");
    let editBtn = document.getElementById("editBtn");
    let closebtn = document.getElementById("closeBtn");
    closebtn.addEventListener("click", () => {
        sectionEditContact.style = "display: none;";
        Messenger.removeAttribute("style", "display:block;");
    })

    editBtn.addEventListener('click', (e) => {
        e.preventDefault()
        let values = $("#edit-form-contact").serialize();
        $.ajax({
            type: "post",
            url: "contacts/update",
            data: values + "&dataID=" + dataID,
            success: function (response) {
                sectionEditContact.style = "display: none;";
            },
            error: function (error) {
                const errors = error.responseJSON.errors
                for (const errorKey in errors) {
                    errors[errorKey].forEach((error) => {
                        createPopupBox(error)
                    });
                }
            }
        })
    })
}

searchBox.addEventListener('submit', (event) => {
    event.preventDefault();
    values = $("#searchBox").serialize()
    $.ajax({
        type: "post",
        dataType: "json",
        url: "contacts/search",
        data: values,
        success: function (response) {
            let data = response['data'];
            let ids=[]
            data.map((value)=>{
                ids.push(value['id'])
            })
            for (let contact of Contacts) {
                let dataID = Number(contact.getAttribute("data-id"))
                if (!ids.includes(dataID)) {
                    contact.style.display = "none"
                }
            }
        },
        error: function (error) {
            const errors = error.responseJSON.errors
            for (const errorKey in errors) {
                errors[errorKey].forEach((error) => {
                    createPopupBox(error)
                });
            }
        }
    })
})

