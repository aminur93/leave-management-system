<script>
import register from "@/views/auth/Register.vue";

export default {
  name: "LeaveLogin",
  computed: {
    register() {
      return register
    }
  }
}
</script>

<template>
    <div class="login">
        <div class="wrapper">
            <form action="">
            <h2>Login</h2>

            <div class="input-box">
              <input type="text" placeholder="email" required>
              <i class='bx bxs-envelope'></i>
            </div>

            <div class="input-box">
              <input type="password" placeholder="password" required>
              <i class='bx bxs-lock-alt'></i>
            </div>

            <div class="remember-forget">
              <label for="">
                <input type="checkbox">
                Remember me
              </label>
              <a href="">Forget password?</a>
            </div>

            <button type="submit" class="btn">Submit</button>

            <div class="register-link">
              <p>
                Dont have an account?
                <router-link :to="{ name: 'Register' }">Register</router-link>
              </p>
            </div>
          </form>
        </div>
    </div>
</template>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

.login{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
  display: flex;
  justify-content: center !important;
  align-items: center !important;
  min-height: 100vh;
  background: url(../../assets/img.jpg) no-repeat;
  background-size: cover;
  background-position: center;
}

.wrapper{
  width: 420px;
  background: transparent;
  border: 2px solid rgba(255, 255, 255, .2);
  backdrop-filter: blur(20px);
  color: #fff;
  border-radius: 10px;
  padding: 30px 40px;
}

.wrapper h2{
  font-size: 36px;
  text-align: center;
}

.wrapper .input-box{
  position: relative;
  width: 100%;
  height: 50px;
  margin: 30px 0;
}

.input-box input {
  width: 100%;
  height: 100%;
  background: transparent;
  border: none;
  outline: none;
  border: 2px solid rgba(255, 255, 255, .2);
  border-radius: 40px;
  font-size: 16px;
  color: #fff;
  padding: 20px 45px 20px 20px;
}

.input-box input::placeholder{
  color: #fff;
}

.input-box i {
  position: absolute;
  right: 20px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 20px;
}

.wrapper .remember-forget{
  display: flex;
  justify-content: space-between;
  font-size: 14.5px;
  margin: -15px 0 15px;
}

.remember-forget label input{
  accent-color: #fff;
  margin-right: 3px;
}

.remember-forget a {
  color: #fff;
  text-decoration: none;
}

.remember-forget a:hover{
  text-decoration: underline;
}

.wrapper .btn{
  width: 100%;
  height: 45px;
  background: #fff;
  border: none;
  outline: none;
  border-radius: 40px;
  box-shadow: 0 0 10px rgba(0, 0, 0, .1);
  cursor: pointer;
  font-size: 16px;
  color: #333;
  font-weight: 600;
}

.wrapper .register-link{
  font-size: 14.5px;
  text-align: center;
  margin: 20px 0 15px;
}

.register-link p a{
  color: #fff;
  text-decoration: none;
  font-weight: 600;
}

.register-link p a:hover{
  text-decoration: underline;
}
</style>