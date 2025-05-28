document.addEventListener('DOMContentLoaded', () => {
    const form = document.forms['eliminarClienteForm'];

    form.addEventListener('submit', async e => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData);
        const numero_licencia = data.numero_licencia.trim();

        if (!numero_licencia) {
            alert("Debes ingresar un número de licencia válido");
            return;
        }

        try {
            const res = await fetch(`http://127.0.0.1:8000/api/clientes/${numero_licencia}`, {
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
            });

            const result = await res.json();

            if (res.ok) {
                alert(result.data || "Cliente eliminado correctamente.");
                form.reset();
            } else {
                alert(result.data || "Error al eliminar cliente.");
            }
        } catch (error) {
            console.error("Error en la petición:", error);
            alert("Error al comunicarse con el servidor.");
        }
    });
});
