<template>
    <div class="page login-page">
      <div class="container d-flex align-items-center">
        <div class="form-holder has-shadow">
          <div class="row">
            <!-- Logo & Information Panel-->
            <div class="col-lg-6">
              <div class="info d-flex align-items-center">
                <div class="content">
                  <div class="logo">
                    <h1>Admin Dashboard</h1>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>
              </div>
            </div>
            <!-- Form Panel    -->
            <div class="col-lg-6 bg-white">
              <div class="form d-flex align-items-center">
                <div class="content">
                  <div id="login-form" method="post">
                    <div class="form-group">
                      <input id="login-username" type="text" name="loginUsername" required="" class="input-material">
                      <label for="login-username" class="label-material">User Name</label>
                    </div>
                    <div class="form-group">
                      <input id="login-password" type="password" name="loginPassword" required="" class="input-material">
                      <label for="login-password" class="label-material">Password</label>
                    </div><a id="login" href="index.html" class="btn btn-primary">Login</a>
                    <!-- This should be submit button but I replaced it with <a> for demo purposes-->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      user: {
        email: '',
        password: ''
      }
    }
  },
  methods: {
    login() {

    }
  }
}
</script>

<style>
.login-page {
  position: relative;
}

.login-page::before {
  content: '';
  width: 100%;
  height: 100%;
  display: block;
  z-index: -1;
  background-size: cover;
  -webkit-filter: blur(10px);
  filter: blur(10px);
  z-index: 1;
  position: absolute;
  top: 0;
  right: 0;
}

.login-page .container {
  min-height: 100vh;
  z-index: 999;
  padding: 20px;
  position: relative;
}

.login-page .form-holder {
  width: 100%;
  border-radius: 5px;
  overflow: hidden;
  margin-bottom: 50px;
}

.login-page .form-holder .info, .login-page .form-holder .form {
  min-height: 70vh;
  padding: 40px;
  height: 100%;
}

.login-page .form-holder div[class*='col-'] {
  padding: 0;
}

.login-page .form-holder .info {
  background: rgba(43, 144, 217, 0.9);
  color: #fff;
}

.login-page .form-holder .info h1 {
  font-size: 2.5em;
  font-weight: 600;
}

.login-page .form-holder .info p {
  font-weight: 300;
}

.login-page .form-holder .form .form-group {
  position: relative;
  margin-bottom: 30px;
}

.login-page .form-holder .form .content {
  width: 100%;
}

.login-page .form-holder .form form {
  width: 100%;
  max-width: 400px;
}

.login-page .form-holder .form #login, .login-page .form-holder .form #register {
  margin-bottom: 20px;
  cursor: pointer;
}

.login-page .form-holder .form a.forgot-pass, .login-page .form-holder .form a.signup {
  font-size: 0.9em;
  color: #85b4f2;
}

.login-page .form-holder .form small {
  color: #aaa;
}

.login-page .form-holder .form .terms-conditions label {
  cursor: pointer;
  color: #aaa;
  font-size: 0.9em;
}

.login-page .copyrights {
  width: 100%;
  z-index: 9999;
  position: absolute;
  bottom: 0;
  left: 0;
  color: #fff;
}

@media (max-width: 991px) {
  .login-page .info, .login-page .form {
    min-height: auto !important;
  }
  .login-page .info {
    padding-top: 100px !important;
    padding-bottom: 100px !important;
  }
}
</style>
