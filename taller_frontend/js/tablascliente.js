document.addEventListener("DOMContentLoaded", async () => {
  const selectCliente = document.getElementById("cliente");

  if (!selectCliente) return; // Por si se carga en una página donde no hay select

  
    const res = await fetch("http://127.0.0.1:8000/api/clientes", {
      method: "GET",
      headers: { "Content-Type": "application/json" }
    });

    const result = await res.json();
    const clientes = result.data;

    clientes.forEach(cliente => {
      const option = document.createElement("option");
      option.value = cliente.id; // Se envía el ID al backend
      option.textContent = `${cliente.numero_licencia} - ${cliente.nombre}`; // Se muestra esto
      selectCliente.appendChild(option);
    });
  
});
