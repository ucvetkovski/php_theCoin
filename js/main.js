(function ($) {
    "use strict";

    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 40) {
            $('.navbar').addClass('sticky-top');
        } else {
            $('.navbar').removeClass('sticky-top');
        }
    });
    
    // Dropdown on mouse hover
    $(document).ready(function () {
        function toggleNavbarMethod() {
            if ($(window).width() > 992) {
                $('.navbar .dropdown').on('mouseover', function () {
                    $('.dropdown-toggle', this).trigger('click');
                }).on('mouseout', function () {
                    $('.dropdown-toggle', this).trigger('click').blur();
                });
            } else {
                $('.navbar .dropdown').off('mouseover').off('mouseout');
            }
        }
        toggleNavbarMethod();
        $(window).resize(toggleNavbarMethod);

                  if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showLocation);
    } else {
        };

        function showLocation() {
            let data;
            let weather;

            // let target = document.getElementById("weather");
            let targetLocation = document.getElementById("location");
        $.ajax({
            type: 'POST',
            url: 'models/getLocationData.php',
            success: function (msg) {
                if (msg) {
                    data = JSON.parse(msg);
                    let today = new Date;
                    let time= Math.ceil(today.getHours() + "." + today.getMinutes());
                    let day = today.getDate();
                        if (day < 10) {
                            day = '0' + day.toString();
                        }
                    let month = today.getDate();
                        if (month < 10) {
                            month = '0' + month.toString();
                        }
                    let date = today.getFullYear() + "-" + month + "-" + day;
                    let dateToShow = day + "." + month + "." + today.getFullYear();
                    let timezone = data['geoplugin_timezone'];
                    let city = data['geoplugin_city'];
                    let lat = data['geoplugin_latitude']; 
                    let lon = data['geoplugin_longitude'];
                    $.ajax({
                        url: 'https://api.open-meteo.com/v1/forecast?latitude=' + lat + "&longitude=" + lon + "&hourly=temperature_2m&daily=weathercode,temperature_2m_max,temperature_2m_min&forecast_days=1&start_date=" + date + "&end_date=" + date + "&timezone=" + timezone,
                        success: function (r) {
                            weather = r;
                            let currentTemperature; 
                            for (let t in weather.hourly['temperature_2m']) {
                                if (t = time) {
                                    currentTemperature = weather.hourly['temperature_2m'][t];
                                }
                            }
                            let reply = `<div><h2>Weather for: </h2>
                        <h4>${city} - ${dateToShow}</h4><table class='table table-striped'>
                    <thead>
                    <tr class='text-center'><td colspan='3'>Temperature</td></tr>
                        <tr>
                            <td>Current</td>
                            <td>Max</td>
                            <td>Min</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>${currentTemperature}°C</td>
                        <td>${weather.daily['temperature_2m_max']}°C</td>
                        <td>${weather.daily['temperature_2m_min']}°C</td></tr></tbody></table></div>`;
                            

                            let table = $(reply).hide();
                            $("#weatherRow").append(table);

                            table.fadeIn(1250);
                        }
                    })

                    // $("#location").html(data['geoplugin_city']);
                } else {
                    $("#location").html('Not Available');
                }
            }
            , error: function () {
            }
        });
    }
    });

    
  
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });

    
})(jQuery);


//DEO NOVI XDD AHAHA

