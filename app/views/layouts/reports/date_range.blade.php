<div class="col-md-3">
	<div id='date' class="panel panel-default">
		<div class="panel-heading">Date</div>
		<div class="panel-body">    

			<div id="range-from">

				<div class="row">

					<div class="col-md-4 weekly">
						<label for="">Week</label>
					</div>

					<div class="col-md-4 weekly monthly">
						<label for="">Month</label>
					</div>

					<div class="col-md-4 quaterly">
						<label for="">Quarter</label>
					</div>

					<div class="col-md-4 weekly monthly quaterly yearly">
						<label for="">Year</label>
					</div>

				</div>

				<div class="row">	  		
					<div class="col-md-4 weekly">
						<select class="col-sm-2 select">
							@for($i=1;$i<=4;$i++)
							<option>{{{$i}}}</option>
							@endfor
						</select>
					</div>

					<div class="col-md-4 weekly monthly">
						<select class="col-sm-2 select">
							@for($i=1;$i<=12;$i++)
							<option>{{{$i}}}</option>
							@endfor
						</select>
					</div>

					<div class="col-md-4 quaterly">
						<select class="col-sm-3 select">
							@for($i=1;$i<=4;$i++)
							<option>{{{$i}}}</option>
							@endfor
						</select>
					</div>

					<div class="col-md-4 weekly monthly quaterly yearly">
						<select class="col-sm-3 select">
							@for($i=2014;$i<=2017;$i++)
							<option>{{{$i}}}</option>
							@endfor
						</select>
					</div>

				</div>

			</div>

			<div id="range-to">
				
				<div class="row">

					<div class="col-md-4 weekly">
						<label for="">Week</label>
					</div>

					<div class="col-md-4 weekly monthly">
						<label for="">Month</label>
					</div>

		    	<div class="col-md-4 quaterly">
		    		<label for="">Quarter</label>
		    	</div>

		    	<div class="col-md-4 weekly monthly quaterly yearly">
		    		<label for="">Year</label>
		    	</div>

		    	</div>

			    <div class="row">	
			    	<div class="col-md-4 weekly">
			    		<select class="col-sm-4 select">
			    			@for($i=1;$i<=4;$i++)
			    			<option>{{{$i}}}</option>
			    			@endfor
			    		</select>
			    	</div>

			    	<div class="col-md-4 weekly monthly">
			    		<select class="col-sm-4 select">
			    			@for($i=1;$i<=12;$i++)
			    			<option>{{{$i}}}</option>
			    			@endfor
			    		</select>
			    	</div>

			    	<div class="col-md-4 quaterly">
			    		<select class="col-sm-3 select">
			    			@for($i=1;$i<=4;$i++)
			    			<option>{{{$i}}}</option>
			    			@endfor
			    		</select>
			    	</div>

			    	<div class="col-md-4 weekly monthly quaterly yearly">
			    		<select class="col-sm-4 select">
			    			@for($i=2014;$i<=2017;$i++)
			    			<option>{{{$i}}}</option>
			    			@endfor
			    		</select>
			    	</div>

			    </div>

		</div>
	</div>