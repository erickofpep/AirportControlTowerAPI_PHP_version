<div class="row">
    <div class="col-md-12 m-3">
   <h4>Aircraft Communications</h4>
  </div>
  </div>
<div class="col-md-12 tblWrap">

<table class="mb-0 table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Aircraft call sign</th>
                                                    <th>Type</th>
                                                    <th>State /Intent</th>
                                                    <th>Control Tower <br />respsonse (outcome)</th>
                                                    <th>Date/time</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
@php
$num=1;
$fetchComms= App\aircraftCommunications::orderBy('id', 'desc')->paginate(5);
@endphp

@foreach($fetchComms as $details)

<tr>
<th scope="row">{{ $num++ }}</td>
<td>{{ $details->aircraft_call_sign }}</td>
<td>{{ $details->type }}</td>
<td>{{ $details->state }}</td>
<td >{{ $details->outcome }}</td>
<td>{{ $details->created_at }}
</td>
<td>{{ $details->created_at }}</td>
</tr>
@endforeach
    </tbody>
</table>
  <div class="col-md-12 pgntn">
  {{ $fetchComms->links() }}
 </div>                                      
</div>