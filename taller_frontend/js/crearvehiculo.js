const form = document.forms['crearvehiculoForm'];

document.addEventListener('DOMContentLoaded', () => {
    const form = document.forms['crearvehiculoForm'];

    document.getElementById('formVehiculocrear').addEventListener('submit', async e => {
        e.preventDefault();

        
            const res = await fetch("http://localhost:8000/api/vehiculos", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    marca: form['marca'].value,
                    modelo: form['modelo'].value,
                    anio: form['anio'].value,
                    categoria: form['categoria'].value,
                    estado: form['estado'].value,
                })
            });

    const result = await res.json();
    if (res.status === 409) {
        alert(result.data);  
    } else if (res.ok) {
        alert(result.data || "Vehículo registrado correctamente.");
        form.reset();
    } else {
        alert("Error inesperado");
        console.error(result);
    }   
    });
});



const fechaHoy = () => {
    const hoy = new Date();
    const anio = hoy.getFullYear();
    const mes = String(hoy.getMonth() + 1).padStart(2, '0'); // Los meses empiezan en 0
    const dia = String(hoy.getDate()).padStart(2, '0');
    return `${anio}-${mes}-${dia}`;
}

