<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!--    Datatables  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  
    <link href="alertify/css/alertify.css" rel="stylesheet">
    <link href="alertify/css/themes/default.css" rel="stylesheet">
    <title>Conductores</title>

  
  </head>
  <body>
    <div class="container">
       <div class="row">
           <div class="col-lg-12">
           <div class="card shadow mt-5">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h3 class="m-0 font-weight-bold text-primary">Conductores</h3>
                        <div class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#driverModal" onclick="updateModalDriver(false)">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Nuevo</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tableDrivers" class="table table-striped  table-condensed" style="width:100%">
                            <thead class="text-center">
                                <tr>
                                    <th>#</th>
                                    <th>Identificacion</th>
                                    <th>Descripcion</th>  
                                    <th>Email</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table> 
                    </div>
                </div>
            </div>
           </div>
       </div> 
    </div>

    <div class="modal fade" id="driverModal" tabindex="-1" role="dialog" aria-labelledby="titleModalDriver"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleModalDriver"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <div class="modal-body">               
                    <form class="user needs-validation" id="driverForm" novalidate>
                        <input type="hidden" id="id" value="" />
                        <div class="p-1">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="identificationType" class="form-label">Tipo Identificacion</label>
                                    <select class="form-control" id="identificationType" required>
                                        <option value="CC" selected>CC</option>
                                        <option value="CE">CE</option>
                                        <option value="NIT">NIT</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Selecciona un Tipo Identificacion válido.
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="identification" class="form-label">Identificacion</label>
                                    <input type="text" class="form-control" id="identification" required>
                                    <div class="invalid-feedback">
                                      ingrese una identificacion
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="description" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="description" required>
                                    <div class="invalid-feedback">
                                        Proporciona una telefono válido.
                                    </div>
                                
                            </div>
                            <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email">
                              
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label for="phone" class="form-label">Telefono</label>
                                    <input type="number" class="form-control" id="phone" >
                                    <div class="invalid-feedback">
                                        Proporciona una telefono válido.
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="state" class="form-label">Estado</label>
                                    <select class="form-control" id="state" required>
                                        <option value="Activo" selected>Activo</option>
                                        <option value="Inactivo">Inactivo</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Selecciona un estado válido.
                                    </div>
                                </div>
                            </div>
                            
                           
                        </div> 
                    </form>
                    
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <button class="btn" type="button" id="btnCreateUpdate" onclick="updateDriver()"></button>
                </div>
            </div>
        </div>
    </div>
   
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      
      
<!--    Datatables-->
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script> 
    <script src="alertify/alertify.js"></script> 
    <script src="js/index.js"></script>  
      
    
      
  </body>
</html>