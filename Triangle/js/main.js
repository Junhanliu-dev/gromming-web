var DefaultUsername = "testuser@gmail.com";
var DefaultPassword = "xxxxxxx";
var username = DefaultUsername;
$(function() {
    
    var loginPage = jQuery('#loginPage')[0];
    var AppointmentPage = jQuery('#setAppointment')[0];
    var userInfoPage = jQuery('#userInfoPage')[0];
    var userEditPage = jQuery('#userEditPage')[0];
    var CheckAppointmentPage =  jQuery('#AppointmentInfoPage')[0];
    var span = document.getElementsByClassName("close")[0];
    var dt = new Date();
    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
	var xmlFile;

    $.ajax({
        type: "GET",
        url : "test.xml",
        dataType: "xml",
        success: xmlParser
    });

    $('#fullpage').fullpage({
        anchors: ['Login'],
        sectionsColor: ['#48929B'],
        css3: true,
        menu: '#menu'
    });

    $('#mainpage').fullpage({
        anchors: ['BeforeLogin'],
        css3: true,
        menu: '#menu'
    });

    $('#Groomerpage').fullpage({
        anchors: ['GroomerPage'],
        css3: true,
        menu: '#menu'
    });

    $('#AddEditMain').fullpage({
        anchors: ['AddEditPage'],
        css3: true,
        menu: '#menu'
    });


    $("#beforeLoginIcon").click(function() {
          loginPage.style.display = "block";
    });

    $('#email').attr("value", DefaultUsername);
    $('#password').attr("value", DefaultPassword);

    $("#makeAppointment").click(function() {
        AppointmentPage.style.display = "block";
    });

    $("#checkAppointment").click(function() {
        CheckAppointmentPage.style.display = "block";
    });

    $('#confirmAppointmentInfo').on('click',function(){
        CheckAppointmentPage.style.display = "none";
    });

    span.onclick = function() {
        loginPage.style.display = "none";
    }

    $('#confirmLogin').on('click',function(){
        loginPage.style.display = "none";
        username = $('#email').val();
    });

    $('#confirmUserInfo').on('click',function(){
        userInfoPage.style.display = "none";
    });

    $('#userEditPage').on('click',function(){
        userEditPage.style.display = "none";
    });

    $('#appointmentConfirm').on('click',function(){
        setAppointment.style.display = "none";
    });

    $('#appointmentCancle').on('click',function(){
        setAppointment.style.display = "none";
    });

    $('#checkInfo').on('click',function(){
        userInfoPage.style.display =  "block";
    });

    $('#checkUserBookings').on('click',function(){
        CheckBooking.style.display =  "block";
    });

    $('#confirmInfo').on('click',function(){
        CheckBooking.style.display =  "none";
    });

    $('#Logout').on('click',function(){
        location.href = "logout.php";
    });

    $('#Logout2').on('click',function(){
        location.href = "logout.php";
    });

    $('#rescheduleButton').on('click',function(){
        ReschedualPage.style.display = "block";
    });

    $('#confirmReschedual').on('click',function(){
        ReschedualPage.style.display = "none";
    });

    $('#CancelAppointment').on('click',function(){
        ReschedualPage.style.display = "none";
    });


    $('#ReschedualBack').on('click',function(){
        ReschedualPage.style.display = "none";
    });


    var c = new Date();
    console.log("date" + c.getDate() + 1);
    c.setHours(7);
    c.setMinutes(0);
    var hour = c.getHours();
    var min = c.getMinutes();

    var i;
    var date =  c.getDate();
    for (i = 0; i < 9; i++) {
        hour = calHour(hour,min);
        min = calMin(min);
        console.log(hour + "   "+min);

        $('#selectTime').append($('<option>', {
            value: hour+":"+min,
            text: hour+":"+min
        }));

        $('#ReschedualTime').append($('<option>', {
            value: hour+":"+min,
            text: hour+":"+min
        }));



    }
	
	for (j = 0; j < 3; j++) {
	$('#selectDate').append($('<option>', {
		value: date,
		text: date + "th"
	}));
			
	$('#ReschedualDate').append($('<option>', {
		value: date,
		text: date + "th"
	}));

	date++;
	if(date == 32){
	    date = 1;
    }

	}
});

