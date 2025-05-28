const form = document.forms['crearvehiculoForm'];

document.getElementById('formVehiculocrear').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    const res = await fetch("http://localhost:8000/api/vehiculos", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            "marca": form['marca'].value,
            "modelo": form['modelo'].value,
            "anio": form['anio'].value,
            "categoria": form['categoria'].value,
            "estado": form['estado'].value,
            //fecha: fechaHoy()
        })
    });

    const result = await res.json();
    alert(result.message || "Vehículo registrado");
});

const fechaHoy = () => {
    const hoy = new Date();
    const anio = hoy.getFullYear();
    const mes = String(hoy.getMonth() + 1).padStart(2, '0'); // Los meses empiezan en 0
    const dia = String(hoy.getDate()).padStart(2, '0');
    return `${anio}-${mes}-${dia}`;
}

localStorage.setItem('idReserva', 1);
const idReserva = localStorage.getItem('idReserva');