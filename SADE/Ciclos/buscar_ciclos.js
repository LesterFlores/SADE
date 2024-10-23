document.getElementById("btn_buscar").addEventListener("click", function() {
    var anio = document.getElementById("anio").value;

    if (anio === "") {
        alert("Por favor seleccione un ciclo.");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "buscar_ciclos.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
        if (xhr.status === 200) {
            document.querySelector(".table-container").innerHTML = xhr.responseText;
        }
    };

    xhr.send("anio=" + anio);
});
