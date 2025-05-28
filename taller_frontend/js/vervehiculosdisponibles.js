const form = document.forms['pepitoForm'];

document.getElementById('formVehiculo').addEventListener('submit', async e => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);

    const res = await fetch("http://127.0.0.1:8000/api/vehiculos/disponible", {
        method: "GET",
        headers: { "Content-Type": "application/json" },
    });

    const result = await res.json();
    alert(result.message || "Lista de vehículos disponibles:", result);
});