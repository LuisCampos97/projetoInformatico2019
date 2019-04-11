<template>
  <div>
    <div class="container">
      <h2>Login</h2>
      <div class="form-group">
        <label for="inputEmail">Email</label>
        <input
          type="email"
          class="form-control"
          v-model.trim="user.email"
          name="email"
          id="inputEmail"
          placeholder="Enter email address"
        >
      </div>
      <div class="form-group">
        <label for="inputPassword">Password</label>
        <input
          type="password"
          class="form-control"
          v-model="user.password"
          name="password"
          id="inputPassword"
          placeholder="Enter password"
        >
      </div>
      <div class="form-group">
        <a class="btn btn-primary" v-on:click.prevent="login">Login</a>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      user: {
        email: "",
        password: ""
      }
    };
  },
  methods: {
    login() {
      axios.post("api/login", this.user).then(response => {
        console.log(response);
      });
    }
  }
};
</script>

<style>
div {
  display: table-cell;
}

body {
  margin: 0;
  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px;
  line-height: 18px;
  color: #676a6c;
  background-color: #f3f3f4;
}

#wrapper {
  display: table;
  overflow: hidden;
  position: absolute;
  z-index: 0;
  width: 100%;
  height: 100%;
}

#welcome {
  background-size: cover;
  background-color: #1a1a1a;
  color: #fff;
  padding: 70px 0 0 0;
  vertical-align: middle;
}

.login-title-content-wrapper {
  font-size: 2.2rem;
  line-height: 3.5rem;
  text-align: center;
}

#app-name {
  padding: 70px 0 60px;
}

#logo {
  padding: 20px 0 0;
  text-align: center;
  position: relative;
}

#login-form {
  width: 50%;
  height: 100%;
  vertical-align: top;
  display: table-cell;
}
</style>
