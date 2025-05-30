
console.log("JS cargado");

window.addEventListener('DOMContentLoaded', async () => {
  console.log("DOM listo");

  const tablaVehiculos = document.getElementById('tablaVehiculos');
  const tbodyVehiculos = document.getElementById('tbodyVehiculos');

  try {
    const res = await fetch("http://127.0.0.1:8000/api/vehiculos/disponible", {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    console.log("Fetch hecho, status:", res.status);

    if (!res.ok) {
      console.error("Error al obtener vehículos disponibles");
      return;
    }

    const result = await res.json();
    console.log("Datos recibidos:", result);

    const vehiculos = result.data;

    if (!vehiculos || vehiculos.length === 0) {
      console.log("No hay vehículos disponibles para mostrar");
      return;
    }

    tbodyVehiculos.innerHTML = "";

    vehiculos.forEach(v => {
      const fila = document.createElement('tr');

      fila.innerHTML = `
        <td>${v.categoria || ''}</td>
        <td>${v.marca || ''}</td>
        <td>${v.modelo || ''}</td>
        <td>${v.anio || ''}</td>
        <td>${v.estado || ''}</td>
        
        `;

      tbodyVehiculos.appendChild(fila);
    });

    tablaVehiculos.removeAttribute('hidden');
    console.log("Tabla mostrada");

  } catch (error) {
    console.error("Error en la comunicación con el servidor:", error);
  }
});
