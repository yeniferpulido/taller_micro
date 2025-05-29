

window.addEventListener('DOMContentLoaded', async () => {
  console.log("DOM listo");

  const tablaReservas = document.getElementById('tablaReservas');
  const tbodyReservas = document.getElementById('tbodyReservas');

  
    const res = await fetch("http://127.0.0.1:8000/api/reservas", {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    console.log("Fetch hecho, status:", res.status);

    if (!res.ok) {
      console.error("Error al obtener reportes activos");
      return;
    }

    const result = await res.json();
    console.log("Datos recibidos:", result);

    const reportes = result.data;

    if (!reportes || reportes.length === 0) {
      console.log("No hay reportes disponibles para mostrar");
      return;
    }

    tbodyReservas.innerHTML = "";

    reportes.forEach(r => {
      const fila = document.createElement('tr');

      fila.innerHTML = `
        <td>${r.nombreVehiculo || ''}</td>
        <td>${r.nombreCliente || ''}</td>
        <td>${r.fecha_inicio || ''}</td>
        <td>${r.fecha_fin || ''}</td>
        <td>${r.estado || ''}</td>
      `;

      tbodyReservas.appendChild(fila);
    });

    tablaReservas.removeAttribute('hidden');
    console.log("Tabla mostrada");

  
});
