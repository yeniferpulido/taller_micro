const form = document.forms['eliminarVehiForm']; 

document.getElementById('formVehiculoelim').addEventListener('submit', async e => {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    const categoria = data.categoria.trim();

    if (!categoria) {
        alert("Debes ingresar una placa válida");
        return;
    }

    try {
        const res = await fetch(`http://127.0.0.1:8000/api/vehiculos/${categoria}`, {
            method: "DELETE",
            headers: { "Content-Type": "application/json" },
        });

        const result = await res.json();

        if (res.ok) {
            alert(result.data || "Vehículo eliminado correctamente.");
            form.reset();
        } else {
            alert(result.data || "Error al eliminar vehículo.");
        }
    } catch (error) {
        console.error("Error en la petición:", error);
        alert("Error al comunicarse con el servidor.");
    }
});
