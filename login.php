<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- dibawah ini dua file buat css -->
    <link rel="stylesheet" href="style/login-header.css">
    <link rel="stylesheet" href="style/body-login.css">

      
</head>

<body>
   <header>
   
    <nav class="navigasi">
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Services</a>
        <a href="#">Contact</a>
        
       
    </nav>
    
    <a href="#" class="reg-link"> <!-- This is a comment -->
        <button class="popUp-reg">Sign up</button>
    </a>
    
   </header>

    <!-- berikut komponen" utama di halaman login mulai dari kotak/container login dan sign up -->
    <!-- inget div itu kaya bungkus, jd setiap kita mau bikin objek baru dalam web kita bungkus dengan div dlu trs div tsbt dikasi atribut class biar bsa kita edit" di css -->
    <div class="main">

        <!-- container kotak login -->
        <div class="form-box login">
            <h1>LOGIN</h1>
            <form action="database/check.php" method="POST"> <!-- form itu buat kalo tar klik tombol login ganti halaman ke halaman main-menu -->
                <div class="input-box">
                    <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                    <input type="text" placeholder="" required name="myNim" id="myNim">
                    <label>Username</label>
                </div>

               
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" placeholder="" required name="myPassword">
                    <label>password</label>
                </div>
                
                <div class="error-box">
                    <p ><?php if (isset($_GET['error'])) echo htmlspecialchars($_GET['error']); ?></p>
                </div>

                <div class="inget-pass">
                    <label><input type="checkbox"> Remember me</label>
                    <a href="#"> forgot password?</a>
                </div>
                
                
                <button type="submit" class="tombol-submit">Login</button>
            </form>
        </div>



        <!-- container kotak sign-up -->
        <div class="form-box register">
            <h1>SIGN-UP</h1>
            <form action="database/insert.php" method="POST">
                <div class="input-box">
                    <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
                    <input type="text" placeholder="" required name="username">
                    <label>username</label>
                </div>

                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="text" placeholder="" required name="Email">
                    <label>Email</label>
                </div>

               
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" placeholder="" required name="password">
                    <label>password</label>
                </div>

                <div class="box-drop">
                    <label for="category">Choose a category:</label>
                    <select id="category" name="category">
                        <option value="Peminjam">Meminjam</option>
                        <option value="Penyewa">Menyewakan</option>
                    </select>
                </div>
                

                <div class="inget-pass">
                    <label><input type="checkbox" required> I agree to the terms & conditions</label>
                </div>

                <button type="submit" class="tombol-submit" >Sign-Up</button>
            </form>
        </div>
        
    </div>



    <script src="scripts/login.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</body>
</html>