let firstName = document.getElementById("firstName");
    let lastName = document.getElementById("lastName");
    let mail = document.getElementById("email");
    let username = document.getElementById("username");
    let password = document.getElementById("pass");
    let passwordCheck = document.getElementById("passCheck");


    const nameRegEx = /^[A-Z -ŠĐŽČĆ][a-z -šđžčć]*(([,.] |[ \'-])[A-Za-z -ŠĐŽČĆšđžčć][a-zšđžčć]*)*(\.?)$/;
    const mailRegEx = /^[a-zA-Z0-9\.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    const passRegEx = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;

    
    let firstNameError = document.getElementById("firstNameError");
    let lastNameError = document.getElementById("lastNameError");
    let emailError = document.getElementById("emailError");
    let passError = document.getElementById("passError");
    let passCheckError = document.getElementById("passCheckError");


    let firstNameErrorMessage = "Please enter Your name.";
    let firstNameErrorFormat = "Name should start with a capital letter and only contain letters.";
    let lastNameErrorMessage = "Please enter Your last name.";
    let lastNameErrorFormat = "Last name should start with a capital letter and only contain letters.";
    let emailErrorMessage = "Please enter an email.";
    let emailFormatErrorMessage = "Email must be in the following format: 'example@anymail.com'.";
    let passErrorMessage = "Please enter a password.";
    let passErrorFormat = "Password must contain at least 8 characters including at least one letter and one number.";
    let passCheckErrorMessage = "Please re-enter Your password.";
    let passCheckErrorFormat = "Passwords do not match.";




    $("#firstName").focus(function () {
        firstName.classList.remove("error");
        firstNameError.textContent = '';

    });
    $("#firstName").blur(function () {
        if (firstName.value == ""){
            firstName.classList.add("error");
            firstNameError.textContent = firstNameErrorMessage;
        }
        else if(!(nameRegEx.test(firstName.value))){
            firstName.classList.add("error");
            firstNameError.textContent = firstNameErrorFormat;
        }
        else {
            firstName.classList.remove("error");
            firstNameError.textContent = '';
        }
    });

    $("#lastName").focus(function () {
        lastName.classList.remove("error");
        lastNameError.textContent = '';
    });
    $("#lastName").blur(function () {
        if (lastName.value == ""){
            lastName.classList.add("error");
            lastNameError.textContent = lastNameErrorMessage;
        }
        else if(!(nameRegEx.test(lastName.value))){
            lastName.classList.add("error");
            lastNameError.textContent = lastNameErrorFormat;
        }
        else {
            lastName.classList.remove("error");
            lastNameError.textContent = '';
        }
    });

    $("#email").focus(function () {
        mail.classList.remove("error");
        emailError.textContent = '';
    });
    $("#email").blur(function () {
        var mailCheck = document.getElementById("email").value;
        if(mailCheck == ""){
            mail.classList.add("error");
            emailError.textContent = emailErrorMessage;
        }
        else if(!(mailRegEx.test(mailCheck))) {
            mail.classList.add("error");
            emailError.textContent = emailFormatErrorMessage;
        }
        else {
            $("#emailError").text('');
            mail.classList.remove("error");
            emailError.textContent = '';
        }
    });

    $("#pass").focus(function () {
        passwordCheck.classList.remove("error");
        passCheckError.textContent = '';
        password.classList.remove("error");
        passError.textContent = '';
    });
    $("#pass").blur(function () {
        if (password.value == ""){
            password.classList.add("error");
            passError.textContent = passErrorMessage;
        }
        else if(!(passRegEx.test(password.value))){
            password.classList.add("error");
            passError.textContent = passErrorFormat;
        }
        else {
            password.classList.remove("error");
            passError.textContent = '';
        }
    });

    $("#passCheck").focus(function () {
        passwordCheck.classList.remove("error");
        passCheckError.textContent = '';
    });
    $("#passCheck").blur(function () {
        if (passwordCheck.value == ""){
            passwordCheck.classList.add("error");
            passCheckError.textContent = passCheckErrorMessage;
        }
        else if(passwordCheck.value != password.value){
            passwordCheck.classList.add("error");
            passCheckError.textContent = passCheckErrorFormat;
        }
        else {
            passwordCheck.classList.remove("error");
            passCheckError.textContent = '';
        }
    });


$("#regSubmit").click(function(){
    event.preventDefault();
    if(firstName.value == ""){
        firstName.classList.add("error");
        firstNameError.textContent = firstNameErrorMessage;
    }
    else if(!(nameRegEx.test(firstName.value))){
        firstName.classList.add("error");
        firstNameError.textContent = firstNameErrorFormat;
    }
    if(lastName.value == ""){
        lastName.classList.add("error");
        lastNameError.textContent = lastNameErrorMessage;
    }
    else if(!(nameRegEx.test(lastName.value))){
        lastName.classList.add("error");
        lastNameError.textContent = lastNameErrorFormat;
    }
    if(mail.value == ""){
        mail.classList.add("error");
        emailError.textContent = emailErrorMessage;
    }
    else if(!mailRegEx.test(mail.value)){
        mail.classList.add("error");
        emailError.textContent = emailFormatErrorMessage;
    }
    else {
        mail.classList.remove("error");
        emailError.textContent = '';
    }
    if (password.value == ""){
        password.classList.add("error");
        passError.textContent = passErrorMessage;
    }
    else if(!(passRegEx.test(password.value))){
        password.classList.add("error");
        passError.textContent = passErrorFormat;
    }
    else {
        password.classList.remove("error");
        passError.textContent = '';
    }
    if (passwordCheck.value == ""){
        passwordCheck.classList.add("error");
        passCheckError.textContent = passCheckErrorMessage;
    }
    else if(passwordCheck.value != password.value){
        passwordCheck.classList.add("error");
        passCheckError.textContent = passCheckErrorFormat;
    }
    else {
        passwordCheck.classList.remove("error");
        passCheckError.textContent = '';
    }

    if(username.value == ""){
        username.classList.add("error");
        usernameError.textContent = firstNameErrorMessage;
    }


    if(mailRegEx.test(mail.value) && firstName.value != "" && username.value != "" && lastName.value != "" && nameRegEx.test(firstName.value) && nameRegEx.test(lastName.value) && passRegEx.test(password.value) && (passwordCheck.value == password.value)){
        let draftData = {
            firstName: firstName.value,
            lastName: lastName.value,
            username: username.value,
            email: mail.value,
            password: password.value,
            passwordCheck: passwordCheck.value
        }

        $.ajax({
            url: "models/registration.php",
            method: "POST",
            data: draftData,
            dataType: "json",
            success: function (result) {
                $("#response").html(`<p class='alert alert-success my-3'>${result.reply}</p>`);
                $("#response").show();
            },
            error: function(xhr){
                if(xhr.status == 500){
                    $("#response").html(`<p class='alert alert-info my-3'>${xhr.responseJSON.reply}</p>`);
                    $("#response").show();
                    setTimeout(function() { $("#response"). fadeOut(); }, 4000);
                }
                if(xhr.status == 404){
                    $("#response").html(`<p class='alert alert-danger my-3'>${xhr.responseJSON.reply}</p>`);
                    $("#response").show();
                    setTimeout(function() { $("#response"). fadeOut(); }, 4000);
                }
                if(xhr.status == 503){
                    $("#response").html(`<p class='alert alert-danger my-3'>${xhr.responseJSON.reply}</p>`);
                    $("#response").show();
                    setTimeout(function() { $("#response"). fadeOut(); }, 4000);
                }
            }
        })
    }
});

//#endregion

    // let loginEmail = document.getElementById("loginEmail");
    let loginPassword = document.getElementById("loginPass");
    // let loginEmailError = document.getElementById("loginEmailError");
    let loginPassError = document.getElementById("loginPassError");

    // $("#loginEmail").focus(function () {
    //     loginEmail.classList.remove("error");
    //     loginEmailError.textContent = '';
    // });
    // $("#loginEmail").blur(function () {
    //     if(loginEmail.value == ""){
    //         loginEmail.classList.add("error");
    //         loginEmailError.textContent = emailErrorMessage;
    //     }
    //     else if(!(mailRegEx.test(loginEmail.value))) {
    //         loginEmail.classList.add("error");
    //         loginEmailError.textContent = emailFormatErrorMessage;
    //     }
    //     else{
    //         loginEmail.classList.remove("error");
    //         loginEmailError.textContent = '';
    //     }
    // });

    $("#loginPass").focus(function () {
        loginPassword.classList.remove("error");
        loginPassError.textContent = '';
    });
    $("#loginPass").blur(function () {
        if (loginPassword.value == ""){
            loginPassword.classList.add("error");
            loginPassError.textContent = passErrorMessage;
        }
        else if(!(passRegEx.test(loginPassword.value))){
            loginPassword.classList.add("error");
            loginPassError.textContent = passErrorFormat;
        }
        else {
            loginPassword.classList.remove("error");
            loginPassError.textContent = '';
        }
    });

    $("#btnLogin").click(function(){    


        if(loginEmail.value == ""){
            loginEmail.classList.add("error");
            loginEmailError.textContent = emailErrorMessage;
        }
        else {
            loginEmail.classList.remove("error");
            loginEmailError.textContent = '';
        }
        if (loginPassword.value == ""){
            loginPassword.classList.add("error");
            loginPassError.textContent = passErrorMessage;
        }
        else if(!(passRegEx.test(loginPassword.value))){
            loginPassword.classList.add("error");
            loginPassError.textContent = passErrorFormat;
        }
        else {
            loginPassword.classList.remove("error");
            loginPassError.textContent = '';
        }
        
        if(loginEmail.value !="" && loginPassword.value != "" && passRegEx.test(loginPassword.value)){
            let draftData = {
                username: loginEmail.value,
                password: loginPassword.value
            }
     
            $.ajax({
                url: "models/login.php",
                method: "POST",
                data: draftData,
                dataType: "json",
                success: function(result){
                    window.location.replace(result.reply);
                },
                error: function(xhr){
                    if(xhr.status == 500){
                        $("#response").html(`<p class='alert alert-info my-3'>${xhr.responseJSON.reply}</p>`);
                        $("#response").show();
                        setTimeout(function() { $("#response"). fadeOut(); }, 4000);
                    }
                    if(xhr.status == 404){
                        $("#response").html(`<p class='alert alert-danger my-3'>${xhr.responseJSON.reply}</p>`);
                        $("#response").show();
                        setTimeout(function() { $("#response"). fadeOut(); }, 4000);
                    }
                    if(xhr.status == 403){
                        $("#response").html(`<p class='alert alert-info my-3'>${xhr.responseJSON.reply}</p>`);
                        $("#response").show();
                        setTimeout(function() { $("#response"). fadeOut(); }, 4000);
                    }
                    if(xhr.status == 503){
                        $("#response").html(`<p class='alert alert-danger my-3'>${xhr.responseJSON.reply}</p>`);
                        $("#response").show();
                        setTimeout(function() { $("#response"). fadeOut(); }, 4000);
                    }
                }
            })
        }
    })

$(document).click(function(){
    $("#response").hide();
})

$(".postList").bind("click", function () {
    $id = this.id;
    $.ajax({
        url: "index.php?postPage",
        method: "get",
        data: {
            id: $id
        },
        success: function (response) {
            location.href = response;
        }
    })
})

function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('preview');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
}
// $thisTime = '12h';
// $.ajax({
//         url: "views/pages/elements/logData.php",
//         method: "post",
//         data: {
//             vremeZapisa: $thisTime
//         },
//         success: function (response) {
//             console.log($thisTime);
//         },
//         error: function (xhr) {
//             console.log(xhr);
//         }
//     });

// $(document).ready(function () {
//     $("#logTime").on("change", function () {
//         $.ajax({
//             url: "views/pages/elements/logData.php",
//             method: "post",
//             dataType: "json",
//             data: {
//                 logTime: $(this).val()
//             },
//             success: function (response) {
//             console.log(response);
//         },
//         error: function (xhr) {
//             console.log(xhr);
//         }
//         })
//     })
    
// });
$("#subCatDiv").hide();


$("#cat").change(function () {
    const selCat = $(this).val();
    $.ajax({
        url: 'models/getSubcategories.php',
        method: 'POST',
        data: { category: selCat },
        dataType: 'json',
        success: function (response){
            if (response.length != 0) {
                $("#subCatDiv").slideDown();
                const subcategories = response;
                const subcategorySelect = $('#subCat');
                subcategorySelect.empty();
                subcategorySelect.append('<option selected disabled value="">Select subcategory</option>');
                for (const subcategory of subcategories) {
                    subcategorySelect.append(`<option value="${subcategory.sub_id}">${subcategory.sub_name}</option>`);
                }
            }
            else {
                const subcategorySelect = $('#subCat');
                subcategorySelect.empty();
                $("#subCatDiv").slideUp();
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
});




$(".ban").bind("click", function () {
    $id = this.id;
    $.ajax({
        url: "models/banUser.php",
        data: {
            id: $id
        },
        method: "post",
        success: function (response) {
            window.location.replace(response);
        }
    })
});

$(".unban").bind("click", function () {
    $id = this.id;
    $.ajax({
        url: "models/unbanUser.php",
        data: {
            id: $id
        },
        method: "post",
        success: function (response) {
            window.location.replace(response);
        }
    })
});

$(".delUser").bind("click", function () {
    let id = this.id;
    let role = $(this).data('id');
    $.ajax({
        url: "models/deleteUser.php",
        data: {
            id: id,
            role:role
        },
        method: "post",
        success: function () {
            // window.location.replace('index.php?page=userAdmin');
        }
    })
});

$(".delPost").bind("click", function () {
    let id = this.id;
    let role = $(this).data('id');
    $.ajax({
        url: "models/deletePost.php",
        data: {
            id: id,
        },
        method: "post",
        success: function () {
            window.location.replace('index.php?page=postAdmin');
        }
    })
});



//#region EDIT DATA CHECK

    let EfirstName = document.getElementById("e-firstName");
    let ElastName = document.getElementById("e-lastName");
    let Editmail = document.getElementById("e-email");
    let address = document.getElementById("address");
    let phoneNumber = document.getElementById("phoneNumber");
    let Epassword = document.getElementById("e-pass");
    let EpasswordCheck = document.getElementById("e-passCheck");
    let userID = document.getElementById("userID");
    let profilePicture = document.getElementById("file");

    const noValueRegEx = /^$/;
    const addressRegEx = /^[#.0-9a-zA-Z\s,-]+$/;
    const phoneRegEx = /^(\+\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/;

    $("#e-firstName").focus(function () {
        EfirstName.classList.remove("error");
        firstNameError.textContent = '';

    });

    $("#e-lastName").focus(function () {
        ElastName.classList.remove("error");
        lastNameError.textContent = '';
    });

    $("#e-email").focus(function () {
        Editmail.classList.remove("error");
        emailError.textContent = '';
    });

    $("#e-pass").focus(function () {
        EpasswordCheck.classList.remove("error");
        passCheckError.textContent = '';
        Epassword.classList.remove("error");
        passError.textContent = '';
    });

    $("#e-passCheck").focus(function () {
        EpasswordCheck.classList.remove("error");
        passCheckError.textContent = '';
    });

    $("#removePfp").click(function(){
        let draftData = {
            btnRemovePfp: true
        }
        $.ajax({
                url: "obrada/deletePfp.php",
                method: "POST",
                data: draftData,
                dataType: "json",
                success: function(result){
                    $("#response").show();
                    $("#response").html(`<p class='alert alert-success my-3'>${result.reply}</p>`);
                },
                error: function(xhr){
                    $("#response").html(`<p class='alert alert-success my-3'>${xhr.reply}</p>`);
                }
        })
    })


    $("#editProfileSubmit").click(function(){
        event.preventDefault();
        if(EfirstName.value == ""){
            EfirstName.classList.add("error");
            firstNameError.textContent = firstNameErrorMessage;
        }
        else if(!(nameRegEx.test(EfirstName.value))){
            EfirstName.classList.add("error");
            firstNameError.textContent = firstNameErrorFormat;
        }
        if(ElastName.value == ""){
            ElastName.classList.add("error");
            lastNameError.textContent = lastNameErrorMessage;
        }
        else if(!(nameRegEx.test(ElastName.value))){
            ElastName.classList.add("error");
            lastNameError.textContent = lastNameErrorFormat;
        }
        if(Editmail.value == ""){
            Editmail.classList.add("error");
            emailError.textContent = emailErrorMessage;
        }
        else if(!mailRegEx.test(Editmail.value)){
            Editmail.classList.add("error");
            emailError.textContent = emailFormatErrorMessage;
        }
        else {
            Editmail.classList.remove("error");
            emailError.textContent = '';
        }
        if(Epassword.value != ""){
            if(!(passRegEx.test(Epassword.value))){
            Epassword.classList.add("error");
            passError.textContent = passErrorFormat;
        }}
        else {
            Epassword.classList.remove("error");
            passError.textContent = '';
        }
        if(EpasswordCheck.value != Epassword.value){
            EpasswordCheck.classList.add("error");
            passCheckError.textContent = passCheckErrorFormat;
        }
        else {
            EpasswordCheck.classList.remove("error");
            passCheckError.textContent = '';
        }
        if(phoneNumber.value != ""){
            if(!phoneRegEx.test(phoneNumber.value)){
                $("#phoneNumberError").text("Phone number can only include numbers and symbols: +,-,(,),.");
                phoneNumber.classList.add("error");
            }
            else{
                $("#phoneNumberError").text("");
                phoneNumber.classList.remove("error");
            }
        }
        if(address.value != ""){
            if(!addressRegEx.test(address.value)){
                $("#addressError").text("Address not valid.");
                address.classList.add("error");
            }
            else{
                $("#addressError").text("");
                address.classList.remove("error");
            }
        }
        
    
        if(mailRegEx.test(Editmail.value) && EfirstName.value != "" && ElastName.value != "" && nameRegEx.test(EfirstName.value) && nameRegEx.test(ElastName.value) && (passRegEx.test(Epassword.value) || noValueRegEx.test(Epassword.value)) && (EpasswordCheck.value == Epassword.value) && (noValueRegEx.test(address.value) || addressRegEx.test(address.value))){
             let draftData = {
                firstName: EfirstName.value,
                lastName: ElastName.value,
                address: address.value,
                email: Editmail.value,
                password: Epassword.value,
                phoneNumber: phoneNumber.value,
                user: userID.value,
                btnEditProfile: true
            }

            var fd = new FormData();
            var files = $('#file')[0].files[0];
            fd.append('file',files);
    
            $.ajax({
                url: "obrada/obradaEditovanjaPodataka.php",
                method: "POST",
                data: draftData,
                dataType: "json",
                success: function(result){
                    $("#response").show();
                    $("#response").html(`<p class='alert alert-success my-3'>${result.reply}</p>`);
                },
                error: function(xhr){
                    console.log(xhr);
                }
            })

            if(profilePicture.value)
                var fd = new FormData();
                var files = $('#file')[0].files[0];
                fd.append('file',files);

                $.ajax({
                url: 'obrada/imageUpload.php',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response){
                }
            });
        }
    });

//#endregion


$(".edit").click(function () {
    let id = this.id;
    
    $.ajax({
        url: "models/getEditForm.php",
        method: "post",
        data: {
            id: id
        },
        success: function (response) {
            $(".editReply").html(response);
        }
    });
})

$(".editPost").click(function () {
    let id = this.id;
    
    $.ajax({
        url: "models/getPostEditForm.php",
        method: "post",
        data: {
            id: id
        },
        success: function (response) {
            $(".editReply").html(response);
        }
    });
})

// Get the modal element
var modal = document.getElementById("editModal");



// Get the <span> element that closes the modal
var closeBtn = document.querySelector(".close");

// Function to open the modal
function openModal() {
  modal.style.display = "block";
}

function openModalPostEdit() {
    modal.style.display = 'block';
}
// Function to close the modal
function closeModal() {
    modal.style.display = "none";
}

// Open the modal when the edit button is clicked
$(".edit").click(function () {
    openModal();
});

$(".editPost").click(function () {
    openModalPostEdit();
});

// Close the modal when the close button or outside the modal is clicked
closeBtn.addEventListener("click", closeModal);
window.addEventListener("click", function(event) {
  if (event.target == modal) {
    closeModal();
  }
});




// $("#subCatEditDiv").hide();

// $("#categoryEditSelect").change(function () {
//     console.log($(this).val());
//     let selCat = $(this).val();
//     $.ajax({
//         url: 'models/getSubcategories.php',
//         method: 'POST',
//         data: { category: selCat },
//         dataType: 'json',
//         success: function (response){
//             if (response.length != 0) {
//                 $("#subCatEditDiv").slideDown();
//                 let subcategories = response;
//                 let subcategorySelect = $('#subCatEdit');
//                 subcategorySelect.empty();
//                 subcategorySelect.append('<option selected disabled value="">Select subcategory</option>');
//                 for (let subcategory of subcategories) {
//                     subcategorySelect.append(`<option value="${subcategory.sub_id}">${subcategory.sub_name}</option>`);
//                 }
//             }
//             else {
//                 let subcategorySelect = $('#subCatEdit');
//                 subcategorySelect.empty();
//                 $("#subCatEditDiv").slideUp();
//             }
//         },
//         error: function (error) {
//             console.error(error);
//         }
//     });
// });

// Handle the form submission
// var editForm = document.getElementById("editForm");
// editForm.addEventListener("submit", function(event) {
//   event.preventDefault();
  
//   // Retrieve the form data
//   var name = document.getElementById("name").value;
  
//   // Perform the AJAX request or any other necessary actions to save the edited data
  
//   // Close the modal after saving the changes
//   closeModal();
// });


