<!DOCTYPE html>
<html>
<head>
    <title>Sign In & Sign Up</title>
    <link href="{{ asset('resources/messenger/css/style/style_login.css') }} " rel="stylesheet">
    <link href="{{ asset('resources/messenger/css/style/style_icons_and_fonts.css') }} " rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>

<body>
<div class="container" id="container">
    <div
        onkeydown="ValidationSignup()"
        onchange="ValidationSignup()"
        class="form-main sign-up-container"
    >
        <form name="Signup" id="Signup" action="./index.blade.php" method="post">
            <h1>ساخت حساب کاربری</h1>
            <input
                class="input"
                type="tel"
                name="phone"
                id="phone"
                placeholder="شماره مویل"
                pattern="[0-9]{11}"
                required
            />
            <input
                class="input"
                type="password"
                name="password"
                id="password"
                placeholder="رمز عبور"
                minlength="8"
                required
            />
            <input
                class="input"
                type="password"
                name="repassword"
                id="repassword"
                placeholder="تکرار رمز عبور"
                minlength="8"
                required
            />
            <p id="ErrorMessageSignup" class="Error__Message"></p>
            <div class="input-checkbox">
                <label for="remember" class="ui-checkbox">
                    <input
                        type="checkbox"
                        id="remember"
                        class="ui-checkbox-input"
                        checked
                    />
                    <span class="ui-checkbox-mark"></span>
                    مرا بخاطر بسپار!
                </label>
            </div>
            <button type="submit" disabled id="signupBtn" class="submit-disabled">
                ثبت نام
            </button>
        </form>
    </div>
    <div id="mainDiv"
         class="form-main sign-in-container"
    >
        <form id="SigninForm" name="Signin" action="./index.blade.php" method="post">
            @csrf
            <h1>ورود به حساب</h1>
            <input
                class="input"
                type="tel"
                name="phone"
                id="phone"
                placeholder="شماره مویل"
                pattern="[0-9]{11}"
                required
            />
            <input
                class="input"
                type="password"
                name="password"
                id="password"
                placeholder="رمز عبور"
                minlength="8"
                required
            />
            <p id="ErrorMessageSignin" class="Error__Message"></p>
            <div class="input-checkbox">
                <label for="remember" class="ui-checkbox">
                    <input
                        type="checkbox"
                        id="remember"
                        class="ui-checkbox-input"
                        checked
                    />
                    <span class="ui-checkbox-mark"></span>
                    مرا بخاطر بسپار!
                </label>
            </div>
            <button type="submit" disabled id="signinBtn" class="submit-disabled">
                ورود
            </button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>خوش اومدی</h1>
                <p>برای استفاده از خدمات ما ابتدا باید وارد حسابت بشی!</p>
                <button class="submit" id="SignInButton">ورود</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>سلام دوست من</h1>
                <p>
                    اگر هنوز نمیدونی چطور از خدمات ما استفاده کنی، فقط کافیه ثبت نام
                    کنی!
                </p>
                <button class="submit" id="SignUpButton">ثبت نام</button>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{asset("resources/messenger/js/validationLogin.js")}}"></script>
</html>
