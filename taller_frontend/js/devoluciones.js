const tablaBody = document.getElementById("tablaVehiculosBody");

document.addEventListener("DOMContentLoaded", async () => {
  try {
    const res = await fetch("http://127.0.0.1:8000/api/vehiculos/alqmant", {
      method: "GET",
      headers: { "Content-Type": "application/json" }
    });

    if (!res.ok) {
      throw new Error("No se pudo obtener la lista de vehículos");
    }

    const data = await res.json();
    const vehiculos = data.data;

    vehiculos.forEach(vehiculo => {
      const tr = document.createElement("tr");

      tr.innerHTML = `
        <td>${vehiculo.categoria}</td>
        <td>${vehiculo.marca}</td>
        <td>${vehiculo.modelo}</td>
        <td>${vehiculo.anio}</td>
        <td>
          <select data-placa="${vehiculo.categoria}">
            ${generarOpcionesEstado(vehiculo.estado)}
          </select>
        </td>
        <td>
          <button onclick="actualizarEstado('${vehiculo.categoria}')">Guardar</button>
        </td>
      `;

      tablaBody.appendChild(tr);
    });

  } catch (error) {
    console.error("Error:", error);
    alert("No se pudo cargar la lista de vehículos.");
  }
});

function generarOpcionesEstado(actual) {
  const estados = ["disponible", "alquilado", "mantenimiento"];
  return estados.map(e => 
    `<option value="${e}" ${e === actual ? "selected" : ""}>${e}</option>`
  ).join("");
}

async function actualizarEstado(placa) {
  const select = document.querySelector(`select[data-placa="${placa}"]`);
  const nuevoEstado = select.value;

  try {
    const res = await fetch(`http://127.0.0.1:8000/api/vehiculos/${placa}`, {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ estado: nuevoEstado })
    });

    const result = await res.json();

    if (res.ok) {
      alert("Estado actualizado correctamente");
    } else {
      alert("Error al actualizar estado: " + result.data);
    }
  } catch (error) {
    console.error("Error al actualizar:", error);
    alert("No se pudo actualizar el estado.");
  }
}
