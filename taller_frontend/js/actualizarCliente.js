const buscarForm = document.getElementById('buscarClienteForm');
const formActualizarContainer = document.getElementById('formActualizarContainer');
const formActualizar = document.getElementById('formClienteactu');

buscarForm.addEventListener('submit', async e => {
  e.preventDefault();

  const formData = new FormData(buscarForm);
  const data = Object.fromEntries(formData);
  const clienteBuscar = data.cliente.trim().toLowerCase();

  if (!clienteBuscar) {
    alert("Por favor, ingresa un Numero de licencia valido.");
    return;
  }

  try {
    const res = await fetch(`http://127.0.0.1:8000/api/clientes`, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (!res.ok) {
      alert("Error al obtener el cliente.");
      formActualizarContainer.style.display = "none";
      return;
    }

    const result = await res.json();
    const clientes = result.data;

    const cliente = clientes.find(v => v.numero_licencia.toLowerCase() === clienteBuscar);

    if (!cliente) {
      alert("Cliente no encontrado. Por favor, verifica el numero de licencia.");
      formActualizarContainer.style.display = "none";
      return;
    }

    formActualizarContainer.style.display = "block";

    formActualizar.nombre.value = cliente.nombre || '';
    formActualizar.telefono.value = cliente.telefono || '';
    formActualizar.correo.value = cliente.correo || '';
    formActualizar.numero_licencia.value = cliente.numero_licencia || '';

  } catch (error) {
    console.error("Error en la búsqueda:", error);
    alert("Error al comunicarse con el servidor.");
    formActualizarContainer.style.display = "none";
  }
});

formActualizar.addEventListener('submit', async e => {
  e.preventDefault();

  const formData = new FormData(formActualizar);
  const data = Object.fromEntries(formData);

  try {
    const res = await fetch(`http://127.0.0.1:8000/api/clientes/${data.numero_licencia}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        nombre: data.nombre,
        telefono: data.telefono,
        correo: data.correo,
        numero_licencia: data.numero_licencia
      }),
    });

    const result = await res.json();

    if (res.ok) {
      alert(result.data || "Cliente actualizado correctamente.");
      formActualizarContainer.style.display = "none";
      buscarForm.reset();
      formActualizar.reset();
    } else {
      alert(result.data || "Error al actualizar cliente.");
    }
  } catch (error) {
    console.error("Error al actualizar cliente:", error);
    alert("Error de comunicación con el servidor.");
  }
});
