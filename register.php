<?php
// Include config file
require_once "config.ini";

// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$nombre ="";
$nombre_err="";
$apellido="";
$apellido_err="";
$genero="";
$genero_err="";
$nacimiento_err="";
$nacimiento_err="";
$correo="";
$correo_err="";
$telefono="";
$telefono_err="";
$pais="";
$pais_err="";
$localidad="";
$localidad_err="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

            if(isset($_POST['name']) && !empty($_POST['name']) and isset($_POST['password']) && !empty($_POST['password'])){

    }
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);

        // Close statement
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Validate nombre
    if(empty(trim($_POST["nombre"]))){
        $nombre_err = "Por favor insira su nombre.";
    } else{
        $nombre = trim($_POST["nombre"]);
    }
    // Validate apellido
    if(empty(trim($_POST["apellido"]))){
        $apellido_err = "Por favor insira su apellido.";
    } else{
        $apellido = trim($_POST["apellido"]);
    }
    // Validate nacimiento
    if(empty(trim($_POST["nacimiento"]))){
        $nacimiento_err = "Por favor insira su nacimiento.";
    } else{
        $nacimiento = trim($_POST["nacimiento"]);
    }
    // Validate correo
    if(empty(trim($_POST["correo"]))){
        $correo_err = "Por favor insira su correo.";
    } else{
        $correo = trim($_POST["correo"]);
    }
    // Validate telefono
    if(empty(trim($_POST["telefono"]))){
        $telefono_err = "Por favor insira su telefono.";
    } else{
        $telefono = trim($_POST["telefono"]);
    }
    // Validate pais
    if(empty(trim($_POST["pais"]))){
        $pais_err = "Por favor insira su pais.";
    } else{
        $pais = trim($_POST["pais"]);
    }
    // Validate localidad
    if(empty(trim($_POST["localidad"]))){
        $localidad_err = "Por favor insira su localidad.";
    } else{
        $localidad = trim($_POST["localidad"]);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, nombre, apellido) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $username, $param_password, $nombre, $apellido);

            // Set parameters
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($link);
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="main4.css">
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<body>
    <div class="container">

      <div class="card bg-light">
      <article class="card-body mx-auto" style="max-width: 500px;">
          <h4 class="card-title mt-3 text-center">Registrarse</h4>
          <p class="text-center">Únete a los probadores beta</p>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group input-group input-group-lg <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
              <div class="input-group-prepend">
              <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                </div>
              <input type="text" name="username" class="form-control" placeholder="Nombre de usuario" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>

                <div class="form-group input-group input-group-lg <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                  <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-envelope"></i></span>
                  </div>
                <input type="password" name="password" placeholder="Contrasena" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>

            <div class="form-group input-group input-group-lg <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <div class="input-group-prepend">
                  <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                </div>
                <input type="password" name="confirm_password" placeholder="Confirme su contrasena" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>

            <div class="form-group input-group input-group-lg <?php echo (!empty($nombre_err)) ? 'has-error' : ''; ?>">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-phone"></i></span>
              </div>
            <input type="text" name="nombre" placeholder="Nombre" class="form-control" value="<?php echo $nombre; ?>">
            <span class="help-block"><?php echo $nombre_err; ?></span>
        </div>

        <div class="form-group input-group input-group-lg <?php echo (!empty($apellido_err)) ? 'has-error' : ''; ?>">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-phone"></i></span>
          </div>
          <input type="text" name="apellido" placeholder="Apellido" class="form-control" value="<?php echo $apellido; ?>">
          <span class="help-block"><?php echo $apellido_err; ?></span>
        </div>

        <div class="form-group input-group input-group-lg <?php echo (!empty($nacimiento_err)) ? 'has-error' : ''; ?>">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-phone"></i></span>
          </div>
          <input type="date" name="nacimiento" placeholder="Fecha de nacimiento" class="form-control" value="<?php echo $nacimiento; ?>">
          <span class="help-block"><?php echo $nacimiento_err; ?></span>
        </div>

        <div class="form-group input-group input-group-lg <?php echo (!empty($correo_err)) ? 'has-error' : ''; ?>">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-phone"></i></span>
          </div>
          <input type="text" name="correo" placeholder="Correo" class="form-control" value="<?php echo $correo; ?>">
          <span class="help-block"><?php echo $correo_err; ?></span>
        </div>

        <div class="form-group input-group input-group-lg <?php echo (!empty($telefono_err)) ? 'has-error' : ''; ?>">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-phone"></i></span>
          </div>
          <input type="text" name="telefono" placeholder="Telefono" class="form-control" value="<?php echo $telefono; ?>">
          <span class="help-block"><?php echo $telefono_err; ?></span>
        </div>

        <div class="form-group input-group input-group-lg <?php echo (!empty($pais_err)) ? 'has-error' : ''; ?>">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-phone"></i></span>
          </div>
          <input type="text" name="pais" placeholder="País" class="form-control" value="<?php echo $pais; ?>">
          <span class="help-block"><?php echo $pais_err; ?></span>
        </div>

        <div class="form-group input-group input-group-lg <?php echo (!empty($localidad_err)) ? 'has-error' : ''; ?>">
          <div class="input-group-prepend">
            <span class="input-group-text"> <i class="fa fa-phone"></i></span>
          </div>
          <input type="text" name="localidad" placeholder="Localidad" class="form-control" value="<?php echo $localidad; ?>">
          <span class="help-block"><?php echo $localidad_err; ?></span>
        </div>

        <div class="form-group input-group <?php echo (!empty($genero)) ? 'has-error' : '';?>">
          <div class="input-group-prepend">
            <div class="input-group-text">
              <input type="radio" name="radio">
            <input class="form-control" id="disabledInput" type="text" placeholder="Hombre" value="<?php echo $genero?>" readonly>
          </div>
            <div class="input-group-prepend">
            </div>
              <div class="input-group-text">
                <input type="radio" name="radio">
                <input class="form-control" id="disabledInput" type="text" placeholder="Mujer" value="<?php echo $genero?>" readonly>
              </div>
            </div>
          </div>
            <!--

            Actividad Profissonal: SI,NO
            Gestionas equipos o Personas?,Si,No
            Aspiras a ello?  Si No


            -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block" value="Submit">Crear Cuenta</button>
<!-- empty form <Button type="reset" class="btn btn-warning" value="Reset">Borrar</button>    -->
            </div>
            <p class="text-center">Tienete una cuenta? <a href="login.php">Log In</a>.</p>
        </form>
      </article>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
