<div class="section">
    <div class="section-title"><strong>CONTACT</strong> US</div>
    <a target="_blank" href="https://www.google.com/maps/place/Rhema+Tour+%26+Travel/@-7.3150762,112.7528149,17z/data=!3m1!4b1!4m5!3m4!1s0x2dd7fb04eeda26d5:0x4af128ce5ef583df!8m2!3d-7.3150762!4d112.7550036" class="contact-us-image image-container">
        <img class="map-image" src="<?php echo base_url("assets/images/contact/contact_1.jpg"); ?>" data-src="<?php echo base_url("assets/images/contact/contact_1.jpg"); ?>" />
        <div class="google-maps">
            <div class="google-maps-text">View on Google Maps</div>
        </div>
    </a>
    <form class="contact-form" method="post" action="<?php echo base_url("contact/submit_message"); ?>">
        <div class="form-item">
            <div class="form-label">Full Name <span class="error error-name"></span></div>
            <input type="text" name="name" class="form-input input-name" maxlength="100" />
        </div>
        <div class="form-item">
            <div class="form-label">Email Address <span class="error error-email"></span></div>
            <input type="text" name="email" class="form-input input-email" maxlength="100" />
        </div>
        <div class="form-item">
            <div class="form-label">Phone Number <span class="error error-phone"></span></div>
            <input type="text" name="phone" class="form-input input-phone" data-type="number" maxlength="20" />
        </div>
        <div class="form-item">
            <div class="form-label">Subject</div>
            <input type="text" name="subject" class="form-input input-subject" maxlength="100" />
        </div>
        <div class="form-item">
            <div class="form-label">Message</div>
            <textarea name="message" class="form-input input-message"></textarea>
        </div>
        <div class="button-invers btn-submit">
            <div class="button-left"></div>
            <div class="button-right"></div>
            <div class="button-text">Submit</div>
        </div>
    </form>
</div>