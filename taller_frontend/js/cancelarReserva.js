document.getElementById('formLicencia').addEventListener('submit', async (e) => {
  e.preventDefault();

  const numeroLicencia = document.getElementById('numeroLicencia').value.trim();
  const tabla = document.getElementById('tablaReservas');
  const tbody = document.getElementById('tbodyReservas');

  tbody.innerHTML = '';
  tabla.hidden = true;

  if (!numeroLicencia) {
    alert('Por favor ingresa un número de licencia.');
    return;
  }

  try {
    const res = await fetch(`http://127.0.0.1:8000/api/reservas/activas/${numeroLicencia}`);

    if (res.status === 204) {
      // No Content
      alert('No tienes reservas activas.');
      return;
    }

    if (!res.ok) {
      const errorData = await res.json();
      alert(errorData.mensaje || 'Error al consultar reservas');
      return;
    }

    const reservas = await res.json();

    if (!reservas || reservas.length === 0) {
      alert('No tienes reservas activas.');
      return;
    }

    reservas.forEach(reserva => {
      const fila = document.createElement('tr');
      fila.innerHTML = `
        <td>${reserva.id}</td>
        <td>${reserva.vehiculo}</td>
        <td>${reserva.fecha_inicio}</td>
        <td>${reserva.fecha_fin}</td>
        <td>${reserva.estado}</td>
        <td>
          <button class="btn-cancelar" data-id="${reserva.id}">Cancelar</button>
        </td>
      `;
      tbody.appendChild(fila);
    });

    // Asociar evento a cada botón después de renderizar
    document.querySelectorAll('.btn-cancelar').forEach(btn => {
      btn.addEventListener('click', async () => {
        const id = btn.getAttribute('data-id');
        if (!confirm('¿Seguro que deseas cancelar esta reserva?')) return;

        try {
          const res = await fetch(`http://127.0.0.1:8000/api/reservas/${id}/cancelar`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ estado: 'cancelada' }),
          });

          const data = await res.json();

          if (res.ok) {
            alert('Reserva cancelada exitosamente.');
            setTimeout(() => {
              document.getElementById('formLicencia').dispatchEvent(new Event('submit'));
            }, 300);
          } else {
            alert('Error al cancelar: ' + (data.mensaje || 'Error desconocido'));
          }
        } catch (error) {
          console.error('Error al cancelar reserva:', error);
          alert('No se pudo cancelar la reserva.');
        }
      });
    });

    tabla.hidden = false;

  } catch (error) {
    console.error('Error al consultar reservas:', error);
    alert('Ocurrió un error al obtener las reservas.');
  }
});
