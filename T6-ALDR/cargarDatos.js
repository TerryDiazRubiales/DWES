/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

const boton = document.querySelector("#java");

boton.addEventListener("click", anadirProducto);

const anadirProducto = (evento) => {
    let codigo_producto = evento.cod.value;
    let unidades_producto = evento.unidades.value;
    
    let parametros = "codigo = "+codigo_producto+"&unidades = "+unidades_producto;
    
    var xhttp = new XMLHttpRequest();
    
    
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            cargarCesta();
        }
    };
        
    xhttp.open("POST", "anadir_json.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parametros);
    
    return false;
}

const cargarCesta = () => {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            // recogemos el json_encode
            var filas = JSON.parse(this.responseText);
            // crea una tabla que guarda y muestre
        }
    };
    
    xhttp.open("GET", "cesta_json.php", true);
    xhttp.send();
}