<!-- Contact-->
<section class="page-section" id="contact">
    <div class="container">
      <div class="text-center">
        <h2 class="section-heading text-uppercase">LIÊN HỆ VỚI CHÚNG TÔI</h2>
        <h3 class="section-subheading text-muted">Bạn có thể liên hệ với chúng tôi qua các kênh sau.</h3>
      </div>
      <!-- * * * * * * * * * * * * * * *-->
      <!-- * * SB Forms Contact Form * *-->
      <!-- * * * * * * * * * * * * * * *-->
      <!-- This form is pre-integrated with SB Forms.-->
      <!-- To make this form functional, sign up at-->
      <!-- https://startbootstrap.com/solution/contact-forms-->
      <!-- to get an API token!-->
      <form id="contactForm" data-sb-form-api-token="API_TOKEN" action="https://formspree.io/f/xanyjzav" method="POST">
        <div class="row align-items-stretch mb-5">
          <div class="col-md-6">
            <div class="form-group">

              <input class="form-control" id="name" type="text" placeholder="Tên của bạn *"
                data-sb-validations="required" name="name" />
              <div class="invalid-feedback" data-sb-feedback="name:required">Tên không hợp lệ.</div>
            </div>
            <div class="form-group">
              <!-- Email address input-->
              <input class="form-control" id="email" name="email" type="email" placeholder="Email của bạn *"
                data-sb-validations="required,email" />
              <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
              <div class="invalid-feedback" data-sb-feedback="email:email">Email không hợp lệ!</div>
            </div>
            <div class="form-group mb-md-0">

              <input class="form-control" id="phone" name="phone" type="tel" placeholder="Số điện thoại của bạn *"
                data-sb-validations="required" />
              <div class="invalid-feedback" data-sb-feedback="phone:required">Số điện thoại không hợp lệ!.</div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group form-group-textarea mb-md-0">
              <!-- Message input-->
              <textarea class="form-control" id="message" name="message" placeholder="Your Message *"
                data-sb-validations="required"></textarea>
              <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
            </div>
          </div>
        </div>
        <!-- Submit success message-->
        <!---->
        <!-- This is what your users will see when the form-->
        <!-- has successfully submitted-->
        <div class="d-none" id="submitSuccessMessage">
          <div class="text-center text-white mb-3">
            <div class="fw-bolder">Gửi thành công!</div>
            Vui lòng đợi phản hồi từ chúng tôi hoặc gọi điện trực tiếp qua số điện thoại: xxxxxxxxx
            <br />
            <!-- <a
              href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a> -->
          </div>
        </div>
        <!-- Submit error message-->
        <!---->
        <!-- This is what your users will see when there is-->
        <!-- an error submitting the form  -->
        <div class="d-none" id="submitErrorMessage">
          <div class="text-center text-danger mb-3">Error sending message!</div>
        </div>
        <!-- Submit Button  id="submitButton"-->
        <div class="text-center"><button class="btn btn-primary btn-xl text-uppercase" type="submit">Send
            Message</button></div>
      </form>
    </div>
  </section>
  