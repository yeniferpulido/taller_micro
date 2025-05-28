const form = document.forms['eliminarVehiPlacaForm'];

document.getElementById('formVehiculo').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    const res = await fetch("http://localhost:8000/api/vehiculos/"+$categoria, {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
    });

    const result = await res.json();
    alert(result.message || "Vehiculo eliminado", result);
});