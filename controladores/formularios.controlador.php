<?php  
 class ControladorFormularios{

    static public function ctrRegistro(){
        if (isset($_POST["registroNombre"])){

            $tabla="registros";

            $datos=array( "nombre" => $_POST["registroNombre"],
                          "email" => $_POST["registroEmail"],
                          "password" => $_POST["registroPassword"]);
                          
            $respuesta = ModeloFormularios::mdlRegistro($tabla,$datos);
            return $respuesta;
        }
    }

    static public function ctrSeleccionarRegistros(){
        $tabla="registros";

        $respuesta=ModeloFormularios::mdlSeleccionarRegistro($tabla,null,null);

        return $respuesta;
    }


    public function ctrIngreso(){
        if(isset($_POST["ingresoEmail"])){
            $tabla = "registros";
            $item = "email";
            $valor = $_POST["ingresoEmail"];

            $respuesta = ModeloFormularios::mdlSeleccionarRegistro($tabla,$item,$valor); 
            
            if(is_array($respuesta)){

                if($respuesta["email"] == $_POST["ingresoEmail"] && $respuesta["password"] == $_POST["ingresoPassword"]){

                    $_SESSION["validarIngreso"] ="ok";


                    echo '<script>
                     if(window.history.replaceState){
                        window.history.replaceState(null,null,null,window.location.href);
                     }
                     window.location= "index.php?pagina=home";
                    </script>';
                }else {
                    echo '<script>
                     if(window.history.replaceState){
                        window.history.replaceState(null,null,null,window.location.href);
                     }
                    </script>';
                    echo '<div class="alert alert-danger"> !Error! al ingresar al sistema, el EMAIL o la CONTRASEÑA no coinciden</div>';
                }


            } else {
                echo '<script>
                     if(window.history.replaceState){
                        window.history.replaceState(null,null,null,window.location.href);
                     }
                    </script>';
                 echo '<div class="alert alert-danger">!Error! al ingresar al sistema, el EMAIL o la CONTRASEÑA no coinciden</div>';
                

            }
        }
    }

    
    static public function ctrActualizarRegistro() {
        if (isset($_POST["updateName"])) {
            // Preparar los datos para la actualización
            $tabla = "registros";
            $datos = array(
                "id" => $_POST["id"],
                "nombre" => $_POST["updateName"],
                "email" => $_POST["updateEmail"],
                "password" => $_POST["updatePassword"] != "" ? $_POST["updatePassword"] : $_POST["passwordActual"]
            );

            // Llamar al modelo para actualizar los datos y devolver el resultado
            return ModeloFormularios::mdlActualizarRegistros($tabla, $datos);
        }
    }



    public function ctrEliminarRegistro(){
        if (isset($_POST["deleteRegistro"])) {

            $tabla = "registros";
            $valor = $_POST["deleteRegistro"];


            $respuesta = ModeloFormularios::mdlEliminarRegistro($tabla, $valor);

            if ($respuesta == "ok") {
                echo '<script>
                if (window.history.replaceState){
                    window.history.replaceState(null, null, window.location.href);
                }
                </script>    ';
                echo '<div class="alert-success"> El usuario ha sido Eliminado</div>
                    <script>
                    setTimeout(function(){
                    window.location = "index.php?pagina=inicio";
                    },3000);
                    </script>
                    ';
            }
        }
    }
 }
