<?php
   function renderFormRegistration(){
       echo '
           <h2>Registro</h2>
           <form method="POST">
               <input type="text" name="email" placeholder="Ingrese su email..."/>
               <input type="password" name="password" placeholder="Ingrese su password..."/>
               <button>Crear cuenta</button>
           </form>
       ';
   }

   //Imprimir el formulario
   renderFormRegistration();

   //Creo la cuenta cuando venga en el POST
   if(!empty($_POST['email'])&& !empty($_POST['password'])){
       $userEmail=$_POST['email'];
       $userPassword=password_hash($_POST['password'], PASSWORD_BCRYPT);

       //Guardo el nuevo usuario en la base de datos
       $db = new PDO('mysql:host=localhost;'.'dbname=db_users;charset=utf8', 'root', '');
       $query = $db->prepare('INSERT INTO users (email, password) VALUES (? , ?)');
       $query->execute([$userEmail,$userPassword]);
     
   }

   // LOGIN
   function renderFormLogin(){
       echo '
           <h2>Login</h2>
           <form method="POST">
               <input type="text" name="emailLogin" placeholder="Ingrese su email..."/>
               <input type="password" name="passwordLogin" placeholder="Ingrese su password..."/>
               <button>Login</button>
       ';
   }

   //Imprimir el formulario
   renderFormLogin();

    //Creo la cuenta cuando venga en el POST
   if(!empty($_POST['emailLogin'])&& !empty($_POST['passwordLogin'])){
       $userEmailLogin=$_POST['emailLogin'];
       $userPasswordLogin=$_POST['passwordLogin'];

       //Obtengo el usuario de la base de datos
       $db = new PDO('mysql:host=localhost;'.'dbname=db_users;charset=utf8', 'root', '');
       $query = $db->prepare('SELECT * FROM users WHERE email = ?');
       $query->execute([$userEmailLogin]);
       $user = $query->fetch(PDO::FETCH_OBJ);

       //Si el usuario existe y las contraseñas coinciden
       if($user && password_verify($userPasswordLogin,($user->password))){
           echo "Acceso exitoso";
       }else{
           echo "Acceso denegado";
       }
   }
