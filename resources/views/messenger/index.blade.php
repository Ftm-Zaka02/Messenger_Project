<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8"/>
    <title>Chat</title>
    <link href="{{ asset('resources/messenger/css/style/style_chat.css') }} " rel="stylesheet">
    <link href="{{ asset('resources/messenger/css/style/style_chat_folders.css') }} " rel="stylesheet">
    <link href="{{ asset('resources/messenger/css/style/style_chat_chatlist.css') }} " rel="stylesheet">
    <link href="{{ asset('resources/messenger/css/style/style_chat_dialog.css') }} " rel="stylesheet">
    <link href="{{ asset('resources/messenger/css/style/style_icons_and_fonts.css') }} " rel="stylesheet">
    <link href="{{ asset('resources/messenger/css/style/style_add_contacts.css') }} " rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>

<body onload="getUser()">
<section id="Messenger" class="Messenger">
    <div class="folders" id="folders">
        <span onclick="ChatList()" class="folders__menu menu"></span>
        <span onclick="foldersISactive('all')" class="folders__allchat folders--is--active" data-badge="+99">همه
                پیام ها</span>
        <span onclick="foldersISactive('group')" class="folders__group">گروه ها</span>
        <span onclick="foldersISactive('channel')" class="folders__channel">کانال ها</span>
        <span onclick="foldersISactive('pv')" class="folders__pv">گفتگو ها</span>
        <span onclick="foldersISactive('setting')" class="folders__setting">تنظیمات</span>
        <span class="folders__screenmode folders__light">حالت روشنایی</span>
    </div>

    <div id="chatlist" class="chatlist chatlist__Open">
        <div class="chatlist__icon--sticky">
            <div class="chatlist__icon">
                <span class="chatlist__title" id="messengerTitle">Messenger</span>
                <span onclick="createChat()" class="chatlist__addcontact"></span>
                <span id="refreshIcon" class="chatlist__refresh"></span>
            </div>
            <form class="search__box" id="searchBox">
                @csrf
                <input type="search" name="searchKey" id="search_input" class="search__input"
                       placeholder="search"/>
            </form>
        </div>

        <div id="Contacts"></div>
    </div>

    <div id="dialog" class="dialog" style="display: none">
        <div class="dialog__wrapper">
            <div class="dialog__header">
                <div class="dialog__header-right">
                    <img src="{{asset('resources/messenger/image/user.png')}}" alt="profile" class="message__img"/>
                    <div class="dialog__user">
                        <div id="dialog__name" class="dialog__name">name</div>
                        <span class="dialog__status" data-sub="1000Sub .">Online</span>
                    </div>
                </div>
                <div class="dialog__header-left">
                    <span class="dialog__deleteChat" id="deleteChat"></span>
                    <span class="dialog__showprofile dialog__header-left--is--active"></span>
                    <span class="dialog__edit"></span>
                    <span class="dialog__search"></span>
                    <button id="dialog__refresh" class="dialog__refresh"></button>
                    <!-- <span class="dialog__options"></span> -->
                </div>
            </div>

            <div id="dialogBody" class="dialog__body"></div>

            <div id="footerVoice" class="dialog__footer--voice" style="display: none">
                <div id="saveButton" onclick="stopRecording()" class="dialog__footer--voice-send dialog__send">
                </div>
                <div onclick="cancelRecording()" class="dialog__footer--voice-status">
                    لغو
                </div>
                <div id="timerVoice" class="dialog__footer--voice-timer">0:0</div>
            </div>

            <div class="emoji__main" id="emojiMain"></div>

            <form id="send_form" id="footer" class="dialog__footer" onkeyup="IconChanger()" onclick="IconChanger()">
                @csrf

                <div id="dialog__attach" class="dialog__attach dialog__attach--file"></div>

                <input type="file" name="dialog__input--attach" id="dialog__input--attach"
                       class="dialog__attach--input"/>
                <button id="dialog__icon" class="dialog__voice" type="submit"></button>
                <div class="dialog__message">
                        <textarea name="dialogMessage" id="dialog__message" class="dialog__message--input"
                                  placeholder="message..."></textarea>
                </div>
                <div class="dialog__tools">
                    <span onclick="EmojiIconActiv()" id="emojiIcon" class="dialog__emoji"></span>
                </div>
            </form>

            <div id="footerChannels" class="dialog__footer--channels" style="display: none">
                بی صدا
            </div>

            <form id="uploadFileForm" enctype="multipart/form-data" class="section-Contact">
                @csrf
                <input type="file" name='fileToUpload' id="file">
                <button id='uploadBtn' type="submit" class="submit-add">بارگذاری</button>
            </form>

        </div>
    </div>
</section>

<section id="createChat" class="section-Contact">
    <button id="createChatClose" class="close-btn"></button>
    <form>
        <h3 class="chatlist__title">افزودن گفت و گو</h3>
        <div class="main-input">
            <span class="chatlist__name--group"></span>
            <label class="create-chat-lbl">ایجاد گروه</label>
        </div>
        <div class="main-input">
            <span class="chatlist__name--channel"></span>
            <label class="create-chat-lbl">ایجاد کانال</label>
        </div>
        <div class="main-inpu" onclick="addContact()">
            <span class="chatlist__name--pv"></span>
            <label class="create-chat-lbl">ایجاد مخاطب</label>
        </div>
    </form>
</section>

<section id="addContact" class="section-Contact">
    <button id="addContactClose" class="close-btn"></button>
    <form name="form-contact" id="form-contact" method="post">
        @csrf
        <h3 class="chatlist__title">افزودن مخاطب</h3>
        <div class="main-input">
            <input class="input-add" type="tel" name="phone" id="phone-Contact" placeholder=" " autofocus/>
            <div class="cut"></div>
            <label for="phone-Contact" class="placeholder">شماره موبایل مخاطب</label>
        </div>
        <div class="main-input">
            <input class="input-add" type="text" name="name" id="name-Contact" placeholder=" "/>
            <div class="cut cut-long"></div>
            <label for="Contact" class="placeholder">نام مخاطب</label>
        </div>
        <button id="additionContact" type="submit" class="submit-add">افزودن مخاطب</button>
    </form>
</section>

<section id="editContact" class="section-Contact">
    <button id="closeBtn" class="close-btn"></button>
    <form name="edit-form-contact" id="edit-form-contact" method="post">
        @csrf
        <h3 class="chatlist__title">ویرایش مخاطب</h3>
        <div class="main-input">
            <input class="input-add" type="tel" name="firstName" id="phone-Contact" placeholder=" " autofocus/>
            <div class="cut"></div>
            <label for="firstName-Contact" class="placeholder"> نام مخاطب</label>
        </div>
        <div class="main-input">
            <input class="input-add" type="text" name="lastName" id="name-Contact" placeholder=" "/>
            <div class="cut cut-long"></div>
            <label for="lastName" class="placeholder">نام خانوادگی مخاطب</label>
        </div>
        <button id="editBtn" type="submit" class="submit-add">ویرایش مخاطب</button>
    </form>
</section>

<section id="messengerSettings" class="section-Contact" style="display: none">
    <button id="closed" class="close-btn"></button>
    <form name="form-contact" id="form-contact" method="post">
        <input id="submit" type="button" class="submit-add" value="ثبت تنطیمات"/>
    </form>
</section>

<script src="https://unpkg.com/picmo@latest/dist/umd/index.js"></script>
<script src="https://unpkg.com/wavesurfer.js@7"></script>
<script src="{{asset("resources/messenger/js/pageReaction.js")}}"></script>
</body>

</html>