function  reload() {
    location.reload();
}
function  checkValidTime() {
    var time = $('#selectTime').val();
    var splited = time.split(":");
    var h = splited[0];
    var m = splited[1];
    var date = $('#selectDate').val();

    if (h < new Date().getHours() && date == new Date().getDate()){
        alert("Invalid Time!")
    }

    $(xmlFile).find("Account").each(function () {
        $(this).find("Appointment").each(function () {
            if($(this).find("Date").text() == date && time  == $(this).find("Time").text() && $(this).find("Cancel").text() != "YES"  ){
                alert("Selected Time has been booked123!");
            }
        });
    });
}

function  checkSchduleTime() {
    var time = $('#ReschedualTime').val();
    var splited = time.split(":");
    var h = splited[0];
    var m = splited[1];
    var date = $('#ReschedualDate').val();

    if (h < new Date().getHours() && date == new Date().getDate()){
        alert("Invalid Time!")
    }

    $(xmlFile).find("Account").each(function () {
        $(this).find("Appointment").each(function () {
            if($(this).find("Date").text() == date && time  == $(this).find("Time").text() && $(this).find("Cancel").text() == "NO" ){

                alert("Selected Time has been booked!");
            }
        });
    });
}

function  getAppointment(selectObject) {
    $('#DogNameApp').empty();
    $('#ServiceApp').empty();
	$('#date').empty();
    $('#time').empty();
    $('#comment').empty();
    var value = selectObject.value;
    $(xmlFile).find("Account").each(function () {
        if ($(this).find("Id").text() == accountId) {
            $(this).find("Appointment").each(function () {
                if ($(this).find("AppointmentId").text() == value) {
                    $('#DogNameApp').append("Dog Name :  " + $(this).find("DogName").text() + "    ");
                    $('#ServiceApp').append("Breed :  " + $(this).find("Service").text() + "    ");
					$('#date').append("Date :  " + $(this).find("Date").text() + "    ");
                    $('#time').append("Time :  " + $(this).find("Time").text() + "    ");
                    $('#comment').append("Comment :  " + $(this).find("Comment").text() + "    ");
                }
            });
        }
    });
}

function  getReAppointment(selectObject) {
    $('#ReDogNameApp').empty();
    $('#ReServiceApp').empty();
	$('#Redate').empty();
    $('#Retime').empty();
    $('#Recomment').empty();
    var value = selectObject.value;
    $(xmlFile).find("Account").each(function () {
        if ($(this).find("Id").text() == accountId) {
            $(this).find("Appointment").each(function () {
                if ($(this).find("AppointmentId").text() == value) {
                    $('#ReDogNameApp').append("Dog Name :  " + $(this).find("DogName").text() + "    ");
                    $('#ReServiceApp').append("Breed :  " + $(this).find("Service").text() + "    ");
					$('#Redate').append("Date :  " + $(this).find("Date").text() + "    ");
                    $('#Retime').append("Time :  " + $(this).find("Time").text() + "    ");
                    $('#Recomment').append("Comment :  " + $(this).find("Comment").text() + "    ");
                }
            });
        }
    });
}
function displayDog(selectObject){

    $('#DogNameField').empty();
    $('#breedField').empty();
    $('#DogBirth').empty();

    var value = selectObject.value;
    console.log("selected value  "+value)
    $(xmlFile).find("Account").each(function () {
        if ($(this).find("Id").text() == accountId) {
            $(this).find("Dog").each(function () {
                if ($(this).find("DogId").text() == value){
                    $('#DogNameField').append("DogName :  "+ $(this).find("DogName").text());
                    $('#breedField').append("Breed :  " + $(this).find("Breed").text());
                    $('#DogBirth').append("Date of Birth :  "+$(this).find("Birth").text());
                }
            });
        }
    });
}
function  displayInputDog(selectObject) {
    var value = selectObject.value;
    console.log("selected value  "+value)
    $(xmlFile).find("Account").each(function () {
        if ($(this).find("Id").text() == accountId) {
            $(this).find("Dog").each(function () {
                if ($(this).find("DogId").text() == value){
                    $('#editDogName').attr("value", $(this).find("DogName").text());
                    $('#editBreed').attr("value",$(this).find("Breed").text());
                    $('#editBirth').attr("value",$(this).find("Birth").text());
                }
            });
        }
    });
}

