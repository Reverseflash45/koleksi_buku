<!DOCTYPE html>
<html>
<head>
    <title>Verify Account</title>
</head>
<body style="font-family:sans-serif; text-align:center; margin-top:100px;">

    <h2>Please verify your account</h2>

    <form action="/verify" method="POST">
        @csrf
        <input type="hidden" name="tipe" value="register">

        <button type="submit">
            Send OTP to your email
        </button>
    </form>

</body>
</html>