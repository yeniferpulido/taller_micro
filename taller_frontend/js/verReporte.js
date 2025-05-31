document.getElementById('formLicencia').addEventListener('submit', async function (e) {
  e.preventDefault();

  const numeroLicencia = document.getElementById('numeroLicencia').value.trim();
  const tabla = document.getElementById('tablaReservas');
  const tbody = document.getElementById('tbodyReservas');

  // Limpiar la tabla
  tbody.innerHTML = '';
  tabla.hidden = true;

  if (!numeroLicencia) {
    alert("Por favor ingresa un número de licencia.");
    return;
  }

  try {
    //  1. Actualizar estados de las reservas automáticamente
    await fetch('http://127.0.0.1:8000/api/reservas/actualizar-estados', {
      method: 'PUT'
    });

    //  2. Luego hacer la consulta por número de licencia
    const res = await fetch(`http://127.0.0.1:8000/api/reservas/${numeroLicencia}`);

    if (!res.ok) {
      alert("Error consultando reservas. Código: " + res.status);
      return;
    }

    const data = await res.json();

    if (data.mensaje) {
      alert(data.mensaje);
      return;
    }

    data.forEach(reserva => {
      const fila = document.createElement('tr');
      fila.innerHTML = `
        <td>${reserva.id}</td>
        <td>${reserva.vehiculo}</td>
        <td>${reserva.fecha_inicio}</td>
        <td>${reserva.fecha_fin}</td>
        <td>${reserva.estado}</td>
      `;
      tbody.appendChild(fila);
    });

    tabla.hidden = false;

  } catch (error) {
    console.error("Error al consultar:", error);
    alert("Ocurrió un error al obtener las reservas.");
  }
});
