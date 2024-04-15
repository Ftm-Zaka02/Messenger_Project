const signupBtn = document.getElementById("signupBtn");
const signinBtn = document.getElementById("signinBtn");
const container = document.getElementById("container");
const mainDiv = document.getElementById("mainDiv");
const SignInButton = document.getElementById("SignInButton");
const SignUpButton = document.getElementById("SignUpButton");

SignUpButton.addEventListener("click",()=>{
    container.classList.add("right-panel-active");
})

SignInButton.addEventListener("click", () =>
    container.classList.remove("right-panel-active")
);


const ValidationSignup = () => {
    let ErrorMessageS = document.getElementById("ErrorMessageSignup");
    const phone = document.forms["Signup"]["phone"].value;
    const password = document.forms["Signup"]["password"].value;
    const repassword = document.forms["Signup"]["repassword"].value;

    const validationPhone = () => {
        let valid = false;
        if (phone.length === 11 && phone.startsWith("09")) {
            valid = true;
        } else {
            valid = false;
        }
        return valid;
    };

    const validationPasswordLength = () => {
        let valid = false;
        if (password.length >= 8 && repassword.length >= 8) {
            valid = true;
        } else {
            valid = false;
        }
        return valid;
    };

    const validationPassword = () => {
        let valid = false;
        if (password === repassword) {
            valid = true;
        } else {
            valid = false;
        }
        return valid;
    };

    const validationFilde = () => {
        let valid = false;
        if (phone === "" && password === "" && repassword === "") {
            valid = false;
        } else if (phone !== "" && password !== "" && repassword !== "") {
            valid = true;
        }
        return valid;
    };

    const Phone = validationPhone();
    const PasswordLength = validationPasswordLength();
    const Password = validationPassword();
    const Filde = validationFilde();

    if (Phone === false) {
        ErrorMessageS.textContent = "شماره موبایل را به درستی وارد کنید!!";
    }

    if (PasswordLength === false) {
        ErrorMessageS.textContent = "تعداد ارقام های پسورد باید 8 رقم باشد";
    }

    if (Password === false) {
        ErrorMessageS.textContent = "پسورد و تکرار ان با یک دیگر مطابقت ندارند!!";
    }

    if (Filde === false) {
        ErrorMessageS.textContent = "لطفا فیلد را پرکنید!!";
    }

    if (
        Phone === false &&
        PasswordLength === false &&
        Password === false &&
        Filde === false
    ) {
        signupBtn.disabled = true;
        signupBtn.setAttribute("class", "submit_disabled");
    } else if (
        Phone !== false &&
        PasswordLength !== false &&
        Password !== false &&
        Filde !== false
    ) {
        ErrorMessageS.textContent = "";
        signupBtn.disabled = false;
        signupBtn.setAttribute("class", "submit");
    }
};

const ValidationSignin = () => {
    let ErrorMessageL = document.getElementById("ErrorMessageSignin");
    const phone = document.forms["Signin"]["phone"].value;
    const password = document.forms["Signin"]["password"].value;

    const validationPhone = () => {
        let valid = false;
        if (phone.length === 11 && phone.startsWith("09")) {
            valid = true;
        } else {
            valid = false;
        }
        return valid;
    };

    const validationPasswordLength = () => {
        let valid = false;
        if (password.length >= 8) {
            valid = true;
        } else {
            valid = false;
        }
        return valid;
    };

    // const validationPassword = () => {
    //     let valid = false
    //     if (password === repassword) {
    //         valid = true
    //     } else {
    //         valid = false
    //     }
    //     return valid
    // }

    const validationFilde = () => {
        let valid = false;
        if (phone === "" && password === "") {
            valid = false;
        } else if (phone !== "" && password !== "") {
            valid = true;
        }
        return valid;
    };

    const Phone = validationPhone();
    const PasswordLength = validationPasswordLength();
    // const Password = validationPassword()
    const Filde = validationFilde();
    if (Phone === false) {
        ErrorMessageL.textContent = "شماره موبایل را به درستی وارد کنید!!";
    }

    if (PasswordLength === false) {
        ErrorMessageL.textContent = "تعداد ارقام های پسورد باید 8 رقم باشد";
    }

    if (Filde === false) {
        ErrorMessageL.textContent = "لطفا فیلد را پرکنید!!";
    }
    if (Phone === false && PasswordLength === false && Filde === false) {
        signinBtn.disabled = true;
        signinBtn.setAttribute("class", "submit-disabled");
    } else if (Phone !== false && PasswordLength !== false && Filde !== false) {
        ErrorMessageL.textContent = "";
        signinBtn.disabled = false;
        signinBtn.setAttribute("class", "submit");
    }
};

// const SubmitForm=()=>{
//     document.getElementById("Signup").submit();
// }
mainDiv.addEventListener("keydown", ValidationSignin)
mainDiv.addEventListener("change", ValidationSignin)

// $("#SigninForm").submit(function (event) {
//     event.preventDefault();
//     var values = $(this).serialize();
//     $.ajax({
//         type: "post",
//         url: "login",
//         data: values,
//         success: function () {
//         },
//     });
// })

$("#SignupForm").submit(function (event) {
    event.preventDefault();
    var values = $(this).serialize();
    $.ajax({
        type: "post",
        url: "signup",
        data: values,
        success: function () {
            createPopupBox('ثبت نام با موفقیت انجام شد')
            document.getElementById("SignupForm").reset();
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

function createPopupBox(text){
    dialogBody=document.getElementById("dialogBody");
    let box = document.createElement("section");
    box.style.zIndex="100"
    box.style.display="block"
    box.classList.add("section-Contact");
    box.id = "popup";
    let submitBtn = document.createElement("button");
    box.textContent = text;
    submitBtn.classList.add("submit-add");
    submitBtn.textContent = "تایید";
    submitBtn.addEventListener("click", () => {
        dialogBody.removeChild(box);
    });
    box.appendChild(submitBtn);
    dialogBody.appendChild(box);
}

function showError(error){
    createPopupBox(error)
}
