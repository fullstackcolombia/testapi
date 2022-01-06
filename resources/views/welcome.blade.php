<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.css" rel="stylesheet" type="text/css">
    <title>{{ config('app.name', 'Laravel FSC') }}</title>
  </head>
  <body>
    <!-- Modal -->
	<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="addModalLabel">Agregar empleado</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body">
				<form class="ajax_form_fsc" action="{{url('api/job')}}" method="post" data-msj="El empleado ha sido agregado correctamente." enctype="multipart/form-data">
					{{csrf_field()}}
					{{method_field('POST')}}
					<div class="mb-3">
						<label for="namejob" class="form-label">Puesto de trabajo</label>
						<input id="namejob" name="namejob" type="text" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="code" class="form-label">Código</label>
						<input id="code" name="code" type="text" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="importance" class="form-label">Importancia</label>
						<input id="importance" name="importance" type="text" class="form-control" value="media" required>
					</div>
					<div class="mb-3">
						<label for="is_boss" class="form-label">Es jefe</label>
						<input id="is_boss" name="is_boss" type="text" class="form-control" value="yes" required>
					</div>
					<hr>
					<div class="mb-3">
						<label for="name" class="form-label">Nombre</label>
						<input id="name" name="name" type="text" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="lastname" class="form-label">Apellido</label>
						<input id="lastname" name="lastname" type="text" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="dni" class="form-label">DNI</label>
						<input id="dni" name="dni" type="text" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="date_of_birth" class="form-label">Fecha</label>
						<input id="date_of_birth" name="date_of_birth" type="text" class="form-control" required>
					</div>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-success">Agregar</button>
				</form>
		  </div>
		</div>
	  </div>
	</div>
    
	<div class="container my-5">
	<h2>Cliente API AJAX (Bootstrap 5) <a data-bs-toggle="modal" data-bs-target="#addModal" href="javascript:void(0)" class="btn btn-success btn-sm float-end"> Nuevo</a></h2>
	<form method="post" class="delete-form-fsc d-none" data-msj="<?php echo 'El empleado ha sido eliminado correctamente.'; ?>">{{csrf_field()}}{{method_field('DELETE')}}</form>
	<div class="table-responsive">
	<table id="o_table_fsc" class="table table-striped" style="width:100%" data-url="{{url('api/job')}}">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Correo</th>
            </tr>
        </tfoot>
    </table>
	</div>
	</div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.4/sweetalert2.min.js"></script>
	<script>
	$(document).ready( function () {
		function loginfsc(){
			var formData = new FormData();
			formData.append('csrf_token_name', $("meta[name='X-CSRF-TOKEN']").attr("content"));
			formData.append('email', 'mig@test.com');
			formData.append('password', '123456');
			$.ajax({
				url: 'http://127.0.0.1:8000/api/auth/login',
				data: formData,
				processData: false,
				contentType: false,
				type: 'POST',
				success: function(data){
					console.log(data.access_token);
				}
			});
		}
		loginfsc();
		
		var table_ajax = null;
		table_ajax = $('#o_table_fsc').DataTable({
			"ajax": $('#o_table_fsc').data('url'),
			"columnDefs": [{ targets: 'no-sort', orderable: false }],
			"language": {
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
			}
		});
		$('#o_table_fsc').on( 'xhr.dt', function(e, settings, json, xhr){
			new $.fn.dataTable.Api(settings).one('draw', function () {
				initCompleteFunction(settings, json);
			});
		});
		function initCompleteFunction(settings, json){
			var api = new $.fn.dataTable.Api(settings);
			if($('.ajax_form_fsc').length){
				$('.ajax_form_fsc').on('submit',function(e){
					e.preventDefault();
					var form_x = $(this);
					var formData = new FormData();
					var url_form_x = form_x.prop('action');
					formData.append('csrf_token_name', $("meta[name='X-CSRF-TOKEN']").attr("content"));
					form_x.find('input').each(function(i,v){
						var inp_fm = $(this);
						formData.append(inp_fm.attr('name'), inp_fm.val());
					});
					$.ajax({
						url: url_form_x,
						data: formData,
						processData: false,
						contentType: false,
						type: 'POST',
						success: function(data){
							table_ajax.ajax.reload(null,false);
							form_x[0].reset();
							form_x.parent().parent().parent().parent().modal('hide');
							swal({
								title: 'Mensaje',
								text: form_x.data('msj'),
								type: 'success',
								confirmButtonClass: 'btn btn-success'
							});
						}
					});
				});
			}
		}
	});
	</script>
  </body>
</html>