function  displayUserBooking(selectObject) {
    var value = selectObject.value;
    $('#UserAppointmentinfo').empty();
    var i = 1;
    $(xmlFile).find("Account").each(function () {
        if ($(this).find("Id").text() == value) {

            $(this).find("Appointment").each(function () {
                if($(this).find("Cancel").text() == "NO") {
                    $('#UserAppointmentinfo').append('Appointment :  ' + i);
                    $('#UserAppointmentinfo').append('<p>Service : </p>' + $(this).find("Service").text());
					$('#UserAppointmentinfo').append('<p>Date : </p>' + $(this).find("Date").text());
                    $('#UserAppointmentinfo').append('<p>Time : </p>' + $(this).find("Time").text());
                    $('#UserAppointmentinfo').append('<p>Comment : </p>' + $(this).find("Comment").text());
                    $('#UserAppointmentinfo').append('<br><br><br>');
                    i++;
                }
            });

        }

    });

}
function xmlParser(xml) {
    xmlFile = xml;

    var userid = 0;
    $(xml).find("Account").each(function () {
            $('#selectBookedUser').append($('<option>', {
                value: userid,
                text: $(this).find("Name").text() +"  ("+ $(this).find("Email").text()+")"
            }));
            userid = userid+1;
    });

    if (loginFlag) {
        $(xml).find("Account").each(function () {

            if ($(this).find("Id").text() == accountId) {
                $("#NameField").append($(this).find("Name").text());
                $("#HomeField").append($(this).find("Home").text());
                $("#AddressField").append($(this).find("Address").text());
                $("#PhoneNumberField").append($(this).find("Phone").text());

                var i = 0;
                var j = 1;
                $(this).find("Appointment").each(function () {
                    if( $(this).find("Cancel").text() == "NO") {
                        $('#selectAppoinment').append($('<option>', {
                            value:  $(this).find("AppointmentId").text() ,
                            text: "Appointment " + (j)
                        }));

                        $('#SelectReschedualAppoinment').append($('<option>', {
                            value:  $(this).find("AppointmentId").text() ,
                            text: "Appointment " + (j)
                        }));
                        j++;
                    }
                });

                $(this).find("Dog").each(function () {

                    $('#selectDog').append($('<option>', {
                        value: i,
                        text: $(this).find("DogName").text()
                    }));

                    $('#AppointmentdogSelect').append($('<option>', {
                        value: i,
                        text: $(this).find("DogName").text()
                    }));

                    $('#editDog').append($('<option>', {
                        value: i,
                        text: $(this).find("DogName").text()
                    }));

                    i++;
                });

                $('#editNameText').attr("value", $(this).find("Name").text());
                $('#editHomeText').attr("value", $(this).find("Home").text());
                $('#editAddressText').attr("value", $(this).find("Address").text());
                $('#editPhone').attr("value", $(this).find("Phone").text());

                titleCustomer.innerText = "Welcome " + $(this).find("Name").text() + "!";
            }
        });
    }
}

	function calHour(h,m) {
	h = h + 1;
	m = m + 30;
	if (m == 60){
		h = h + 1;
	}
	return h;
    }
	
    function calMin(m){
        m = m + 90;
        if (m > 60){
            m = m % 60;
        }
        if (m < 10){
            m = "0"+m;
        }
        return m;
    }

