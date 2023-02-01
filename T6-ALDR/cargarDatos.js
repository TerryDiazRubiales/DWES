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
        
        let tabla = document.getElementById('tabla_cesta');
        
        if (this.readyState == 4 && this.status == 200) {
            // recogemos el json_encode
            // crea una tabla que guarda y muestre
            try {
                let recogeCesta = JSON.parse(this.responseText);
                tabla.innerHTML = "";
                
            } catch (e) {
                
            }
        }
    };
    
    xhttp.open("GET", "cesta_json.php", true);
    xhttp.send();
}

const cargarProducto = () => {
    
}

const crearTablaProductos = (productos) => {
    
}

const crearTablaCesta = (productos) => {
    
}

const crear_fila = (campos, tipo) => {
    const x = document.getElementById();
    
    for (var i=0; i<campos.length; i++) {
        var celda = document.createElement (tipo);
        celda.innerHTML = campos[i];
        x.appendChild(celda);
        
    }
}