<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple Ajax Contact Form</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="form-style">
    <div class="form-style-heading">Please Contact Us</div>
    <div id="contact_results"></div>
    <div id="contact_body">
    <form action="contact_me.php" method="post" id="my_contact_form" novalidate>
        <label><span>Name <span class="required">*</span></span>
            <input type="text" name="user_name" required class="input-field"/>
        </label>
        <label><span>Email <span class="required">*</span></span>
            <input type="email" name="user_email" required class="input-field"/>
        </label>
        <label><span>Phone</span>
            <input type="number" name="country_code" maxlength="4" placeholder="+91" class="tel-number-field"/>&mdash;<input type="number" name="phone_number" maxlength="15" class="tel-number-field long" required/>
        </label>
            <label for="subject"><span>Regarding</span>
            <select name="subject" class="select-field" required>
            <option value="">---- Select ----</option>
            <option value="General Question">General Question</option>
            <option value="Advertise">Advertisement</option>
            <option value="Partnership">Partnership Oppertunity</option>
            </select>
        </label>
        <label for="field5"><span>Message <span class="required">*</span></span>
            <textarea name="message" id="message" class="textarea-field" required></textarea>
        </label>
        <label>
            <span>&nbsp;</span><input type="submit" id="submit_btn" value="Submit" />
        </label>
     </form>
    </div>
</div>

<!-- include Google hosted jQuery Library -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<!-- Start jQuery code -->
<script type="text/javascript">
$("#my_contact_form").submit(function(e){
    e.preventDefault(); //prevent default action 
    var proceed = true;
    var form = this;
    
    //simple validation at client's end
    //loop through each field and we simply change border color to red for invalid fields       
    $(form).find(':required').each(function(){
        $(this).css('border-color',''); 
        if(!$.trim($(this).val())){ //if this field is empty 
            $(this).css('border-color','red'); //change border color to red   
            proceed = false; //set do not proceed flag
        }
        //check invalid email
        var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
        if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
            $(this).css('border-color','red'); //change border color to red   
            proceed = false; //set do not proceed flag              
        }   

    }).keyup(function() { //reset previously set border colors on .keyup()
        $(this).css('border-color',''); 
    }).change(function() {  //for select box
        $(this).css('border-color',''); 
    }); 
    
    if(proceed){ //everything looks good! proceed...
        //get input field values data to be sent to server
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission
        
        //Ajax post data to server
        $.ajax({
            url : post_url,
            type: request_method,
            dataType : 'json',
            data : form_data
        })
        .done(function(response){ 
            if(response.type == 'error'){ //load json data from server and output message     
                output = '<div class="error">'+response.text+'</div>';
            }else{
                $(form)[0].reset(); //reset this form upon success
                output = '<div class="success">'+response.text+'</div>';
            }
            $("#contact_results").html(output);
        });
    }
});
</script>

</body>
</html>
