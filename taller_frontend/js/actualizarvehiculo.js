const buscarForm = document.getElementById('buscarVehiculoForm');
const formActualizarContainer = document.getElementById('formActualizarContainer');
const formActualizar = document.getElementById('formVehiculoactu');

buscarForm.addEventListener('submit', async e => {
  e.preventDefault();

  const formData = new FormData(buscarForm);
  const data = Object.fromEntries(formData);
  const categoriaBuscada = data.categoria.trim().toLowerCase();

  if (!categoriaBuscada) {
    alert("Por favor, ingresa una placa válida.");
    return;
  }

  try {

    const res = await fetch(`http://127.0.0.1:8000/api/vehiculos`, {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    });

    if (!res.ok) {
      alert("Error al obtener vehículos.");
      formActualizarContainer.style.display = "none";
      return;
    }

    const result = await res.json();
    const vehiculos = result.data;

    const vehiculo = vehiculos.find(v => v.categoria.toLowerCase() === categoriaBuscada);

    if (!vehiculo) {
      alert("Vehículo no encontrado. Por favor, verifica la placa.");
      formActualizarContainer.style.display = "none";
      return;
    }

    formActualizarContainer.style.display = "block";

    formActualizar.marca.value = vehiculo.marca || '';
    formActualizar.modelo.value = vehiculo.modelo || '';
    formActualizar.anio.value = vehiculo.anio || '';
    formActualizar.estado.value = vehiculo.estado || '';
    formActualizar.categoria.value = vehiculo.categoria || '';

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
  const categoria = data.categoria.trim().toLowerCase();

  try {
    const res = await fetch(`http://127.0.0.1:8000/api/vehiculos/${categoria}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        marca: data.marca,
        modelo: data.modelo,
        anio: data.anio,
        estado: data.estado
      }),
    });

    const result = await res.json();

    if (res.ok) {
      alert(result.data || "Vehículo actualizado correctamente.");
      formActualizarContainer.style.display = "none";
      buscarForm.reset();
      formActualizar.reset();
    } else {
      alert(result.data || "Error al actualizar vehículo.");
    }
  } catch (error) {
    console.error("Error al actualizar vehículo:", error);
    alert("Error de comunicación con el servidor.");
  }
});
