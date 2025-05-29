document.addEventListener("DOMContentLoaded", async () => {
    let vehiculos = [];
  const selectVehiculo = document.getElementById("vehiculo");
  if (!selectVehiculo) return;

    const res = await fetch("http://127.0.0.1:8000/api/vehiculos/disponible", {
      method: "GET",
      headers: { "Content-Type": "application/json" }
    });

    if (!res.ok) {
      throw new Error("No se pudo obtener vehículos disponibles");
    }

    const result = await res.json();
    vehiculos = result.data;

    vehiculos.forEach(vehiculo => {
      const option = document.createElement("option");
      option.value = vehiculo.id; 
      option.textContent = `${vehiculo.marca} ${vehiculo.modelo} (${vehiculo.categoria})`; 
      selectVehiculo.appendChild(option);
    });

    document.getElementById('vehiculo').addEventListener('change', ()=>{
        //alert(document.getElementById('vehiculo').value);
        const idVehiculo = document.getElementById('vehiculo').value;
        const vehiculo = vehiculos.find(item=>item.id==idVehiculo);
        if(vehiculo){
            document.getElementById('categoria').value = vehiculo.categoria;
        }
    });
  
});
