document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formFecha');
  const tabla = document.getElementById('tablaVehiculos');
  const tbody = document.getElementById('tbodyVehiculos');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const fecha = form.fecha.value;

    if (!fecha) {
      alert('Por favor selecciona una fecha.');
      return;
    }

    try {
      const res = await fetch(`http://127.0.0.1:8000/api/vehiculos/alquilados-por-fecha?fecha=${fecha}`);

      if (!res.ok) {
        const errorData = await res.json();
        throw new Error(errorData.message || 'Error al consultar los vehículos');
      }

      const data = await res.json();

      tbody.innerHTML = '';

      if (!data.data || data.data.length === 0) {
        tabla.hidden = true;
        alert('No hay vehículos alquilados en esa fecha.');
        return;
      }

      tabla.hidden = false;

      data.data.forEach((vehiculo) => {
        const tr = document.createElement('tr');

        tr.innerHTML = `
          <td>${vehiculo.categoria || 'N/A'}</td>
          <td>${vehiculo.marca}</td>
          <td>${vehiculo.modelo}</td>
          <td>${vehiculo.anio}</td>
          <td>${vehiculo.estado}</td>
        `;

        tbody.appendChild(tr);
      });

    } catch (error) {
      alert('Error: ' + error.message);
      tabla.hidden = true;
    }
  });
});
