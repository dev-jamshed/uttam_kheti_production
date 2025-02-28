<address class="fs-sm mb-0">
    <strong>{{ $address->address }}</strong>
</address>

@if($address->area)
    <strong>{{ localize('Area') }}:</strong> {{ $address->area->name }}
    <br>
@endif

<strong>{{ localize('City') }}: </strong>{{ $address->city->name }}
<br>

<strong>{{ localize('State') }}: </strong>{{ $address->state->name }}
<br>

<strong>{{ localize('Country') }}: </strong> {{ $address->country->name }}
