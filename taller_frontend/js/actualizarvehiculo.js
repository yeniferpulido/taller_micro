const form = document.forms['actuvehiculoForm'];

document.getElementById('formVehiculoactu').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    const res = await fetch("http://localhost:8000/api/vehiculos/"+$categoria, {
        method: "PUT",
        headers: { "Content-Type": "application/json" },

        body: JSON.stringify({
            "marca": form['marca'].value,
            "modelo": form['modelo'].value,
            "anio": form['anio'].value,
            "categoria": form['categoria'].value,
            "estado": form['estado'].value,
        })
    });

    const result = await res.json();
    alert(result.message || "Vehículo registrado");
});
