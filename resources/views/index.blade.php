<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        * {
  font-family: "Poppins";
}

body {
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  overflow-y: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #dde5f4;
  height: 100vh;
}

.screen-1 {
  background: #f1f7fe;
  padding: 2em;
  display: flex;
  flex-direction: column;
  border-radius: 30px;
  box-shadow: 0 0 2em #e6e9f9;
  gap: 2em;
}
.screen-1 .logo {
  margin-top: -3em;
}
.screen-1 .email {
  background: white;
  box-shadow: 0 0 2em #e6e9f9;
  padding: 1em;
  display: flex;
  flex-direction: column;
  gap: 0.5em;
  border-radius: 20px;
  color: #4d4d4d;
  margin-top: -3em;
}
.screen-1 .email input {
  outline: none;
  border: none;
}
.screen-1 .email input::-moz-placeholder {
  color: black;
  font-size: 0.9em;
}
.screen-1 .email input:-ms-input-placeholder {
  color: black;
  font-size: 0.9em;
}
.screen-1 .email input::placeholder {
  color: black;
  font-size: 0.9em;
}
.screen-1 .email ion-icon {
  color: #4d4d4d;
  margin-bottom: -0.2em;
}
.screen-1 .password {
  background: white;
  box-shadow: 0 0 2em #e6e9f9;
  padding: 1em;
  display: flex;
  flex-direction: column;
  gap: 0.5em;
  border-radius: 20px;
  color: #4d4d4d;
}
.screen-1 .password input {
  outline: none;
  border: none;
}
.screen-1 .password input::-moz-placeholder {
  color: black;
  font-size: 0.9em;
}
.screen-1 .password input:-ms-input-placeholder {
  color: black;
  font-size: 0.9em;
}
.screen-1 .password input::placeholder {
  color: black;
  font-size: 0.9em;
}
.screen-1 .password ion-icon {
  color: #4d4d4d;
  margin-bottom: -0.2em;
}
.screen-1 .password .show-hide {
  margin-right: -5em;
}
.screen-1 .login {
  padding: 1em;
  background: #3e4684;
  color: white;
  border: none;
  border-radius: 30px;
  font-weight: 600;
}
.screen-1 .footer {
  display: flex;
  font-size: 0.7em;
  color: #5e5e5e;
  gap: 14em;
  padding-bottom: 10em;
}
.screen-1 .footer span {
  cursor: pointer;
}

button {
  cursor: pointer;
}
.login_page_logo {
    height: auto;
    width: 300px;
    margin-bottom: 40px;
    text-align: center;
}

    </style>
</head>
<body>

  
<form action="{{route('login')}}" method="post">
 @csrf
  <div class="screen-1">
    <img  src='{{ asset('assets/images/logo1.png')}}' class="login_page_logo">
      <div class="email">
        <label for="email">Email Address</label>
        <div class="sec-2">
          <ion-icon name="mail-outline"></ion-icon>
          <input type="text" name="email" placeholder="Username@gmail.com"/>
        </div>
      </div>
      <div class="password">
        <label for="password">Password</label>
        <div class="sec-2">
          <ion-icon name="lock-closed-outline"></ion-icon>
          <input class="pas" type="password" name="password" placeholder="············"/>
          <ion-icon class="show-hide" name="eye-outline"></ion-icon>
        </div>
      </div>
      <button class="login" type="submit">Login</button>

  </div>
</form>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    @if(session()->has('success'))
            Swal.fire(
            '',
            '{{ session()->get('success') }}!',
            'success');
    @endif
    @if(session()->has('error'))
            Swal.fire(
            '',
            '{{ session()->get('error') }}!',
            'error');
    @endif
</script>
</body>
</html>
