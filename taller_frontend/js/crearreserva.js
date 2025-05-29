document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formReservas');

  form.addEventListener('submit', async e => {
    e.preventDefault();

    const categoria = document.getElementById('categoria').value;
    


    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    const fechaInicio = new Date(document.getElementById('fecha_inicio').value);
    const fechaFin = new Date(document.getElementById('fecha_fin').value);
    if(fechaInicio>fechaFin){
      alert("La fecha de inicio no puede ser posterior a la fecha de fin.");
      return;
    }

    const idVehiculo = document.getElementById('vehiculo').value;
      const res = await fetch("http://127.0.0.1:8000/api/reservas", {
        method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
                cliente_id: document.getElementById('cliente').value,
                vehiculo_id: idVehiculo,
                fecha_inicio: document.getElementById('fecha_inicio').value,
                fecha_fin: document.getElementById('fecha_fin').value,
                estado: 'activa' //completada, cancelada
        })
      });

      const result = await res.json();

      if (res.ok) {
        alert(result.data || "Reserva registrada correctamente.");
        form.reset();
      } else {
        alert(result.data || "Error al registrar reserva.");
        console.error(result);
      }


      
      const vehdis = await fetch(`http://127.0.0.1:8000/api/vehiculos/${categoria}`, {
        method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              estado: 'alquilado'    
        })
      });

      const resultveh = await vehdis.json();

      if (vehdis.ok) {
        alert(resultveh.data || "Vehiculo registrado correctamente.");
        form.reset();
      } else {
        alert(resultveh.data || "Error al registrar el estado del vehiculo.");
        console.error(result);
      }
    
    
  });
});
