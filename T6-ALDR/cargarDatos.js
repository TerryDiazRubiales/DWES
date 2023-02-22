/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */
const d = document;

window.addEventListener('load', () => {
    cargarProductos();
    cargarCesta();
});

const anadirProducto = (cod) => {
    let $input = d.querySelector("[data-codigo='"+cod+"']");
    let unidades = $input.value;
    $input.value = '';
    let codigo = cod;
    
    let parametros = "cod="+codigo+"&unid="+unidades;
    
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            return;
        }
    };
        
    xhttp.open("POST", "anadir_json.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(parametros);
    
    cargarCesta();
}

const cargarCesta = () => {
    var xhttp = new XMLHttpRequest();
    
    xhttp.onreadystatechange = function () {
        
        
        if (this.readyState == 4 && this.status == 200) {
            // recogemos el json_encode
            // crea una tabla que guarda y muestre
             let cesta = JSON.parse(xhttp.responseText);
            mostrarCesta(cesta);
        }
    };
    
    xhttp.open("GET", "./cesta_json.php", true);
    xhttp.send();
}

const mostrarCesta = (cesta) => {
    
    // borrar la tabla si existe, para crearla de nuevo actualizada
    let $divCesta = d.getElementById('cesta');
    let $div = $divCesta.querySelector('div');
    
    if ($div) {
        $div.remove();
    }
    
    let $p = $divCesta.querySelector('p')
    if($p){
        $p.remove();
    }

    let $hr = $divCesta.querySelector('hr');

 
    if (Object.keys(cesta).length <= 0) {
        $p = d.createElement('p');
        $p.textContent = "Cesta Vacía";
        $hr.insertAdjacentElement('afterend',$p);
        
    } else {
        $p = d.createElement('p');
        $p.textContent = "Cesta Llena";
        
        $div = d.createElement('div');
        $hr.insertAdjacentElement('afterend', $div);
        
        let $tablaCesta = d.createElement('table');
        $tablaCesta.setAttribute('class','table');
        $div.appendChild($tablaCesta)

        let $thead = d.createElement('thead')
        $tablaCesta.appendChild($thead)

        let $trCabecera = d.createElement('tr')
        $thead.appendChild($trCabecera)

        let $tdCabeceraCodigo = d.createElement('td')
        $tdCabeceraCodigo.textContent = 'Código'
        $trCabecera.appendChild($tdCabeceraCodigo)

        let $tdCabeceraNombre = d.createElement('td')
        $tdCabeceraNombre.textContent = 'Nombre'
        $trCabecera.appendChild($tdCabeceraNombre)

        let $tdCabeceraPrecio = d.createElement('td')
        $tdCabeceraPrecio.textContent = 'Precio'
        $trCabecera.appendChild($tdCabeceraPrecio)

        let $tdCabeceraUnidades = d.createElement('td')
        $tdCabeceraUnidades.textContent = 'Unidades'
        $trCabecera.appendChild($tdCabeceraUnidades)
       
        let $tdCabeceraEliminar = d.createElement('td')
        $tdCabeceraEliminar.textContent = 'Eliminar'
        $trCabecera.appendChild($tdCabeceraEliminar)
        
        
        let $tbody = d.createElement('tbody')
        $thead.insertAdjacentElement('afterend',$tbody)
        
        Object.entries(cesta).forEach(([key,value])=> {
            
            let $trProducto = d.createElement('tr')
            $tbody.insertAdjacentElement('beforeend', $trProducto)
            
            let $tdCodigoProducto = d.createElement('td')
            $tdCodigoProducto.textContent = value.producto.codigo
            $trProducto.insertAdjacentElement('beforeend', $tdCodigoProducto)
            
            let $tdNombreProducto = d.createElement('td')
            $tdNombreProducto.textContent = value.producto.nombre_corto
            $trProducto.insertAdjacentElement('beforeend', $tdNombreProducto)
            
            let $tdPVPProducto = d.createElement('td')
            $tdPVPProducto.textContent = value.producto.PVP
            $trProducto.insertAdjacentElement('beforeend', $tdPVPProducto)
            
            let $tdUnidadesProducto = d.createElement('td')
            $tdUnidadesProducto.textContent = value.unidades
            $trProducto.insertAdjacentElement('beforeend', $tdUnidadesProducto)
            
            let $tdEliminarProducto = d.createElement('td')
            $trProducto.insertAdjacentElement('beforeend', $tdEliminarProducto)
           
            let $formularioEliminar = d.createElement('form')
            $formularioEliminar.id = 'eliminar'
            $formularioEliminar.method = 'POST'
            $tdEliminarProducto.insertAdjacentElement('beforeend', $formularioEliminar)
            
            let $btnEliminar = d.createElement('input')
            $formularioEliminar.appendChild($btnEliminar)
            $btnEliminar.type = 'submit'
            $btnEliminar.id = 'erase'
            $btnEliminar.name = value.producto.codigo
            $btnEliminar.value = 'Eliminar'
            
            $formularioEliminar.addEventListener('submit', ev => {
               ev.preventDefault()
                eliminarProducto(value.producto.codigo)
            })
            
        })
        
        let $formularioComprar = d.createElement('form')
        $div.insertAdjacentElement('beforeend',$formularioComprar)
        $formularioComprar.id = 'comprar'
        $formularioComprar.action = "./cesta.php"
        $formularioComprar.method = 'POST'
        
        let $btnComprar = d.createElement('input')
        $formularioComprar.appendChild($btnComprar)
        $btnComprar.type = 'submit'
        $btnComprar.name = 'comprar'
        $btnComprar.value = 'Comprar'
        
        let $formularioVaciar = d.createElement('form')
        $tablaCesta.insertAdjacentElement('afterend',$formularioVaciar)
        $formularioVaciar.id = 'vaciar'
        $formularioVaciar.action = "./listado_productos.php?vaciar=1"
        $formularioVaciar.method = 'POST'
        
        let $btnVaciar = d.createElement('input')
        $formularioVaciar.appendChild($btnVaciar)
        $btnVaciar.type = 'submit'
        $btnVaciar.name = 'vaciar'
        $btnVaciar.value = 'Vaciar Cesta'
    }

}

