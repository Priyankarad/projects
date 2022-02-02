@if(count($list))
@php $sl = 1; @endphp
@foreach($list as $list1)
<tr>
	<td>{{$sl}}</td>
	<td>{{ date("m/d/Y",$list1->manual_date) }}</td>
	<td>{{ $list1->manual_amount }}</td>
	@if($list1->negociation==0)
	<td>No</td>
	@elseif($list1->negociation==1)
	<td>Yes</td>
	@endif
</tr>
@php $sl++; @endphp
@endforeach
@endif