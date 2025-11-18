<?php include "app/views/template/header.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial;
            background: #e3e3e3;
        }
        .box {
            width: 350px;
            background: white;
            padding: 20px;
            margin: 80px auto;
            border-radius: 10px;
            box-shadow: 0 0 10px #aaa;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border-radius: 6px;
        }
        button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: none;
            background: #4CAF50;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Login</h2>
    <form action="index.php?page=prosesLogin" method="POST">

    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Login Sebagai</label>
    <select name="role" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="guru">Guru</option>
        <option value="siswa">Siswa</option>
    </select>

    <button type="submit">Login</button>
</form>
</div>

</body>
</html>
<?php include "app/views/template/footer.php"; ?>