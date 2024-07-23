<!-- Signup modal -->
<div class="modal fade" id="signup" tabindex="-1" aria-labelledby="signupLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="signupLabel">Signup</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Signup form -->
        <form action="home.php" method="post">
          <div class="form-floating mb-3">
            <input name="fname" type="text" class="form-control" id="floatingInputFName" placeholder="First Name">
            <label for="floatingInputFName">First Name</label>
          </div>
          <div class="form-floating mb-3">
            <input name="lname" type="text" class="form-control" id="floatingInputLName" placeholder="Last Name">
            <label for="floatingInputLName">Last Name</label>
          </div>
          <div class="form-floating mb-3">
            <input name="email" type="email" class="form-control" id="floatingInputEmailSignup" placeholder="Email">
            <label for="floatingInputEmailSignup">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input name="phone" type="text" class="form-control" id="floatingInputPhoneSignup" placeholder="Phone">
            <label for="floatingInputPhoneSignup">Phone</label>
          </div>
          <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control" id="floatingInputPasswordSignup"
              placeholder="Password">
            <label for="floatingInputPasswordSignup">Password</label>
          </div>
          <div class="form-floating mb-3">
            <input name="district" type="text" class="form-control" id="floatingInputPasswordSignup"
              placeholder="District">
            <label for="floatingInputPasswordSignup">District</label>
          </div>
          <div class="form-floating mb-3">
            <input name="city" type="text" class="form-control" id="floatingInputPasswordSignup" placeholder="City">
            <label for="floatingInputPasswordSignup">City</label>
          </div>
          <div class="modal-footer">
            <button type="submit" name="signup_submit" class="btn btn-primary">Signup</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>

        <!-- Signup form ends -->
      </div>
    </div>
  </div>
</div>
<!-- Signup modal end -->




<!-- Login modal -->
<div class="modal fade" id="login" tabindex="-1" aria-labelledby="loginLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Login form -->
        <form action="home.php" method="post">
          <div class="form-floating mb-3">
            <input name="email" type="email" class="form-control" id="floatingInputEmailLogin" placeholder="Email">
            <label for="floatingInputEmailLogin">Email</label>
          </div>
          <div class="form-floating mb-3">
            <input name="password" type="password" class="form-control" id="floatingInputPasswordLogin"
              placeholder="Password">
            <label for="floatingInputPasswordLogin">Password</label>
          </div>
          <div class="modal-footer">
            <button type="submit" name="login_submit" class="btn btn-primary">Login</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
        <!-- Login form ends -->
      </div>
    </div>
  </div>
</div>
<!-- Login modal end -->