<!-- html code -->
<!-- form start -->
<section class="section-full">
    <!-- LOCATION BLOCK-->
    <div class="container">
        <!-- GOOGLE MAP & CONTACT FORM -->
        <div class="section-content">
            <!-- CONTACT FORM-->
            <div class="row">
                <div class="col">
                    <form id="contact_form" class="text-left" data-parsley-validate>
                        <div class="contact-one m-b30">
                            <!-- TITLE START -->
                            <div class="section-head">
                                <div class="mt-separator-outer separator-left">
                                    <div class="mt-separator">
                                        <h2 class="text-uppercase sep-line-one "><span class="font-weight-300 site-text-primary">Get</span> In touch</h2>
                                    </div>
                                </div>
                            </div>
                            <!-- TITLE END -->
                            <div class="contact-one-inner">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <input name="username" type="text" required class="form-control" placeholder="Name">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input name="email" type="email" class="form-control" required placeholder="Email">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input name="mobile" type="tel" class="form-control" required placeholder="Mobile" maxlength="13" data-parsley-pattern="^\+?\d{10,12}$">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <input name="subject" type="text" class="form-control" required placeholder="Subject">
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <textarea name="message" rows="4" class="form-control " required placeholder="Message"></textarea>
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="input-group">
                                            <?php $captcha_image_src = generateCaptchaImage();
                                            echo '<img src="' . $captcha_image_src . '" />'; ?>
                                            <input type="text" name="form_captcha" class="form-control" placeholder="Enter captcha" data-parsley-error-message="Captcha is required." required>
                                        </div>
                                    </div>

                                    <div class="text-right col-lg-7">
                                        <button id="submit" name="submit" class="site-button btn-effect">submit</button>
                                    </div>

                                    <div class="form-group col-lg-12 mt-2">
                                        <div id="spinner" class="text-center alert alert-warning" style="display:none;"><strong>Please wait...</strong></div>
                                        <div id="response_message" style="display:none;" class="text-center alert alert-success text-break"><strong></strong></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div> 
            </div>
        </div> 
    </div>
</section>
<!-- js start -use in footer  -->
<script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script>
$(document).ready(function () {
    $('#contact_form').submit(function(event) {
        event.preventDefault();
        var form_captcha = $("input[name='form_captcha']").val().trim();
        var captcha_check = "<?php echo $_SESSION['captcha_code']; ?>";
        if (form_captcha == captcha_check) {
           if ($("#contact_form").parsley().isValid()) {
            $('#submit').attr('disabled', 'disabled');
            $('#spinner').show();
            var formData = new FormData(this);
            formData.append('action', 'contact_form_data');
            $.ajax({
                type: 'POST',
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#spinner').hide();
                    // Parse JSON response
                    var responseData = JSON.parse(response);
                    if (responseData.success == true) {
                        $('#response_message').show().html(responseData.message);
                        setTimeout(function() {
                            $('#contact_form')[0].reset();
                            location.reload();
                        }, 3000);
                    } else {
                        $('#submit').removeAttr('disabled');
                        $('#response_message').show().html(responseData.message);   
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        }
        } else {
            $('#response_message').show().html('Captcha Invalid');
        }  
    });
});
</script>
<!-- form start -->
 <!-- html code  end-->


 <!-- function.php  # php code start  -->

 
 <?php
// SMTP configuration function
function configure_outlook_smtp($phpmailer) {
    // Define Outlook SMTP settings
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp-mail.outlook.com';
    $phpmailer->Port       = 587;
    $phpmailer->SMTPAuth   = true;
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->Username   = 'enquiry@deltaview.in'; // Your Outlook email address
    $phpmailer->Password   = 'Symbols@55';    // Your Outlook email password

    // Set the 'From' email address and name
    $from = 'enquiry@deltaview.in';
    $from_name = 'Deltaview';
    $phpmailer->setFrom($from, $from_name);
    
    // Set the 'Reply-To' email address (no-reply)
    // $no_reply = 'no-reply@deltaview.in';
    // $phpmailer->addReplyTo($no_reply, 'No Reply');

    // Uncomment the following line if you want to use HTML in your emails
    // $phpmailer->isHTML(true);

    // Enable debugging (optional: 0 for no debugging, 2 for detailed debugging)
    $phpmailer->SMTPDebug  = 0;

    // Return the configured PHPMailer instance
    return $phpmailer;
}

Hook the configuration function into the phpmailer_init action
add_action('phpmailer_init', 'configure_outlook_smtp');


// Start session - if use session in wordpress
function start_session() {
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'start_session', 1);

// contact form
function contact_form_data(){
     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'contact_form_data') {
            $To = "arun@deltaweb.in";
            $from = "arun@deltaweb.in";
            $subject_header = "Contact Form";
            $message = "\n" . 'Dear GNS Team,'."\n\n";
            $message .= 'A request has been received with the following details:-'."\n\n";
            $message .= 'Name : '. sanitize_text_field($_POST['username']) . "\n";
            $message .= 'Email : '. sanitize_email($_POST['email']) . "\n";
            $message .= 'Phone No.: '. sanitize_text_field($_POST['mobile']) . "\n";
            $message .= 'Subject : '. sanitize_text_field($_POST['subject']) . "\n";
            $message .= 'Message : '. sanitize_text_field($_POST['message']) . "\n\n";
            $message .= 'Thanks & Regards'."\n";
            $message .= 'GNS Team';
        
            // email headers
            $headers = array(
                'Content-Type: text/plain; charset=UTF-8',
                "From: <$from>",
            );
         
            // Send email
            $sendmail = wp_mail($To, $subject_header, $message, $headers);
            if($sendmail){
                  echo json_encode(array('success' => true, 'message' => 'Thank you! Your form has been submitted successfully.'));
            }else{
                 echo json_encode(array('success' => false, 'message' => 'Invalid request form not submitted'));  
            }
           
        }
        else{
          echo json_encode(array('success' => false, 'message' => 'Invalid request'));  
        }
        wp_die();   
}
add_action('wp_ajax_contact_form_data', 'contact_form_data');
add_action('wp_ajax_nopriv_contact_form_data', 'contact_form_data');

// use function in from for captcha image 
function generateCaptchaImage() {
    // Generate random numbers for the addition problem
    $num1 = rand(10, 99);
    $num2 = rand(10, 99);
    $_SESSION["captcha_code"] = $num1 + $num2;
    $random_number = $num1 . ' + ' . $num2 . ' =';
    
    // Create the image with the CAPTCHA string
    $image_width = 100;
    $image_height = 35;
    $image = imagecreate($image_width, $image_height);
    $background_color = imagecolorallocate($image, 0, 0, 0);
    $text_color = imagecolorallocate($image, 255, 255, 255);
    
    // Calculate the position to center the text horizontally
    $text_width = imagefontwidth(5) * strlen($random_number);
    $text_x = ($image_width - $text_width) / 2;
    
    // Calculate the position to center the text vertically
    $text_height = imagefontheight(5);
    $text_y = ($image_height - $text_height) / 2;
    
    imagestring($image, 5, $text_x, $text_y, $random_number, $text_color);
    
    // Output the image
    ob_start(); // Start output buffering
    imagejpeg($image); // Output the image
    $image_data = ob_get_clean(); // Get the image data and clean the buffer
    $image_base64 = base64_encode($image_data); // Encode the image data as base64
    
    // Destroy the image resource
    imagedestroy($image);
    
    return 'data:image/jpeg;base64,' . $image_base64;
}

?>