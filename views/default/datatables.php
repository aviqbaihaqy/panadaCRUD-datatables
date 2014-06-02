<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h3 class="page-header"><?= $title?></h3>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<!-- /.row -->
	<div class="row">
		<div class="col-lg-12">
			<?php 
			if($form):
				if (isset($messages)) :
					?>
				<div class="alert alert-success alert-dismissable">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<?= $messages ?> 
				</div>
			<?php endif; ?>
			<form class="form-horizontal" method="post" action="">
				<fieldset>
					<!-- Text input-->
					<div class="form-group <?=$validasi->errorMessages('NIDNNTBDOS') ? 'has-error' : 'has-success'?>">
						<label class="col-md-4 control-label" for="data[NIDNNTBDOS]">NIDN DOSEN</label>  
						<div class="col-md-5">
							<input id="NIDNNTBDOS" name="NIDNNTBDOS" type="text" placeholder="NIDN DOSEN" class="form-control input-md" value="<?=  $v=(isset($value))? $value['NIDNNTBDOS'] : $validasi->value('NIDNNTBDOS');?>" >
							<?= $validasi->errorMessages('NIDNNTBDOS', '<span class="help-block">', '</span>');?>
						</div>
					</div>

					<!-- Text input-->
					<div class="form-group <?=$validasi->errorMessages('NMDOSTBDOS') ? 'has-error' : 'has-success'?>">
						<label class="col-md-4 control-label" for="NMDOSTBDOS">NAMA DOSEN</label>  
						<div class="col-md-5">
							<input id="NMDOSTBDOS" name="NMDOSTBDOS" type="text" placeholder="NAMA DOSEN" class="form-control input-md" value="<?= $v=(isset($value))? $value['NMDOSTBDOS'] : $validasi->value('NMDOSTBDOS');?>" >
							<?= $validasi->errorMessages('NMDOSTBDOS', '<span class="help-block">', '</span>');?>
						</div>
					</div>

					<!-- Button (Double) -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="submit"></label>
						<div class="col-md-8">
							<button id="submit" name="submit" type="submit" class="btn btn-primary" name="datatables">Save</button>
							<button id="Cancel" name="Cancel" type="reset" class="btn btn-warning">Cancel</button>
						</div>
					</div>

				</fieldset>
			</form>

			<?php
			var_dump((isset($validate))? $validate :"No Data");
			else:
				?>
			<div class="table-responsive">
				<table id="datatables" class="table table-striped table-bordered table-hover table-condensed">
					<thead>
						<tr>
							<th>NIDNNTBDOS</th>
							<th>NOKTPTBDOS</th>
							<th>NMDOSTBDOS</th>
							<th>TPLHRTBDOS</th>
							<th>TGLHRTBDOS</th>
						</tr>
						<tr>
							<th>NIDNNTBDOS</th>
							<th>NOKTPTBDOS</th>
							<th>NMDOSTBDOS</th>
							<th>TPLHRTBDOS</th>
							<th>TGLHRTBDOS</th>
						</tr>
					</thead>
				</table>
			</div>
			<!-- /.table-responsive -->
			<?php 
			endif;
			?>
		</div>
		<!-- /.col-lg-12 -->
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {

		var editor = new $.fn.dataTable.Editor( {
			"ajaxUrl": "<?= $this->location('datatables/init'); ?>",
			"domTable": "#datatables"
		} );

		var oTable = $('#datatables').dataTable( {
			"sAjaxSource": "<?= $this->location('datatables/init'); ?>", 
			"bProcessing": true,
			"bServerSide": true,
			"sServerMethod": "POST", 
			"iDisplayLength": 50,
			"aLengthMenu": [[50, 100, 200, -1], [50, 100, 200, "All"]],
			"aoColumns": [
			{ "mDataProp": "NIDNNTBDOS","sWidth": "auto" },
			{ "mDataProp": "NOKTPTBDOS","sWidth": "auto" },
			{ "mDataProp": "NMDOSTBDOS","sWidth": "auto" },
			{ "mDataProp": "TPLHRTBDOS","sWidth": "auto" },
			{ "mDataProp": "TGLHRTBDOS","sWidth": "auto" }
			],
			"oTableTools": {
				"sRowSelect": "multi",
				"sSwfPath": "<?= $this->uri->baseUri;?>assets/default/js/plugins/dataTables/copy_csv_xls_pdf.swf",
				/*
				"aButtons": [
					{ "sExtends": "editor_create", "editor": editor,"sButtonText":"New", },
					{ "sExtends": "editor_edit",   "editor": editor,"sButtonText":"Edit", },
					{ "sExtends": "editor_remove", "editor": editor,"sButtonText":"Delete", },
					
					{ "sExtends":
						"gotoURL",
						"sButtonText":"goto URL",
						"sGoToURL": "<?php echo $this->location('datatables/edit');?>",
						"fnClick": function( nButton, oConfig ) {
							if($(nButton).hasClass('disabled')) {
								return false;
							};
							var d = this.fnGetSelectedData();
							tabel_role(d[0].DT_RowId);
						}
					},
					
					{"sExtends":"gotoURL","sButtonText":"Edit2","sGoToURL": "datatables/edit/","sParams":true},	
					"copy",
					"print",
					{
						"sExtends":    "collection",
						"sButtonText": 'Save <span class="caret" />',
						"aButtons":    [ "csv", "xls", "pdf" ]
					}
				]
				*/
				
				"aButtons": [
				{"sExtends":"gotoURL","sButtonText":"New","sGoToURL": "datatables/add","fnInit":null,"fnSelect":null},	
				{"sExtends":"gotoURL","sButtonText":"Edit","sGoToURL": "datatables/edit/","sParams":true},	
				{"sExtends":"editor_remove","editor": editor }
				]
				
			}
		}).columnFilter({
			sPlaceHolder: "head:after"
		});
	} );
</script>