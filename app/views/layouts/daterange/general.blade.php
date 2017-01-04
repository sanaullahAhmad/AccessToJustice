<div style="display:none;" id="picker">

	<div style="display:none;" data-type="Weekly" class="first left">

		<div style="height:35px;"></div>
		<label class="col-md-4">Select Month </label>
		<div class="col-md-6">
			<select class="select" name="month" id="center">
			
				@foreach($data['months'] as $month)
					<option value="{{$month[0]}}">{{$month[1]}}</month>
				@endforeach
			</select>
		</div>
		<br>
		<div style="height:35px;"></div>
		<label class="col-md-4">Select Year </label>
		<div class="col-md-6">
			<select class="select" name="month" id="center">
				
				@for($i=$data['years']['start'];$i<=$data['years']['end'];$i++)
					<option value="{{$i}}">{{$i}}</option>
				@endfor
			</select>
		</div>
		
	</div>
	<div style="display:none;" data-type="Monthly" class="first left">
		<div style="height:35px;"></div>
		<label class="col-md-4">Select Year </label>
		<div class="col-md-6">
			<select class="select" name="month" id="center">
				
				@for($i=$data['years']['start'];$i<=$data['years']['end'];$i++)
					<option value="{{$i}}">{{$i}}</option>
				@endfor
			</select>
		</div>
	</div>
	<div style="display:none;" data-type="Quaterly" class="first left">
		<div style="height:35px;"></div>
		<label class="col-md-4">Select Year </label>
		<div class="col-md-6">
			<select class="select" name="month" id="center">
				<option value="">Year</option>
				@for($i=$data['years']['start'];$i<=$data['years']['end'];$i++)
					<option value="{{$i}}">{{$i}}</option>
				@endfor
			</select>
		</div>
	</div>
	<div style="display:none;" data-type="Bi-Quaterly" class="first left">
		<div style="height:35px;"></div>
		<label class="col-md-4">Select Year </label>
		<div class="col-md-6">
			<select class="select" name="month" id="center">
				<option value="">Year</option>
				@for($i=$data['years']['start'];$i<=$data['years']['end'];$i++)
					<option value="{{$i}}">{{$i}}</option>
				@endfor
			</select>
		</div>
	</div>
	<div style="display:none;" data-type="Yearly" class="first left">

		<div style="height:35px;"></div>
		<label class="col-md-4">From Year</label>
		<div class="col-md-6">
			<select class="select" name="month" id="center">
				
				@for($i=$data['years']['start'];$i<=$data['years']['end'];$i++)
					<option value="{{$i}}">{{$i}}</option>
				@endfor
			</select>
		</div>
		<br>
		<div style="height:35px;"></div>
		<label class="col-md-4">To Year</label>
		<div class="col-md-6">
			<select class="select" name="month" id="center">

				@for($i=$data['years']['start'];$i<=$data['years']['end'];$i++)
					<option value="{{$i}}">{{$i}}</option>
				@endfor
			</select>
		</div>
	</div>

	<div class="ranges">
		<ul>
			<li>Weekly</li>
			<li>Monthly</li>
			<li>Quaterly</li>
			<li>Bi-Quaterly</li>
			<li>Yearly</li>
		</ul>
		<button id="daterange_apply" class="applyBtn btn btn-small btn-sm btn-success">Apply</button>&nbsp;
		<button id="daterange_cancel" class="cancelBtn btn btn-small btn-sm btn-default">Cancel</button>
	</div>
</div>