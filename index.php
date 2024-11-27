<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Catálogo de Tablas</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container">
    <div class="jumbotron">
      <h1 class="display-4">Catálogo de Tablas</h1>
      <p class="lead">Listando todas las tablas de la base de datos "PRUEBA".</p>
      <hr class="my-4">
    </div>
    <table class="table table-striped table-responsive">
      <tbody>
        <?php
        // Conexión a la base de datos
        $conexion = mysqli_connect(getenv('MYSQL_HOST'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), "PRUEBA");
        
        if (!$conexion) {
            die("Error al conectar con la base de datos: " . mysqli_connect_error());
        }
        
        $consulta_tablas = "SHOW TABLES";
        $resultado_tablas = mysqli_query($conexion, $consulta_tablas);
        
        if ($resultado_tablas) {
            while ($tabla = mysqli_fetch_row($resultado_tablas)) {
                echo "<h3>Tabla: " . $tabla[0] . "</h3>";
                echo "<table border='1' style='border-collapse: collapse;'>";
                echo "<thead>";
        
                // Obtener las columnas de la tabla
                $consulta_columnas = "SHOW COLUMNS FROM " . $tabla[0];
                $resultado_columnas = mysqli_query($conexion, $consulta_columnas);
        
                echo "<tr>";
                while ($columna = mysqli_fetch_assoc($resultado_columnas)) {
                    echo "<th>" . $columna['Field'] . "</th>";
                }
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
        
                // Obtener los datos de la tabla
                $consulta_datos = "SELECT * FROM " . $tabla[0];
                $resultado_datos = mysqli_query($conexion, $consulta_datos);
        
                while ($fila = mysqli_fetch_assoc($resultado_datos)) {
                    echo "<tr>";
                    foreach ($fila as $valor) {
                        echo "<td>" . htmlspecialchars($valor) . "</td>";
                    }
                    echo "</tr>";
                }
        
                echo "</tbody>";
                echo "</table><br><br>";
            }
        } else {
            echo "Error al obtener las tablas: " . mysqli_error($conexion);
        }
        
        mysqli_close($conexion);
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>