const cargarProductos = () => {
    let xhttp = new XMLHttpRequest()
    let productos = '';

    xhttp.addEventListener('readystatechange', e => {
        // continuar hasta que readyState sea 4
        if (xhttp.readyState !== 4)
            return
        // si código éxito 200 - 299
        if (xhttp.status >= 200 && xhttp.status < 300) {
            productos = JSON.parse(xhttp.responseText)
            crearTablaProductos(productos)
        } else {
            let message = xhttp.statusText || "Ocurrió un error"
            error(message) // hacer algo con el error
        }
    })
    xhttp.open('GET', './productos_json.php', true);
    xhttp.send();
    
    crearTablaProductos(productos);
}

const crearTablaProductos = (productos) => {

    if (productos.length > 0) {
        // contenedor listado productos 
        let $div = d.getElementById('productos')

        // crear tabla
        let $table = d.createElement('table')
        $div.appendChild($table);

        // crear cabecera de la tabla
        let $thead = d.createElement('thead')
        $table.appendChild($thead)

        let $tr = d.createElement('tr')
        $thead.appendChild($tr)

        let $thAdd = d.createElement('th')
        $thAdd.textContent = 'Añadir'
        $tr.insertAdjacentElement('beforeend', $thAdd)

        let $thCodigo = d.createElement('th')
        $thCodigo.textContent = 'Código'
        $tr.insertAdjacentElement('beforeend', $thCodigo)

        let $thNombre = d.createElement('th')
        $thNombre.textContent = 'Nombre'
        $tr.insertAdjacentElement('beforeend', $thNombre)

        let $thPVP = d.createElement('th')
        $thPVP.textContent = 'PVP'
        $tr.insertAdjacentElement('beforeend', $thPVP);

        let $tbody = d.createElement('tbody')
        $thead.insertAdjacentElement('afterend', $tbody)

        productos.forEach(producto => {
            let $fila = crearFila(producto);
            $tbody.insertAdjacentElement('beforeend', $fila);
        });
    }
}

const crearFila = (producto) => {

    // crear una fila de producto 
    let $fila = d.createElement('tr');

    //crear formulario en cada fila
    //crearFormulario(textoBoton, codProducto, funcion) // la funcion añadir producto
    let codigoProducto = producto.codigo
    let $tdFormulario = crearFormulario('Añadir', codigoProducto);
    $fila.insertAdjacentElement('beforeend', $tdFormulario);

    let $tdCod = d.createElement('td')
    $tdCod.textContent = producto.codigo
    $fila.insertAdjacentElement('beforeend', $tdCod)

    let $tdNombre = d.createElement('td')
    $tdNombre.textContent = producto.nombre_corto
    $fila.insertAdjacentElement('beforeend', $tdNombre)

    let $tdPVP = d.createElement('td')
    $tdPVP.textContent = producto.PVP;
    $fila.insertAdjacentElement('beforeend', $tdPVP)  

    // retorna un tr
    return $fila;
}

const crearFormulario = (textoBtn, codProducto) => {

    let $td = d.createElement('td');

    let $formAdd = d.createElement('form');
    $td.appendChild($formAdd);

    let $input = d.createElement('input');
    $input.setAttribute('type', 'number')
    $input.setAttribute('name', 'unid')
    $input.setAttribute('min', 1)
    $input.dataset.codigo = codProducto
    $input.id = 'unidades'
    $formAdd.appendChild($input)

    let $btn = d.createElement('input')
    $btn.setAttribute('type', 'submit')
    $btn.setAttribute('name', 'add')
    $btn.setAttribute('value', textoBtn)
    $formAdd.insertAdjacentElement('beforeend', $btn)

    $formAdd.addEventListener('submit', ev => {
        // evitar que recargue la página
        ev.preventDefault()
        anadirProducto(codProducto)
    });

    return $td;
}

const eliminarProducto = (cod) => {
    
    // objeto a enviar en el post ( formato : "cod=CODIGO" )
    let data = "cod=" + cod
    // hacer una petición POST
    let xhttp = new XMLHttpRequest()

    xhttp.addEventListener('readystatechange', e => {
        // continuar hasta que readyState sea 4
        if (xhttp.readyState !== 4)
            return;
        // si código éxito 200 - 299
        if (xhttp.status >= 200 && xhr.status < 300) {
            console.log(xhr.responseText)
        } else {
            let message = xhr.statusText || "Ocurrió un error"
            error(message) // hacer algo con el error
        }
    })
    xhttp.open('POST', './eliminar_json.php', true)
    xhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded; charset=utf-8')
    xhttp.send(data);

    cargarCesta();
}
