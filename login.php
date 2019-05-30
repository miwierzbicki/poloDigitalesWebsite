<?php
// Initialize the session
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "config.ini";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if empty
      if(empty(trim($_POST["username"]))){
        $username_err = "Por favor introduzca su nombre de usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
      if(empty(trim($_POST["password"]))){
      $password_err = "Por favor introduzca su password.";
    } else{
      $password = trim($_POST["password"]);
    }
      if(empty(trim($_POST["nombre"]))){
        $nombre_err = "Por favor introduzca su nombre.";
    } else{
        $nombre = trim($_POST["nombre"]);
    }
      if(empty(trim($_POST["apellido"]))){
        $apellido_err = "Por favor introduzca su apellido.";
    } else{
        $apellido = trim($_POST["apellido"]);
    }
      if(empty(trim($_POST["genero"]))){
        $genero_err = "Por favor introduzca su genero.";
    } else{
        $genero = trim($_POST["genero"]);
    }
      if(empty(trim($_POST["nacimiento"]))){
        $nacimiento_err = "Por favor introduzca su fecha de nacimiento.";
    } else{
        $nacimiento = trim($_POST["nacimiento"]);
    }
      if(empty(trim($_POST["correo"]))){
        $correo_err = "Por favor introduzca su correo.";
    } else{
        $correo = trim($_POST["correo"]);
    }
      if(empty(trim($_POST["telefono"]))){
        $telefono_err = "Por favor introduzca su telefono.";
    } else{
        $telefono = trim($_POST["telefono"]);
    }
      if(empty(trim($_POST["pais"]))){
        $pais_err = "Por favor introduzca su pais.";
    } else{
        $pais = trim($_POST["pais"]);
    }
      if(empty(trim($_POST["localidad"]))){
        $localidad_err = "Por favor introduzca su localidad.";
    } else{
        $localidad = trim($_POST["localidad"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            $username_err = "El nombre no existe";
                        }
                    }
                } else{
                  // in case the password does not match
                    $password_err = "La seña no es correct";
                }
            } else{
              // in case the problem is neither the name or the password
                echo "Ha ocurrido un erro";
            }

      mysqli_stmt_close($stmt);
    }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

        <link rel="stylesheet" href="main2.css">
        <meta charset="utf-8">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
            <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                            <a class="navbar-brand" href="index.html">TEKNE </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                              <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                              <ul class="navbar-nav">
                               
                                <li class="nav-item active">
                                  <a class="nav-link" href="login.html">Login</a>
                                </li>


                              </ul>
                            </div>
                          </nav>
                    <div class="d-flex justify-content-center h-100">
                        <div class="card">
                            <div class="card-header">
                                <h3>Iniciar sesión</h3>
                            </div>
                            <div class="card-body">
                                    <div class="alert alert-warning" role="alert">
                                            Por favor inicie sesión
                                          </div>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <div class="input-group form-group <?php echo(!empty($username_err)) ? 'has-error' : '';?>">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="login" id="login" name="username" value"<?php  echo $username; ?>">
                                        <Span class="help-block"><?php echo $username_err; ?></span>
                                    </div>

                                    <div class="input-group form-group  <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" name="password" class="form-control" placeholder="Contraseña">
                                        <span class="help-block"><?php echo $password_err; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <input type="submit" value="Login" class="btn float-right login_btn" id="password">
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center links">
                                      ¿Quieres ser un probador?"  <a href="register.php"> Incluir</a>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
