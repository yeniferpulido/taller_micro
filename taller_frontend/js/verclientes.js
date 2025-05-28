document.addEventListener("DOMContentLoaded", async () => {
  const tabla = document.getElementById("tablaCliente");
  const tbody = document.getElementById("tbodyClientes");

  try {
    const res = await fetch("http://127.0.0.1:8000/api/clientes", {
      method: "GET",
      headers: {
        "Content-Type": "application/json"
      }
    });

    if (!res.ok) {
      throw new Error("Error al obtener los clientes");
    }

    const result = await res.json();
    const clientes = result.data;

    if (clientes.length === 0) {
      alert("No hay clientes registrados.");
      return;
    }


    tabla.hidden = false;

    clientes.forEach(cliente => {
      const row = document.createElement("tr");

      row.innerHTML = `
        <td>${cliente.nombre}</td>
        <td>${cliente.telefono}</td>
        <td>${cliente.correo}</td>
        <td>${cliente.numero_licencia}</td>
      `;

      tbody.appendChild(row);
    });

  } catch (error) {
    console.error("Error al cargar clientes:", error);
    alert("Hubo un error al cargar los clientes.");
  }
});
