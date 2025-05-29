document.getElementById('formFecha').addEventListener('submit', async (e) => {
  e.preventDefault();

  const fecha = document.getElementById('fecha').value;
  const tabla = document.getElementById('tablaVehiculos');
  const tbody = document.getElementById('tbodyVehiculos');

  if (!fecha) {
    alert("Por favor selecciona una fecha.");
    return;
  }

  try {
    const res = await fetch(`http://127.0.0.1:8000/api/vehiculos/disponibles-por-fecha?fecha=${fecha}`);

    if (!res.ok) {
      const error = await res.json();
      alert(error.message || "Error al obtener datos.");
      return;
    }

    const result = await res.json();
    const vehiculos = result.data;

    tbody.innerHTML = "";

    if (!vehiculos || vehiculos.length === 0) {
      tbody.innerHTML = `<tr><td colspan="5">No hay vehículos disponibles ese día.</td></tr>`;
    } else {
      vehiculos.forEach(v => {
        const fila = document.createElement('tr');
        fila.innerHTML = `
          <td>${v.categoria || ''} </td>
          <td>${v.marca || ''}</td>
          <td>${v.modelo || ''}</td>
          <td>${v.anio || ''}</td>
          <td>${v.estado || ''}</td>
        `;
        tbody.appendChild(fila);
      });
    }

    tabla.removeAttribute('hidden');
  } catch (err) {
    console.error("Error al cargar vehículos:", err);
    alert("Error al cargar vehículos.");
  }
});
