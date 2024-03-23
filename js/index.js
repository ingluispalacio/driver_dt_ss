const driverForm = document.getElementById('driverForm');
let dataTableIsInicialized;
let dataTable;
const fillModalDriver= async(id)=>{
    updateModalDriver(true);
    const data = await getDriverById(id);
    const arrayIdentificacion=data.identification.split(' - ');
    data.identification=arrayIdentificacion[1] == undefined ? "" : arrayIdentificacion[1];
    data.identificationType=arrayIdentificacion[0];
    showInfoFormJSON(data);
}


const updateModalDriver= (update) =>{
    let miBoton = document.getElementById("btnCreateUpdate");
    let modalTitle = document.getElementById("titleModalDriver");

    if (update) {
        miBoton.classList.remove("btn-primary");
        miBoton.classList.add("btn-info");
        miBoton.innerText = "Modificar";
        modalTitle.classList.remove("text-primary");
        modalTitle.classList.add("text-info");
        modalTitle.innerText = "Modificar conductor";
        miBoton.onclick = function() {
            updateDriver();
        };
    } else {
        clearForm(driverForm);
        miBoton.classList.remove("btn-info");
        miBoton.classList.add("btn-primary");
        miBoton.innerText = "Ingresar";
        modalTitle.classList.remove("text-info");
        modalTitle.classList.add("text-primary");
        modalTitle.innerText = "Nuevo conductor";
        miBoton.onclick = function() {
            newDriver();
        };
    }
   
}

const deleteDriver = async (id) =>{
    await alertify.confirm('Eliminar', '¿Estas seguro de eliminar ese conductor?', async ()=>{
        await _deleteDriver(id);
    },
    function(){ }).set('labels', {ok:'Si', cancel:'No'});
}


const updateDriver = async ()=>{
    let validacion=validateForms(); 
    if (validacion) {
        const data=getFormData(driverForm);
        const identification= data.get('identification');
        const identificationType= data.get('identificationType');
        const identificationComplement = `${identificationType} - ${identification}`;

        data.set('identification', identificationComplement);
    
        try {
            const response = await fetch('services/update.service.php', {
                method: 'POST',
                body: data
            });
            const result = await response.json();
            if (result.success) {
                $('#driverModal').modal('hide');
                initDataTableDriver();
                alertify.success(result.message);
            } else {
                console.error(result);
                alertify.error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            return { success: false, message: 'Error en la conexión' };
        }
    }
}



const newDriver = async () => {
    let validacion=validateForms(); 
    if (validacion) {
        const data=getFormData(driverForm);

        const identification= data.get('identification');
        const identificationType= data.get('identificationType');
        const identificationComplement = `${identificationType} - ${identification}`;

        data.set('identification', identificationComplement);

        try {
            const response = await fetch('services/create.service.php', {
                method: 'POST',
                body: data
            });
            const result = await response.json();
            if (result.success) {
                $('#driverModal').modal('hide');
                initDataTableDriver();
                alertify.success(result.message);
            } else {
                console.error(result);
                alertify.error(result.message);
            }
        } catch (error) {
            console.error('Error:', error);
            return { success: false, message: 'Error en la conexión' };
        }
    }
}


const _deleteDriver = async (id) => {
    try {
        const response = await fetch(`services/delete.service.php?driver_id=${id}`);
        const result = await response.json();
        if (result.success) {
            initDataTableDriver();
            alertify.success(result.message);
        } else {
            console.error(result);
            alertify.error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        return { success: false, message: 'Error en la conexión' };
    }
}


const getDriverById = async (id) => {
    try {
        const response = await fetch(`services/listById.service.php?driver_id=${id}`);
        const result = await response.json();
        if (result.success) {
            return result.data; 
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        return { success: false, message: 'Error en la conexión' };
    }
}


const clearForm = (form)=>{
    let formElement = form.elements;
    for (let i = 0; i < formElement.length; i++) {
      let elemento = formElement[i];

      if (elemento.type !== 'button' && elemento.type !== 'submit' && elemento.type !== 'reset') {
        elemento.value = '';
      }
    }
}

const validateForms = () => {
    let forms = document.querySelectorAll('.needs-validation');
    let resultado;
  
    Array.prototype.slice.call(forms).forEach(function (form) {
        resultado=form.checkValidity();
        if (resultado) {
          form.classList.remove('was-validated');
        }else{
          form.classList.add('was-validated');
        }
        
    });
    
    return resultado;
  }

  const showInfoFormJSON=(obj, form)=>{
    try {
        const keys = Object.keys(obj);
        keys.forEach(key => {
            const element = form !== null && form !== undefined ? document.querySelector('#'+form+' #'+key) : document.getElementById(key) ; 
            
            if (element) {
              element.value = obj[key];  
            }
        });
    } catch (error) {
        console.error('Error al parsear el JSON:', error);
    }
  }

  
  const getFormData = (form) => {
    let formElement = form.getElementsByTagName("*");
    let formData = new URLSearchParams();

    for (let i = 0; i < formElement.length; i++) {
        let elemento = formElement[i];

        if (elemento.id) {
            let id = elemento.id;
            let valor = elemento.value || elemento.innerText || elemento.innerHTML;
            if (valor !== '' && valor !== null && valor !== undefined) {
                formData.append(id, valor);
            }
        }
    }

    return formData;
}

const initDataTableDriver =  ()=>{
    if (dataTableIsInicialized) {
        dataTable.destroy();
    }
    
    dataTable = $('#tableDrivers').DataTable({
        "paging":true,
        "processing":true,
        "serverSide":true,
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
        },
        "order": [],
        "info":true,
        "ajax":{
            url:"services/list.php",
            type:"POST",
            data: function(d) {
                d.draw = d.draw;
                d.start = d.start;
                d.length = d.length;
                d.order = d.order;
                var columnNames = ["num",'identification', 'description', 'email', 'state']; 

                for (var i = 0; i < columnNames.length; i++) {
                    d.columns[i].data = columnNames[i];
                }
            }
        },
        "columnDefs": [
            { "orderable": false, "targets": [0] } 
        ],
        createdRow: function (row, data, dataIndex) {
            $(row).find('td:eq(0)').html(dataIndex + 1); 
        }   
    });

    dataTableIsInicialized=true;
}

 ( () => {
    initDataTableDriver();
})();
 