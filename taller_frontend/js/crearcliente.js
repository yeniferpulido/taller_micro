const form = document.forms['crearclienteForm'];

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formClientecrear'); 

    form.addEventListener('submit', async e => {
        e.preventDefault();

        const res = await fetch("http://127.0.0.1:8000/api/clientes", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                nombre: document.getElementById('nombre').value,
                telefono: document.getElementById('telefono').value,
                correo: document.getElementById('correo').value,
                numero_licencia: document.getElementById('numero_licencia').value
            })
        });

        const result = await res.json();

        if (res.status === 409) {
            alert(result.data);
        } else if (res.ok) {
            alert(result.data || "Cliente registrado correctamente.");
            form.reset();
        } else {
            alert("Error inesperado");
            console.error(result);
        }
    });
});

